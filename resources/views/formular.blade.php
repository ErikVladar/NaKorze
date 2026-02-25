<x-app-layout>
    <div class="w-full mx-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div id="form"
                class="font-mono bg-stone-900 rounded-2xl relative z-10 overflow-visible group w-full max-w-2xl bg-opacity-95 p-8 m-4">
                <div class="w-full mx-auto"></div>
                {{-- <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('formular.form_title') }}
                </h2> --}}
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

                <!-- intl-tel-input CSS -->
                <link rel="stylesheet"
                    href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.min.css">

                <form method="POST" action="{{ route('form.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name">
                            {{ __('formular.form_name') }}
                            <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        @error('name')
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email"> {{ __('formular.form_email') }}
                            <span class="text-red-500">*</span> </x-input-label>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        @error('email')
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Phone (intl-tel-input) wrapped to isolate styles -->
                    <div>
                        <x-input-label for="phone" class="mb-1" :value="__('formular.form_phone')" />
                        <div class="intl-tel-input-wrapper w-full">
                            <input id="phone" type="tel"
                                class="border-stone-600 bg-stone-600 text-gray-200 focus:border-stone-500 focus:ring-stone-500 rounded-md shadow-sm w-full"
                                style="height:2.5rem;padding-left:50px;font-size:1rem;margin-top:0;" />
                            <input type="hidden" id="full_phone" name="phone" />
                        </div>
                        @error('phone')
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Sex/Gender --}}
                    <div>
                        <x-input-label for="sex" :value="__('formular.form_sex')" />
                        <select name="sex" id="sex" value="{{ old('sex') }}"
                            class="border-stone-600 bg-stone-600 text-gray-200 focus:border-stone-500 focus:ring-stone-500 rounded-md shadow-sm block mt-1 w-1/2">
                            <option value="">{{ __('formular.form_sex_placeholder') }}</option>
                            <option value="M" @if (old('sex') === 'M') selected @endif>
                                {{ __('formular.form_sex_male') }}</option>
                            <option value="F" @if (old('sex') === 'F') selected @endif>
                                {{ __('formular.form_sex_female') }}</option>
                        </select>
                        @error('sex')
                            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Street (Ulica) -->
                    <div>
                        <x-input-label for="address" :value="__('formular.form_street')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                            :value="old('address')" />
                        @error('address')
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- City -->
                        <div x-data="cityDropdown()" class="relative w-full">
                            <x-input-label for="city_id" class="mb-1" :value="__('formular.form_city')" />
                            <x-text-input type="text" x-model="search" @focus="open = true" @input="open = true"
                                @keydown.escape="open = false" @click.away="open = false" autocomplete="off" />
                            <input type="hidden" name="city_id" :value="selected">

                            <!-- Dropdown -->
                            <div x-show="open && getFiltered().length > 0"
                                class="absolute left-0 top-full mt-1 w-full bg-stone-600 border border-stone-600 rounded-md shadow-lg z-[9999] max-h-60 overflow-y-auto">
                                <template x-for="city in getFiltered()" :key="city.id">
                                    <div @mousedown.prevent="selectCity(city)"
                                        class="px-3 py-2 cursor-pointer text-gray-200 hover:bg-stone-500">
                                        <span x-text="city.name"></span>
                                        <span class="text-gray-400 text-sm"
                                            x-text="city.postal_code ? ' (' + city.postal_code + ')' : ''"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- No results -->
                            <div x-show="open && search.length > 0 && getFiltered().length === 0"
                                class="absolute left-0 top-full mt-1 w-full bg-stone-600 border border-stone-600 rounded-md shadow-lg z-[9999] p-3">
                                <p class="text-gray-400">{{ __('formular.form_city_no_results') }}</p>
                            </div>

                            <!-- Selection confirmation -->
                            <div x-show="selected && search" class="mt-2 text-sm text-gray-400">
                                {{ __('formular.form_city_selected') }}: <span x-text="search"></span>
                            </div>

                            @error('city_id')
                                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                            @enderror
                        </div>

                        <!-- Postal Code (PSČ) -->
                        <div>
                            <x-input-label for="postal_code" class="mb-1" :value="__('formular.form_postal_code')" />
                            <x-text-input id="postal_code" class="block w-full" type="text" name="postal_code"
                                :value="old('postal_code')" />
                            @error('postal_code')
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                            @enderror
                        </div>
                    </div>
                    <br>

                    <script>
                        function cityDropdown() {
                            return {
                                open: false,
                                search: '',
                                selected: '{{ old('city_id') }}',
                                cities: {!! json_encode($cities) !!},
                                normalizeDiacritics(str) {
                                    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                                },
                                getFiltered() {
                                    if (!this.search) return this.cities;
                                    const q = this.normalizeDiacritics(this.search.toLowerCase());
                                    return this.cities.filter(c => {
                                        const normalizedName = this.normalizeDiacritics(c.name.toLowerCase());
                                        return normalizedName.includes(q) ||
                                            (c.postal_code && c.postal_code.includes(q));
                                    });
                                },
                                selectCity(city) {
                                    this.selected = city.id;
                                    this.search = city.name;
                                    this.open = false;
                                    if (city.postal_code) {
                                        document.getElementById('postal_code').value = city.postal_code;
                                    }
                                }
                            }
                        }
                    </script>
                    <!-- intl-tel-input JS -->
                    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var input = document.querySelector('#phone');
                            var hiddenInput = document.querySelector('#full_phone');
                            var iti = null;
                            if (input) {
                                iti = window.intlTelInput(input, {
                                    initialCountry: 'sk',
                                    preferredCountries: ['sk', 'cz', 'at', 'hu', 'pl', 'de'],
                                    separateDialCode: true,
                                    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js'
                                });
                            }
                            var form = input.closest('form');
                            if (form && iti && hiddenInput) {
                                form.addEventListener('submit', function(e) {
                                    hiddenInput.value = iti.getNumber();
                                });
                            }
                        });
                    </script>

                    <!-- GDPR Consent -->
                    <div class="flex items-start">
                        <input type="checkbox" name="gdpr_consent" id="gdpr_consent" value="1"
                            @if (old('gdpr_consent')) checked @endif required
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-stone-600 rounded bg-stone-600" />
                        <label for="gdpr_consent" class="ms-3 block text-sm font-medium text-gray-300">
                            {{ __('formular.form_gdpr_consent') }} <span class="text-red-500">*</span>
                        </label>
                    </div>
                    @error('gdpr_consent')
                        <x-input-error :messages="$errors->get('gdpr_consent')" class="mt-2" />
                    @enderror

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button class="w-full justify-center">
                            {{ __('formular.form_submit') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    /* Style intl-tel-input dropdown to match form */
    .iti__dropdown-content,
    .iti__country-list {
        background-color: #57534e !important;
        /* bg-stone-600 */
        border: 1px solid #525252 !important;
        /* border-stone-600 */
        border-radius: 0.375rem !important;
        /* rounded-md */
        box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.15) !important;
        /* shadow-sm */
        color: #e5e7eb !important;
        /* text-gray-200 */
        font-family: inherit !important;
        z-index: 9999 !important;
    }

    .iti__country-list .iti__country {
        color: #e5e7eb !important;
        background: transparent !important;
    }

    .iti__country-list .iti__country:hover {
        background-color: #78716c !important;
    }

    .iti__country-list .iti__divider {
        border-color: #525252 !important;
    }

    .iti__country-list .iti__flag {
        margin-right: 8px !important;
    }

    .iti__selected-dial-code {
        color: #fff !important;
    }

    .iti__flag {
        display: inline-block !important;
    }

    .iti__country-container {
        position: absolute !important;
        width: 0 !important;
        height: 0 !important;
        opacity: 0 !important;
        pointer-events: none !important;
        overflow: hidden !important;
        z-index: -1 !important;
    }
</style>
