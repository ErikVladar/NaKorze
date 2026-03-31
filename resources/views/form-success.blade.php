<x-app-layout>
    <div id="form" class="relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto text-center">
            <!-- Success Message -->
            <div class="mb-8">
                <svg class="mx-auto h-16 w-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-2xl font-bold text-white">{{ __('formular.success_message') }}</h3>
                <p class="mt-2 text-gray-300">{{ __('formular.coupon_reward_text') }}</p>
            </div>

            <!-- Coupon Code Section -->
            <div class="mb-8 p-6 bg-gray-700 rounded-lg border-2 border-dashed border-gray-500">
                <p class="text-sm text-gray-400 mb-2">{{ __('formular.your_coupon_code') }}</p>
                <p class="text-4xl font-bold text-green-100 font-mono tracking-wider">
                    {{ $coupon->code }}
                </p>
                <p class="mt-4 text-lg font-semibold text-green-400">
                    {{ __('formular.discount') }}
                </p>
                <div class="mt-4 flex flex-col sm:flex-row gap-2 justify-center text-sm text-gray-400">
                    <span>{{ __('formular.valid_from') }}: <strong>{{ $coupon->valid_from->format('Y-m-d') }}</strong></span>
                    <span class="hidden sm:inline">•</span>
                    <span>{{ __('formular.valid_until') }}: <strong>{{ $coupon->valid_until->format('Y-m-d') }}</strong></span>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="mb-8">
                <p class="text-sm text-gray-400 mb-4">{{ __('formular.qr_code_label') }}</p>
                <div class="flex justify-center bg-gray-700 p-4 rounded-lg border border-gray-500">
                    {!! $coupon->getQrCode() !!}
                </div>
                <p class="mt-2 text-xs text-gray-500">{{ __('formular.qr_code_instructions') }}</p>
            </div>

            <!-- Coupon Details -->
            <div class="mb-8 p-4 bg-gray-700 rounded-lg text-left border border-gray-600">
                <h4 class="font-semibold text-yellow-300 mb-2">{{ __('formular.how_to_use') }}</h4>
                <ul class="text-sm text-gray-300 space-y-1 list-disc list-inside">
                    <li>{{ __('formular.coupon_how_to_1') }}</li>
                    <li>{{ __('formular.coupon_how_to_2') }}</li>
                    <li>{{ __('formular.coupon_how_to_3') }}</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                {{-- <a href="{{ route('form.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500 transition">
                    {{ __('formular.submit_another_form') }}
                </a> --}}
                <a href="/" class="inline-flex items-center px-4 py-2 bg-stone-400 text-white rounded-md hover:bg-stone-500 transition">
                    {{ __('formular.back_home') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
