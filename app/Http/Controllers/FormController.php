<?php

namespace App\Http\Controllers;

use App\Models\PersonalInformation;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Show the form.
     */
    public function show()
    {
        return view('formular');
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
            'message' => 'nullable|string|max:5000',
            'gdpr_consent' => 'required|accepted',
        ]);

        $validated['consent_date'] = now();

        $personalInfo = PersonalInformation::create($validated);

        // Generate coupon for this submission
        $coupon = Coupon::create([
            'code' => Coupon::generateCode(),
            'discount_percent' => 10, // 10% discount
            'valid_from' => now()->toDateString(),
            'valid_until' => now()->addMonths(3)->toDateString(),
            'personal_information_id' => $personalInfo->id,
        ]);

        return redirect()->route('form.success', $coupon->id);
    }

    /**
     * Show success page with coupon and QR code.
     */
    public function success(Coupon $coupon)
    {
        return view('form-success', compact('coupon'));
    }
}