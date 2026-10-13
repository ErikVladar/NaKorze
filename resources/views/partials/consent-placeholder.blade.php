{{-- Shown over a third-party embed until the visitor accepts the "external" cookie category --}}
<div data-consent-placeholder
    class="absolute inset-0 flex flex-col items-center justify-center gap-4 p-6 bg-stone-200 text-stone-800 text-center font-sans">
    <p class="text-base font-medium max-w-md">{{ $message }}</p>
    <div class="flex flex-wrap justify-center gap-3">
        <button type="button" data-consent-allow-external
            class="px-5 py-2 rounded-lg bg-stone-800 text-white text-sm font-semibold hover:bg-stone-900">
            {{ __('home.embed_allow') }}
        </button>
        <button type="button" data-cc="show-preferencesModal"
            class="px-5 py-2 rounded-lg border border-stone-800 text-sm font-semibold hover:bg-stone-300">
            {{ __('home.cookie_settings') }}
        </button>
    </div>
</div>
