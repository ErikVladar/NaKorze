<x-app-layout>
    <div class="font-mono bg-stone-900 relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto max-w-2xl">
            <h2 class="text-3xl font-bold text-white mb-6">
                {{ __('dashboard.personal_info_details') }}
            </h2>

            <div class="bg-gray-800 rounded-lg p-6 space-y-6">
                <!-- Name -->
                <div class="border-b border-gray-700 pb-4">
                    <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.full_name') }}</p>
                    <p class="text-white text-lg">{{ $personalInformation->name }}</p>
                </div>

                <!-- Email -->
                <div class="border-b border-gray-700 pb-4">
                    <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.email_address') }}</p>
                    <p class="text-white text-lg">{{ $personalInformation->email }}</p>
                </div>

                <!-- Phone -->
                @if ($personalInformation->phone)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.phone_number') }}</p>
                        <p class="text-white text-lg">{{ $personalInformation->phone }}</p>
                    </div>
                @endif

                <!-- Sex/Gender -->
                @if ($personalInformation->sex)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.gender') }}</p>
                        <p class="text-white text-lg">
                            @if ($personalInformation->sex === 'M')
                                {{ __('formular.form_sex_male') }}
                            @elseif ($personalInformation->sex === 'F')
                                {{ __('formular.form_sex_female') }}
                            @endif
                        </p>
                    </div>
                @endif

                <!-- City -->
                @if ($personalInformation->city)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.city') }}</p>
                        <p class="text-white text-lg">
                            {{ $personalInformation->city->name }}
                            @if ($personalInformation->city->postal_code)
                                <span class="text-gray-400">({{ $personalInformation->city->postal_code }})</span>
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Postal Code -->
                @if ($personalInformation->postal_code)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.postal_code') }}</p>
                        <p class="text-white text-lg">{{ $personalInformation->postal_code }}</p>
                    </div>
                @endif

                <!-- Street Address -->
                @if ($personalInformation->address)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.address') }}</p>
                        <p class="text-white text-lg whitespace-pre-line">{{ $personalInformation->address }}</p>
                    </div>
                @endif

                <!-- Message -->
                @if ($personalInformation->message)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.message') }}</p>
                        <p class="text-white text-lg whitespace-pre-line">{{ $personalInformation->message }}</p>
                    </div>
                @endif

                <!-- Consent Date -->
                <div class="border-b border-gray-700 pb-4">
                    <p class="text-gray-400 text-sm font-medium mb-2">{{ __('dashboard.consent_date') }}</p>
                    <p class="text-white text-lg">{{ $personalInformation->consent_date->format('d.m.Y H:i') }}</p>
                </div>

                <!-- Related Coupons -->
                @if ($personalInformation->coupons && $personalInformation->coupons->count() > 0)
                    <div class="border-b border-gray-700 pb-4">
                        <p class="text-gray-400 text-sm font-medium mb-4">{{ __('dashboard.related_coupons') }}</p>
                        <div class="space-y-3">
                            @foreach ($personalInformation->coupons as $coupon)
                                <div class="bg-gray-700 p-4 rounded-lg">
                                    <p class="text-white font-mono font-bold">{{ $coupon->code }}</p>
                                    <p class="text-gray-300 text-sm mt-1">
                                        {{ __('dashboard.valid_dates') }}: {{ $coupon->valid_from->format('d.m.Y') }} - {{ $coupon->valid_until->format('d.m.Y') }}
                                        @if ($coupon->is_redeemed)
                                            <span class="text-red-400 font-medium">({{ __('dashboard.redeemed_status') }})</span>
                                        @else
                                            <span class="text-green-400 font-medium">({{ __('dashboard.active_status') }})</span>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="mt-8">
                <a href="{{ route('dashboard') }}" class="inline-flex px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                    ← {{ __('dashboard.back_to_dashboard') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
