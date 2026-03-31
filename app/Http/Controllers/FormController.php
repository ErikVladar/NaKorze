<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\City;
use App\Models\Coupon;
use App\Mail\CouponMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    /**
     * Show the form.
     */
    public function show()
    {
        $cities = City::orderBy('name')->get();
        $isInstagramCodeUnlocked = (bool) session('instagram_coupon_unlocked', false);

        Log::info('ig_gate.form_show.ready', [
            'steps_mode' => 'follow_dm_code',
            'is_unlocked' => $isInstagramCodeUnlocked,
        ]);

        return view('formular', compact('cities', 'isInstagramCodeUnlocked'));
    }

    public function unlockInstagramGate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'instagram_coupon_code' => 'required|string|max:100',
        ]);

        $expectedCode = (string) config('services.instagram.coupon_code', 'na_korze_kupon_2000');
        $submittedCode = mb_strtolower(trim((string) $validated['instagram_coupon_code']));
        $normalizedExpected = mb_strtolower(trim($expectedCode));

        Log::info('ig_gate.unlock_attempt', [
            'submitted_code_length' => strlen($submittedCode),
            'expected_code_length' => strlen($normalizedExpected),
            'session_id' => substr((string) session()->getId(), 0, 12),
        ]);

        if ($submittedCode === '' || $submittedCode !== $normalizedExpected) {
            Log::warning('ig_gate.unlock_failed', [
                'submitted_code_length' => strlen($submittedCode),
                'expected_code_length' => strlen($normalizedExpected),
            ]);

            return back()
                ->withErrors([
                    'instagram_coupon_code' => __('formular.instagram_code_invalid') ?? 'Nesprávny kód. Skontrolujte správu z Instagramu a skúste to znova.',
                ])
                ->withInput();
        }

        session(['instagram_coupon_unlocked' => true]);

        Log::info('ig_gate.unlock_success', [
            'session_id' => substr((string) session()->getId(), 0, 12),
        ]);

        return redirect()->route('form.show')->with('success', __('formular.instagram_unlocked_success'));
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
        ]);

        $isInstagramCodeUnlocked = (bool) session('instagram_coupon_unlocked', false);

        Log::info('ig_gate.form_store.received', [
            'is_unlocked' => $isInstagramCodeUnlocked,
            'email_hash' => sha1((string) $validated['email']),
        ]);

        if (! $isInstagramCodeUnlocked) {
            Log::warning('ig_gate.form_store.blocked_not_unlocked', [
                'session_id' => substr((string) session()->getId(), 0, 12),
            ]);

            return redirect()->route('form.show')
                ->withErrors([
                    'instagram_coupon_code' => __('formular.instagram_unlock_required') ?? 'Najprv zadajte správny kód z Instagram správy.',
                ]);
        }

        // Check if this email already has an active (non-redeemed) coupon
        $existingCoupon = Coupon::where('email', $validated['email'])
            ->where('is_redeemed', false)
            ->first();

        Log::info('ig_gate.form_store.coupon_lookup', [
            'email_hash' => sha1((string) $validated['email']),
            'has_active_coupon' => $existingCoupon !== null,
            'existing_coupon_id' => $existingCoupon?->id,
        ]);

        if ($existingCoupon) {
            return back()->with('error', __('formular.email_already_has_coupon') ?? 'This email address already has an active coupon.');
        }

        $validated['consent_date'] = now();

        $personalInfo = PersonalInformation::create($validated);

        Log::info('ig_gate.form_store.personal_info_created', [
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

        $coupon->ensureQrCodeSaved();

        Log::info('ig_gate.form_store.coupon_created', [
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'email_hash' => sha1((string) $validated['email']),
        ]);

        // Send coupon details to the user's email
        try {
            Mail::to($validated['email'])->send(new CouponMail($coupon));

            Log::info('ig_gate.form_store.mail_sent', [
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

        Log::info('ig_gate.form_store.success_redirect', [
            'coupon_id' => $coupon->id,
        ]);

        return redirect()->route('form.success', $coupon->id);
    }

    /**
     * Show success page with coupon and QR code.
     */
    public function success(Coupon $coupon)
    {
        $coupon->ensureQrCodeSaved();

        return view('form-success', compact('coupon'));
    }

    /**
     * Show coupon view from QR code or redeem action.
     */
    public function viewCoupon(Request $request, $code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();
        $coupon->ensureQrCodeSaved();

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