<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\City;
use App\Models\Coupon;
use App\Models\InstagramUnlockRequest;
use App\Mail\CouponMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Show the form.
     */
    public function show()
    {
        $unlockToken = (string) session('dm_unlock_token', '');

        Log::info('dm_unlock.form_show.start', [
            'has_session_token' => $unlockToken !== '',
            'session_id' => substr((string) session()->getId(), 0, 12),
        ]);

        if ($unlockToken === '') {
            $unlockToken = strtoupper(Str::random(10));
            session(['dm_unlock_token' => $unlockToken]);

            Log::info('dm_unlock.form_show.token_generated', [
                'token_masked' => $this->maskToken($unlockToken),
            ]);
        }

        InstagramUnlockRequest::firstOrCreate(
            ['unlock_token' => $unlockToken],
            ['status' => 'pending']
        );

        $unlockRequest = InstagramUnlockRequest::where('unlock_token', $unlockToken)->first();

        Log::info('dm_unlock.form_show.request_loaded', [
            'token_masked' => $this->maskToken($unlockToken),
            'request_exists' => $unlockRequest !== null,
            'request_id' => $unlockRequest?->id,
            'status' => $unlockRequest?->status,
        ]);

        if ($unlockRequest && $unlockRequest->status === 'consumed') {
            $oldToken = $unlockToken;
            $unlockToken = strtoupper(Str::random(10));
            session(['dm_unlock_token' => $unlockToken]);

            $unlockRequest = InstagramUnlockRequest::create([
                'unlock_token' => $unlockToken,
                'status' => 'pending',
            ]);

            Log::info('dm_unlock.form_show.consumed_replaced', [
                'old_token_masked' => $this->maskToken($oldToken),
                'new_token_masked' => $this->maskToken($unlockToken),
                'new_request_id' => $unlockRequest->id,
            ]);
        }

        $cities = City::orderBy('name')->get();

        Log::info('dm_unlock.form_show.ready', [
            'token_masked' => $this->maskToken($unlockToken),
            'status' => $unlockRequest?->status,
        ]);

        return view('formular', compact('cities', 'unlockToken', 'unlockRequest'));
    }

    /**
     * Store personal information from form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'sex' => 'nullable|string|in:M,F,O',
            'city_id' => 'nullable|exists:cities,id',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:5000',
            'gdpr_consent' => 'required|accepted',
            'unlock_token' => 'required|string|max:64',
        ]);

        $submittedToken = strtoupper(trim((string) $validated['unlock_token']));
        $sessionToken = strtoupper(trim((string) session('dm_unlock_token', '')));

        Log::info('dm_unlock.form_store.received', [
            'submitted_token_masked' => $this->maskToken($submittedToken),
            'session_token_masked' => $this->maskToken($sessionToken),
            'email_hash' => sha1((string) $validated['email']),
        ]);

        if ($sessionToken === '' || $submittedToken !== $sessionToken) {
            Log::warning('dm_unlock.form_store.token_mismatch', [
                'submitted_token_masked' => $this->maskToken($submittedToken),
                'session_token_masked' => $this->maskToken($sessionToken),
                'session_id' => substr((string) session()->getId(), 0, 12),
            ]);

            return back()
                ->withErrors([
                    'unlock_token' => __('formular.dm_unlock_invalid') ?? 'Unlock token is invalid. Please refresh the form and try again.',
                ])
                ->withInput();
        }

        $unlockRequest = InstagramUnlockRequest::where('unlock_token', $submittedToken)->first();

        Log::info('dm_unlock.form_store.request_lookup', [
            'token_masked' => $this->maskToken($submittedToken),
            'request_exists' => $unlockRequest !== null,
            'request_id' => $unlockRequest?->id,
            'status' => $unlockRequest?->status,
            'has_unlocked_at' => $unlockRequest?->unlocked_at !== null,
        ]);

        if (! $unlockRequest || ! $unlockRequest->unlocked_at || $unlockRequest->status !== 'unlocked') {
            Log::warning('dm_unlock.form_store.not_unlocked', [
                'token_masked' => $this->maskToken($submittedToken),
                'request_exists' => $unlockRequest !== null,
                'status' => $unlockRequest?->status,
                'has_unlocked_at' => $unlockRequest?->unlocked_at !== null,
            ]);

            return back()
                ->withErrors([
                    'unlock_token' => __('formular.dm_unlock_required') ?? 'To unlock this form, follow us on Instagram and send the unlock DM keyword with your token.',
                ])
                ->withInput();
        }

        // Check if this email already has an active (non-redeemed) coupon
        $existingCoupon = Coupon::where('email', $validated['email'])
            ->where('is_redeemed', false)
            ->first();

        Log::info('dm_unlock.form_store.coupon_lookup', [
            'email_hash' => sha1((string) $validated['email']),
            'has_active_coupon' => $existingCoupon !== null,
            'existing_coupon_id' => $existingCoupon?->id,
        ]);

        if ($existingCoupon) {
            return back()->with('error', __('formular.email_already_has_coupon') ?? 'This email address already has an active coupon.');
        }

        $unlockRequest->email = $validated['email'];
        $unlockRequest->status = 'consumed';
        $unlockRequest->save();

        Log::info('dm_unlock.form_store.request_consumed', [
            'request_id' => $unlockRequest->id,
            'token_masked' => $this->maskToken($submittedToken),
            'email_hash' => sha1((string) $validated['email']),
        ]);

        $validated['consent_date'] = now();
        unset($validated['unlock_token']);

        $personalInfo = PersonalInformation::create($validated);

        Log::info('dm_unlock.form_store.personal_info_created', [
            'personal_information_id' => $personalInfo->id,
            'email_hash' => sha1((string) $validated['email']),
        ]);

        // Generate coupon for this submission
        $coupon = Coupon::create([
            'code' => Coupon::generateCode(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'valid_from' => now()->toDateString(),
            'valid_until' => now()->addMonths(3)->toDateString(),
            'personal_information_id' => $personalInfo->id,
        ]);

        Log::info('dm_unlock.form_store.coupon_created', [
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'email_hash' => sha1((string) $validated['email']),
        ]);

        // Send coupon details to the user's email
        try {
            Mail::to($validated['email'])->send(new CouponMail($coupon));

            Log::info('dm_unlock.form_store.mail_sent', [
                'coupon_id' => $coupon->id,
                'email_hash' => sha1((string) $validated['email']),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't crash — user still gets coupon
            Log::error('Failed to send coupon email: ' . $e->getMessage(), [
                'email' => $validated['email'],
                'coupon_code' => $coupon->code,
            ]);
        }

        Log::info('dm_unlock.form_store.success_redirect', [
            'coupon_id' => $coupon->id,
        ]);

        return redirect()->route('form.success', $coupon->id);
    }

    private function maskToken(string $token): string
    {
        if ($token === '') {
            return '';
        }

        if (strlen($token) <= 4) {
            return Str::mask($token, '*', 0);
        }

        return substr($token, 0, 2) . '***' . substr($token, -2);
    }

    /**
     * Show success page with coupon and QR code.
     */
    public function success(Coupon $coupon)
    {
        return view('form-success', compact('coupon'));
    }

    /**
     * Show coupon view from QR code or redeem action.
     */
    public function viewCoupon(Request $request, $code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();

        // If the requester is not authenticated, show an info-only screen
        // Guests are not allowed to redeem coupons — only authenticated users may.
        if (! Auth::check()) {
            return view('coupons.view-info', compact('coupon'));
        }

        // If coupon is redeemed but was just redeemed via dashboard, show the green "just redeemed" confirmation
        if ($coupon->is_redeemed) {
            if ($request->session()->pull('just_redeemed')) {
                // show the available/confirmation view once
                return view('coupons.view-available', compact('coupon'))->with('just_redeemed', true);
            }

            // Already redeemed previously — show the red redeemed view
            return view('coupons.view-redeemed', compact('coupon'));
        }

        // Not redeemed — show the green available view
        return view('coupons.view-available', compact('coupon'));
    }
}