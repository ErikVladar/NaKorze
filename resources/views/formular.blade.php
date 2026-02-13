<x-app-layout>
    <div id="form"
        class="font-mono bg-stone-900 rounded-2xl relative z-10 overflow-visible group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div id="form"
                    class="font-mono bg-stone-900 rounded-2xl relative z-10 overflow-visible group w-full max-w-2xl bg-opacity-95 p-8 m-4">
                    <div class="w-full mx-auto"></div>
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
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-900 border border-red-700 rounded">
                            <p class="text-red-200">{{ session('error') }}</p>
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

                        <!-- Sex/Gender -->
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-300">
                                {{ __('formular.form_sex') }}
                            </label>
                            <select name="sex" id="sex" value="{{ old('sex') }}"
                                class="mt-1 block w-1/2 px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('formular.form_sex_placeholder') }}</option>
                                <option value="M" @if (old('sex') === 'M') selected @endif>
                                    {{ __('formular.form_sex_male') }}</option>
                                <option value="F" @if (old('sex') === 'F') selected @endif>
                                    {{ __('formular.form_sex_female') }}</option>
                            </select>
                            @error('sex')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street (Ulica) -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-300">
                                {{ __('formular.form_street') }}
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                placeholder="{{ __('formular.form_street_placeholder') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            @error('address')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Postal Code (PSČ) -->
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-300">
                                {{ __('formular.form_postal_code') }}
                            </label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                                placeholder="{{ __('formular.form_postal_code_placeholder') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div x-data="cityDropdown()" class="relative w-full">
                            <label for="city_id" class="block text-sm font-medium text-gray-300">
                                {{ __('formular.form_city') }}
                            </label>
                            <input type="text" x-model="search" @focus="open = true" @input="open = true"
                                @keydown.escape="open = false" @click.away="open = false"
                                placeholder="{{ __('formular.form_city_placeholder') }}" autocomplete="off"
                                class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm bg-gray-700 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                            <input type="hidden" name="city_id" :value="selected">

                            <!-- Dropdown -->
                            <div x-show="open && getFiltered().length > 0"
                                class="absolute left-0 top-full mt-1 w-full bg-gray-700 border border-gray-600 rounded-md shadow-lg z-[9999] max-h-60 overflow-y-auto">
                                <template x-for="city in getFiltered()" :key="city.id">
                                    <div @mousedown.prevent="selectCity(city)"
                                        class="px-3 py-2 cursor-pointer text-gray-100 hover:bg-blue-600">
                                        <span x-text="city.name"></span>
                                        <span class="text-gray-400 text-sm"
                                            x-text="city.postal_code ? ' (' + city.postal_code + ')' : ''"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- No results -->
                            <div x-show="open && search.length > 0 && getFiltered().length === 0"
                                class="absolute left-0 top-full mt-1 w-full bg-gray-700 border border-gray-600 rounded-md shadow-lg z-[9999] p-3">
                                <p class="text-gray-400">{{ __('formular.form_city_no_results') }}</p>
                            </div>

                            <!-- Selection confirmation -->
                            <div x-show="selected && search" class="mt-2 text-sm text-gray-400">
                                {{ __('formular.form_city_selected') }}: <span x-text="search"></span>
                            </div>

                            @error('city_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function cityDropdown() {
                                return {
                                    open: false,
                                    search: '',
                                    selected: '{{ old('city_id') }}',
                                    cities: {!! json_encode($cities) !!},

                                    getFiltered() {
                                        if (!this.search) return this.cities;
                                        const q = this.search.toLowerCase();
                                        return this.cities.filter(c =>
                                            c.name.toLowerCase().includes(q) ||
                                            (c.postal_code && c.postal_code.includes(q))
                                        );
                                    },

                                    selectCity(city) {
                                        this.selected = city.id;
                                        this.search = city.name;
                                        this.open = false;
                                    }
                                }
                            }
                        </script>

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
                                class="w-full inline-flex justify-center px-4 py-2 bg-stone-600 text-white font-medium rounded-md hover:bg-stone-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-gray-800 transition">
                                {{ __('formular.form_submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
