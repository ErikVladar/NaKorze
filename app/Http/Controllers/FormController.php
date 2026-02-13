<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\City;
use App\Models\Coupon;
use App\Mail\CouponMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view('formular', compact('cities'));
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

        // Check if this email already has an active (non-redeemed) coupon
        $existingCoupon = Coupon::where('email', $validated['email'])
            ->where('is_redeemed', false)
            ->first();

        if ($existingCoupon) {
            return back()->with('error', __('formular.email_already_has_coupon') ?? 'This email address already has an active coupon.');
        }

        $validated['consent_date'] = now();

        $personalInfo = PersonalInformation::create($validated);

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

        // Send coupon details to the user's email
        try {
            Mail::to($validated['email'])->send(new CouponMail($coupon));
        } catch (\Exception $e) {
            // Log the error but don't crash — user still gets coupon
            Log::error('Failed to send coupon email: ' . $e->getMessage(), [
                'email' => $validated['email'],
                'coupon_code' => $coupon->code,
            ]);
        }

        return redirect()->route('form.success', $coupon->id);
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
        if (! auth()->check()) {
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