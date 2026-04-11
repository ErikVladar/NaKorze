<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-white">{{ __('dashboard.change_password') }}</h1>
        <p class="mt-2 text-sm text-gray-300">
            {{ __('dashboard.selected_user') }}: <span class="font-semibold">{{ $user->name }}</span>
        </p>
        <p class="mt-1 text-xs text-gray-400">{{ $user->email }}</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-600 text-white px-4 py-3 text-sm">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-600 text-white px-4 py-3 text-sm">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('dashboard.users.password', $user) }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="user_password" :value="__('dashboard.new_password')" />
            <x-text-input id="user_password" class="block mt-1 w-full" type="password" name="user_password" required
                minlength="8" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('user_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="user_password_confirmation" :value="__('dashboard.confirm_password')" />
            <x-text-input id="user_password_confirmation" class="block mt-1 w-full" type="password"
                name="user_password_confirmation" required minlength="8" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('user_password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center rounded-md border border-stone-600 px-4 py-2 text-sm text-gray-200 hover:bg-stone-800 transition">
                {{ __('dashboard.back_to_dashboard') }}
            </a>

            <x-primary-button>
                {{ __('dashboard.update_password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
