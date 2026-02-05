<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('dashboard', compact('users', 'coupons'));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $current = Auth::user();

        if (! $current || ! $current->isAdmin()) {
            abort(403);
        }

        // prevent admin from deleting themselves accidentally
        if ($current->id === $user->id) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return back()->with('success', 'User deleted');
    }
}
