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
    return view('welcome');
});

Route::get('/formular', [FormController::class, 'show'])->name('form.show');
Route::post('/formular', [FormController::class, 'store'])->name('form.store');
Route::get('/coupon/{coupon}', [FormController::class, 'success'])->name('form.success');
Route::get('/coupons/{coupon}/view', [FormController::class, 'viewCoupon'])->name('coupons.view');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::post('/coupons/redeem', [DashboardController::class, 'redeem'])
    ->middleware(['auth'])
    ->name('coupons.redeem');

Route::delete('/users/{user}', [DashboardController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');

Route::get('/archived', function () {
    return view('archived'); // You can use any view
});

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
