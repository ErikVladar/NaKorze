<x-app-layout>
    <div id="form" class="relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto">
            <h2 class="text-3xl font-bold text-white mb-4">
                {{ __('formular.form_title') }}
            </h2>
            <p class="mb-6 text-gray-400">
                {{ __('formular.form_description') }}
            </p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-900 border border-red-700 rounded">
                    <ul class="list-disc list-inside text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-900 border border-green-700 rounded">
                    <p class="text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('form.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">
                        {{ __('formular.form_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        placeholder="{{ __('formular.form_name_placeholder') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">
                        {{ __('formular.form_email') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        placeholder="{{ __('formular.form_email_placeholder') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300">
                        {{ __('formular.form_phone') }}
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                        placeholder="{{ __('formular.form_phone_placeholder') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-300">
                        {{ __('formular.form_message') }}
                    </label>
                    <textarea name="message" id="message" rows="5" placeholder="{{ __('formular.form_message_placeholder') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GDPR Consent -->
                <div class="flex items-start">
                    <input type="checkbox" name="gdpr_consent" id="gdpr_consent" value="1"
                        @if (old('gdpr_consent')) checked @endif required
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded" />
                    <label for="gdpr_consent" class="ms-3 block text-sm font-medium text-gray-300">
                        {{ __('formular.form_gdpr_consent') }} <span class="text-red-500">*</span>
                    </label>
                </div>
                @error('gdpr_consent')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full inline-flex justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-gray-800 transition">
                        {{ __('formular.form_submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
