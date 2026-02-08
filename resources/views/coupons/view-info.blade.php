<x-app-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        <!-- Info Badge -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">
            {{ __('formular.coupon_details') ?? 'Coupon Details' }}
        </h1>

        <!-- Coupon Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <div class="space-y-4">
                <!-- Code -->
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.code') }}</p>
                    <p class="text-lg font-mono font-semibold text-gray-800">{{ $coupon->code }}</p>
                </div>

                <!-- Discount -->
                <div>
                    <p class="text-sm text-gray-600">{{ __('dashboard.discount') }}</p>
                    <p class="text-lg font-bold text-green-600">{{ $coupon->discount_percent }}%</p>
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

                <!-- Validity Status -->
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">{{ __('dashboard.status') }}</p>
                    @if ($coupon->isValid())
                        <div class="mt-2">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                {{ __('dashboard.valid') }}
                            </span>
                        </div>
                    @else
                        <div class="mt-2">
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                {{ __('dashboard.invalid') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="/" class="block w-full text-center py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                {{ __('formular.back_home') ?? 'Back to Home' }}
            </a>
        </div>
    </div>
    </div>
</x-app-layout>
