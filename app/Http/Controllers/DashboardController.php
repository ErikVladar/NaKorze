<?php

namespace App\Http\Controllers;

use App\Mail\PersonalInformationMassMail;
use App\Models\User;
use App\Models\Coupon;
use App\Models\PersonalInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /**
     * Display a listing of the users (for admin) and a simple dashboard for regular users.
     */
    public function index(Request $request)
    {
        /** @var User|null $current */
        $current = Auth::user();

        abort_unless($current !== null, 403);

        $users = $this->usersQuery($request)->paginate(15)->withQueryString();
        $coupons = $this->couponsQuery($request)->paginate(15)->withQueryString();
        $personalInfo = $this->personalInfoQuery($request)->paginate(15)->withQueryString();

        return view('dashboard', compact('users', 'coupons', 'personalInfo'));
    }

    /**
     * Export coupons in an Excel-compatible format.
     */
    public function exportCoupons(Request $request): Response
    {
        $rows = $this->couponsQuery($request)->get()->map(function (Coupon $coupon) {
            $status = $coupon->is_redeemed
                ? __('dashboard.redeemed_status')
                : ($coupon->isValid() ? __('dashboard.valid') : __('dashboard.invalid'));

            return [
                __('dashboard.code') => $coupon->code,
                __('dashboard.discount') => $coupon->discount_percent.'%',
                __('dashboard.valid_from') => Carbon::parse($coupon->valid_from)->format('Y-m-d'),
                __('dashboard.valid_until') => Carbon::parse($coupon->valid_until)->format('Y-m-d'),
                __('dashboard.status') => $status,
                __('dashboard.redeemed') => $coupon->is_redeemed && $coupon->redeemed_at
                    ? $coupon->redeemed_at->format('Y-m-d H:i')
                    : '—',
            ];
        })->all();

        return $this->excelResponse('coupons', $rows);
    }

    /**
     * Export personal information rows in an Excel-compatible format.
     */
    public function exportPersonalInfo(Request $request): Response
    {
        $this->abortUnlessAdmin();

        $rows = $this->personalInfoQuery($request)->get()->map(function (PersonalInformation $info) {
            return [
                __('dashboard.name') => $info->name,
                __('dashboard.email') => $info->email,
                __('dashboard.phone') => $info->phone ?: '—',
                __('dashboard.city') => $info->city?->name ?: '—',
                __('dashboard.postal_code') => $info->postal_code ?: '—',
                __('dashboard.address') => $info->address ?: '—',
                __('dashboard.message') => $info->message ?: '—',
                __('dashboard.submitted') => $info->created_at->format('Y-m-d H:i'),
            ];
        })->all();

        return $this->excelResponse('personal-information', $rows);
    }

    /**
     * Export users in an Excel-compatible format.
     */
    public function exportUsers(Request $request): Response
    {
        $this->abortUnlessAdmin();

        $rows = $this->usersQuery($request)->get()->map(function (User $user) {
            return [
                __('dashboard.id') => (string) $user->id,
                __('dashboard.name') => $user->name,
                __('dashboard.email') => $user->email,
                __('dashboard.role') => $user->role ?? 'user',
                __('dashboard.joined') => $user->created_at->format('Y-m-d H:i'),
            ];
        })->all();

        return $this->excelResponse('users', $rows);
    }

    /**
     * Send a bulk email to personal information recipients from the filtered dataset.
     */
    public function sendPersonalInfoMassEmail(Request $request): RedirectResponse
    {
        $this->abortUnlessAdmin();

        $validated = $request->validate([
            'personal_query' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $emails = $this->personalInfoQuery($request)
            ->whereNotNull('email')
            ->pluck('email')
            ->map(fn (string $email) => trim($email))
            ->filter()
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            return back()->with('error', __('dashboard.no_email_recipients'));
        }

        foreach ($emails as $email) {
            Mail::to($email)->send(
                new PersonalInformationMassMail(
                    $validated['subject'],
                    $validated['message'],
                    Auth::user()?->name,
                )
            );
        }

        return back()->with('success', __('dashboard.mass_email_sent', ['count' => $emails->count()]));
    }

    /**
     * Show password edit page for a single user (admin only).
     */
    public function editUserPassword(User $user)
    {
        $this->abortUnlessAdmin();

        return view('users.edit-password', compact('user'));
    }

    /**
     * Update password for a single user (admin only).
     */
    public function updateUserPassword(Request $request, User $user): RedirectResponse
    {
        $this->abortUnlessAdmin();

        $validated = $request->validate([
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['user_password']),
        ])->save();

        return back()->with('success', __('dashboard.user_password_updated', ['name' => $user->name]));
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
     * Display detailed personal information.
     */
    public function showPersonalInfo(PersonalInformation $personalInformation)
    {
        return view('personal-information-detail', compact('personalInformation'));
    }

    /**
     * Redeem a coupon by id or code (all authenticated users).
     */
    public function redeem(Request $request): RedirectResponse
    {
        $current = Auth::user();

        if (! $current) {
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

        // Just redirect to the coupon view - actual redemption happens in view-available
        return redirect()->route('coupons.view', $coupon->code);
    }

    /**
     * Confirm and actually redeem a coupon.
     */
    public function confirmRedeem(string $code): RedirectResponse
    {
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) {
            return back()->with('error', __('dashboard.coupon_not_found'));
        }

        if ($coupon->is_redeemed) {
            // Already redeemed - just redirect to show red view
            return redirect()->route('coupons.view', $coupon->code);
        }

        // Mark as redeemed
        $coupon->is_redeemed = true;
        $coupon->redeemed_at = Carbon::now();
        $coupon->save();

        // Redirect with success message
        return redirect()->route('coupons.view', $coupon->code)
            ->with([
                'just_redeemed' => true,
                'success' => __('dashboard.coupon_redeemed_success', ['code' => $coupon->code]),
            ]);
    }

    private function abortUnlessAdmin(): void
    {
        /** @var User|null $current */
        $current = Auth::user();

        abort_unless($current?->isAdmin(), 403);
    }

    private function couponsQuery(Request $request)
    {
        $query = Coupon::query()->orderBy('created_at', 'desc');
        $search = trim((string) $request->string('coupon_query', $request->query('q', '')));
        $status = (string) $request->query('status', 'all');
        $today = now()->toDateString();

        if ($search !== '') {
            $query->where('code', 'like', '%'.$search.'%');
        }

        if ($status === 'valid') {
            $query->where('is_redeemed', false)
                ->whereDate('valid_from', '<=', $today)
                ->whereDate('valid_until', '>=', $today);
        }

        if ($status === 'invalid') {
            $query->where('is_redeemed', false)
                ->where(function ($invalidQuery) use ($today) {
                    $invalidQuery
                        ->whereDate('valid_from', '>', $today)
                        ->orWhereDate('valid_until', '<', $today);
                });
        }

        if ($status === 'redeemed') {
            $query->where('is_redeemed', true);
        }

        if ($status === 'not_redeemed') {
            $query->where('is_redeemed', false);
        }

        return $query;
    }

    private function personalInfoQuery(Request $request)
    {
        $query = PersonalInformation::query()->with('city')->orderBy('created_at', 'desc');
        $search = trim((string) $request->string('personal_query', $request->query('q', '')));

        if ($search !== '') {
            $query->where(function ($personalQuery) use ($search) {
                $personalQuery
                    ->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('message', 'like', '%'.$search.'%')
                    ->orWhere('postal_code', 'like', '%'.$search.'%')
                    ->orWhere('address', 'like', '%'.$search.'%')
                    ->orWhereHas('city', function ($cityQuery) use ($search) {
                        $cityQuery->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        return $query;
    }

    private function usersQuery(Request $request)
    {
        /** @var User|null $current */
        $current = Auth::user();

        $query = User::query()->orderBy('id', 'asc');
        $search = trim((string) $request->string('user_query', $request->query('q', '')));
        $role = (string) $request->query('role', 'all');

        if (! $current?->isAdmin()) {
            $query->where('role', '!=', 'admin');
        }

        if ($search !== '') {
            $query->where(function ($userQuery) use ($search) {
                $userQuery
                    ->where('id', 'like', '%'.$search.'%')
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        return $query;
    }

    private function excelResponse(string $baseName, array $rows): Response
    {
        $headers = array_keys($rows[0] ?? [__('dashboard.no_data') => '']);
        $filename = sprintf('%s-%s.xls', $baseName, now()->format('Ymd-His'));

        $html = '<html><head><meta charset="UTF-8"></head><body><table border="1"><thead><tr>';

        foreach ($headers as $header) {
            $html .= '<th>'.e($header).'</th>';
        }

        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';

            foreach ($headers as $header) {
                $html .= '<td>'.e((string) ($row[$header] ?? '')).'</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
