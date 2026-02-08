<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the users (for admin) and a simple dashboard for regular users.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Show admins only to admins
        if (! Auth::user()->isAdmin()) {
            $query->where('role', '!=', 'admin');
        }
        
        $users = $query->orderBy('id', 'asc')->paginate(15);
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(15);
        
        // Fetch personal information records
        $personalInfo = \App\Models\PersonalInformation::orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard', compact('users', 'coupons', 'personalInfo'));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $current = Auth::user();

        if (! $current) {
            abort(403);
        }

        // prevent admin from deleting themselves accidentally
        if ($current->id === $user->id) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return back()->with('success', 'User deleted');
    }

    /**
     * Redeem a coupon by id or code (admin only).
     */
    public function redeem(Request $request): RedirectResponse
    {
        $current = Auth::user();

        if (! $current || ! $current->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'code' => ['nullable', 'string'],
        ]);

        $coupon = null;

        if (! empty($data['coupon_id'])) {
            $coupon = Coupon::find($data['coupon_id']);
        } elseif (! empty($data['code'])) {
            $coupon = Coupon::where('code', $data['code'])->first();
        }

        if (! $coupon) {
            return back()->with('error', __('dashboard.coupon_not_found'));
        }

        if ($coupon->is_redeemed) {
            // Already redeemed - just redirect to show red view
            return redirect()->route('coupons.view', $coupon->code);
        }

            // Not yet redeemed - mark as redeemed and redirect to show green view once
            $coupon->is_redeemed = true;
            $coupon->redeemed_at = Carbon::now();
            $coupon->save();

            // Redirect with a one-time flag so the view can show the "just redeemed" green screen
            return redirect()->route('coupons.view', $coupon->code)
                ->with([
                    'just_redeemed' => true,
                    'success' => __('dashboard.coupon_redeemed_success', ['code' => $coupon->code]),
                ]);
    }
}
