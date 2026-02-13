<x-app-layout>
    <div id="form" class="font-mono relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
                <!-- Status Badge -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">
                    {{ __('formular.coupon_redeemed') ?? 'Coupon Redeemed' }}
                </h1>

                <!-- Coupon Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="space-y-4">
                        <!-- Code -->
                        <div>
                            <p class="text-sm text-gray-600">{{ __('dashboard.code') }}</p>
                            <p class="text-lg font-mono font-semibold text-gray-800">{{ $coupon->code }}</p>
                        </div>

                        <!-- Benefit -->
                        <div>
                            <p class="text-sm text-gray-600">{{ __('dashboard.benefit') ?? 'Benefit' }}</p>
                            <p class="text-lg font-bold text-green-600">{{ __('formular.free_drink') ?? '1 Free Drink' }}</p>
                        </div>

                        <!-- Valid Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">{{ __('dashboard.valid_from') }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $coupon->valid_from->format('d.m.Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ __('dashboard.valid_until') }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $coupon->valid_until->format('d.m.Y') }}</p>
                            </div>
                        </div>

                        <!-- Redemption Info -->
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">{{ __('formular.redeemed_at') ?? 'Redeemed' }}</p>
                            @if ($coupon->redeemed_at)
                                <p class="text-sm font-semibold text-gray-800">{{ $coupon->redeemed_at->format('d.m.Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Alert Message -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-800 text-sm font-semibold">
                        ✗ {{ __('formular.coupon_already_used') ?? 'This coupon has been redeemed.' }}
                    </p>
                </div>

                <!-- Back Button -->
                <a href="/home" class="block w-full text-center py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    {{ __('formular.back_home') ?? 'Back to Home' }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
