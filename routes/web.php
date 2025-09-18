<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;

use App\Http\Controllers\ContactController;

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


Route::get('/set-locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->query('locale');

    if (in_array($locale, ['en', 'sk', 'de'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('set-locale');

// Test route
Route::get('/', function () {
    return view('welcome'); // You can use any view
});

Route::get('/archived', function () {
    return view('archived'); // You can use any view
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


require __DIR__.'/auth.php';
