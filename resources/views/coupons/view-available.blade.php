<x-app-layout>
    <div id="form" class="relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto flex items-center justify-center min-h-screen">
            <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
                <!-- Status Badge -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">
                    {{ __('formular.coupon_available') ?? 'Coupon Available' }}
                </h1>

                @if(session('just_redeemed') || (!empty($just_redeemed) && $just_redeemed))
                    <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-green-800 text-center">
                        {{ session('success') ?? __('dashboard.coupon_redeemed_success', ['code' => $coupon->code]) }}
                    </div>
                @endif
                <!-- Coupon Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="space-y-4">
                        <!-- Recipient Name -->
                        <div>
                            <p class="text-sm text-gray-600">{{ __('dashboard.name') ?? 'Name' }}</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $coupon->name }}</p>
                        </div>
                        <!-- Code -->
                        <div>
                            <p class="text-sm text-gray-600">{{ __('dashboard.code') }}</p>
                            <p class="text-lg font-mono font-semibold text-gray-800">{{ $coupon->code }}</p>
                        </div>

                        <!-- Benefit -->
                        <div>
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
                    </div>
                </div>

                <!-- Redeem Button -->
                @auth
                    @if (!$coupon->is_redeemed)
                        <form method="POST" action="{{ route('coupons.confirm-redeem', $coupon->code) }}" class="space-y-3">
                            @csrf
                            <button type="submit" class="block w-full text-center py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                {{ __('dashboard.redeem') ?? 'Redeem' }}
                            </button>
                        </form>
                    @endif
                @else
               
                @endauth

                 <br>

                <!-- Back Button -->
                <a href="/home" class="block w-full text-center py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                    {{ __('formular.back_home') ?? 'Back to Home' }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
