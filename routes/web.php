<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


Route::get('/set-locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->query('locale');

    if (in_array($locale, ['en', 'sk', 'de'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('set-locale');

Route::get('/', function () {

    $images = collect(glob(public_path('material/Napojak 2025/*.jpg')))
	    ->map(fn($path) => asset(str_replace(public_path(), '', $path)))
    	    ->sort()
    	    ->values();

    return view('welcome', compact("images"));
});

Route::get('/formular', [FormController::class, 'show'])->name('form.show');
Route::post('/formular/unlock', [FormController::class, 'unlockInstagramGate'])->name('form.unlock');
Route::post('/formular', [FormController::class, 'store'])->name('form.store');
Route::get('/coupon/{coupon}', [FormController::class, 'success'])->name('form.success');
Route::get('/coupons/{code}/view', [FormController::class, 'viewCoupon'])->name('coupons.view');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/dashboard/export/coupons', [DashboardController::class, 'exportCoupons'])
    ->middleware(['auth'])
    ->name('dashboard.export.coupons');

Route::get('/dashboard/export/personal-information', [DashboardController::class, 'exportPersonalInfo'])
    ->middleware(['auth'])
    ->name('dashboard.export.personal-information');

Route::get('/dashboard/export/users', [DashboardController::class, 'exportUsers'])
    ->middleware(['auth'])
    ->name('dashboard.export.users');

Route::post('/dashboard/personal-information/mass-email', [DashboardController::class, 'sendPersonalInfoMassEmail'])
    ->middleware(['auth'])
    ->name('dashboard.personal-information.mass-email');

Route::post('/dashboard/users/{user}/password', [DashboardController::class, 'updateUserPassword'])
    ->middleware(['auth'])
    ->name('dashboard.users.password');

Route::get('/dashboard/users/{user}/password/edit', [DashboardController::class, 'editUserPassword'])
    ->middleware(['auth'])
    ->name('dashboard.users.password.edit');

Route::get('/personal-information/{personalInformation}', [DashboardController::class, 'showPersonalInfo'])
    ->middleware(['auth'])
    ->name('personal-information.show');

Route::post('/coupons/redeem', [DashboardController::class, 'redeem'])
    ->middleware(['auth'])
    ->name('coupons.redeem');

Route::post('/coupons/{code}/confirm-redeem', [DashboardController::class, 'confirmRedeem'])
    ->middleware(['auth'])
    ->name('coupons.confirm-redeem');

Route::delete('/users/{user}', [DashboardController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');

Route::get('/archived', function () {
    return view('archived'); // You can use any view
});

// Home view with greeting, dashboard, and QR scanner for authenticated users
Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

// Debug route for testing coupon views (remove in production)
Route::get('/debug/test-coupon-views', function () {
    $coupons = \App\Models\Coupon::latest()->take(10)->get();
    return view('debug.test-coupon-views', compact('coupons'));
})->name('debug.test-coupon-views');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings routes (for tests compatibility)
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('settings.profile');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('/settings/profile', [ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    // Additional settings routes expected by views/tests
    Route::get('/settings/password', function () {
        return view('settings.password');
    })->name('settings.password');

    Route::get('/settings/appearance', function () {
        return view('settings.appearance');
    })->name('settings.appearance');
});

require __DIR__.'/auth.php';
