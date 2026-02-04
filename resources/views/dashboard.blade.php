<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        {{ __("You're logged in!") }}
                    </div>

                    <h3 class="text-lg font-medium mb-4">{{ __('Users') }}</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">{{ __('ID') }}</th>
                                    <th class="px-4 py-2 text-left">{{ __('Name') }}</th>
                                    <th class="px-4 py-2 text-left">{{ __('Email') }}</th>
                                    <th class="px-4 py-2 text-left">{{ __('Role') }}</th>
                                    <th class="px-4 py-2 text-left">{{ __('Joined') }}</th>
                                    @auth
                                        @if (auth()->user()->isAdmin())
                                            <th class="px-4 py-2">{{ __('Actions') }}</th>
                                        @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($users as $u)
                                    <tr>
                                        <td class="px-4 py-2">{{ $u->id }}</td>
                                        <td class="px-4 py-2">{{ $u->name }}</td>
                                        <td class="px-4 py-2">{{ $u->email }}</td>
                                        <td class="px-4 py-2">{{ $u->role ?? 'user' }}</td>
                                        <td class="px-4 py-2">{{ $u->created_at->format('Y-m-d') }}</td>
                                        @auth
                                            @if (auth()->user()->isAdmin())
                                                <td class="px-4 py-2">
                                                    @if (auth()->user()->id !== $u->id)
                                                        <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded">{{ __('Delete') }}</button>
                                                        </form>
                                                    @else
                                                        <span class="text-sm text-gray-500">—</span>
                                                    @endif
                                                </td>
                                            @endif
                                        @endauth
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
