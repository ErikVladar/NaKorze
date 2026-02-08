<x-app-layout>
    <div id="form" class="relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto">

            {{-- Flash messages --}}
            @if (session('success') || session('error') || session('info'))
                <div class="mb-4 max-w-3xl mx-auto">
                    @if (session('success'))
                        <div class="rounded-md bg-green-600 text-white px-4 py-3">{{ session('success') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="rounded-md bg-red-600 text-white px-4 py-3 mt-2">{{ session('info') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-md bg-red-600 text-white px-4 py-3 mt-2">{{ session('error') }}</div>
                    @endif
                </div>
            @endif
            

            <!-- Coupons Section -->
            <div>
                <h2 class="text-xl font-semibold text-white mb-4">{{ __('dashboard.coupons') }}</h2>

                <!-- Verification Form (authenticated users) -->
                @auth
                    <form method="POST" action="{{ route('coupons.redeem') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
                        @csrf
                        <input name="code" type="text" placeholder="{{ __('dashboard.code') }}" class="px-3 py-2 rounded bg-gray-800 text-gray-200 flex-1" />
                        <button class="px-4 py-2 bg-green-600 text-white rounded whitespace-nowrap">{{ __('dashboard.redeem') }}</button>
                    </form>
                @endauth

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-gray-200">
                        <thead>
                            <tr class="border-b border-gray-500 bg-gray-700">
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.code') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.discount') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.valid_from') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.valid_until') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.status') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.redeemed') }}</th>
                                @auth
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.actions') }}</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            @forelse ($coupons as $c)
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 font-mono font-semibold text-yellow-400">{{ $c->code }}</td>
                                    <td class="px-4 py-3">{{ $c->discount_percent }}%</td>
                                    <td class="px-4 py-3">{{ $c->valid_from->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">{{ $c->valid_until->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        @if ($c->isValid())
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 bg-opacity-20 text-green-300">
                                                ✓ {{ __('dashboard.valid') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 bg-opacity-20 text-red-300">
                                                ✕ {{ __('dashboard.invalid') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($c->is_redeemed)
                                            <span class="text-gray-400 text-xs">{{ $c->redeemed_at->format('Y-m-d') }}</span>
                                        @else
                                            <span class="text-gray-500 text-xs">—</span>
                                        @endif
                                    </td>
                                    @auth
                                        <td class="px-4 py-3">
                                            @unless($c->is_redeemed)
                                                <form method="POST" action="{{ route('coupons.redeem') }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="coupon_id" value="{{ $c->id }}">
                                                    <button class="px-2 py-1 bg-green-600 text-white text-xs rounded">{{ __('dashboard.redeem') }}</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endunless
                                        </td>
                                    @endauth
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->check() ? 7 : 6 }}" class="px-4 py-6 text-center text-gray-500">{{ __('dashboard.no_coupons_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards (shown on mobile only) -->
                <div class="md:hidden space-y-4">
                    @forelse ($coupons as $c)
                        <div class="bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.code') }}</p>
                                    <p class="font-mono font-semibold text-yellow-400 break-all">{{ $c->code }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">{{ __('dashboard.discount') }}</p>
                                    <p class="text-sm font-semibold">{{ $c->discount_percent }}%</p>
                                </div>
                            </div>
                            <div class="flex justify-between gap-2">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.valid_from') }}</p>
                                    <p class="text-sm">{{ $c->valid_from->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.valid_until') }}</p>
                                    <p class="text-sm">{{ $c->valid_until->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('dashboard.status') }}</p>
                                @if ($c->isValid())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 bg-opacity-20 text-green-300">
                                        ✓ {{ __('dashboard.valid') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 bg-opacity-20 text-red-300">
                                        ✕ {{ __('dashboard.invalid') }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('dashboard.redeemed') }}</p>
                                @if ($c->is_redeemed)
                                    <p class="text-xs text-gray-400">{{ $c->redeemed_at->format('Y-m-d') }}</p>
                                @else
                                    <p class="text-xs text-gray-500">—</p>
                                @endif
                            </div>
                            @auth
                                @unless($c->is_redeemed)
                                    <form method="POST" action="{{ route('coupons.redeem') }}" class="pt-2">
                                        @csrf
                                        <input type="hidden" name="coupon_id" value="{{ $c->id }}">
                                        <button class="w-full px-2 py-1 bg-green-600 text-white text-xs rounded">{{ __('dashboard.redeem') }}</button>
                                    </form>
                                @endunless
                            @endauth
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">{{ __('dashboard.no_coupons_found') }}</div>
                    @endforelse
                </div>

                @if ($coupons->hasPages())
                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>

            <!-- Users Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white mb-4">{{ __('dashboard.users') }}</h2>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-gray-200">
                        <thead>
                            <tr class="border-b border-gray-500 bg-gray-700">
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.id') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.name') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.email') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.role') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.joined') }}</th>
                                @auth
                                    @if (auth()->user()->isAdmin())
                                        <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.actions') }}</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            @forelse ($users as $u)
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="px-4 py-3">{{ $u->id }}</td>
                                    <td class="px-4 py-3">{{ $u->name }}</td>
                                    <td class="px-4 py-3">{{ $u->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-medium @if($u->role === 'admin') bg-purple-500 bg-opacity-20 text-purple-300 @else bg-gray-600 text-gray-300 @endif">
                                            {{ $u->role ?? 'user' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $u->created_at->format('Y-m-d') }}</td>
                                    @auth
                                        @if (auth()->user()->isAdmin())
                                            <td class="px-4 py-3">
                                                @if (auth()->user()->id !== $u->id)
                                                    <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">{{ __('dashboard.delete') }}</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500 text-xs">—</span>
                                                @endif
                                            </td>
                                        @endif
                                    @endauth
                                </tr>
                            @empty
                                    <tr>
                                        <td colspan="{{ (auth()->check() && auth()->user()->isAdmin()) ? 6 : 5 }}" class="px-4 py-6 text-center text-gray-500">{{ __('dashboard.no_users_found') }}</td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards (shown on mobile only) -->
                <div class="md:hidden space-y-4">
                    @forelse ($users as $u)
                        <div class="bg-gray-700 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.name') }}</p>
                                    <p class="font-semibold">{{ $u->name }}</p>
                                </div>
                                <div>
                                    <span class="px-2 py-1 rounded text-xs font-medium @if($u->role === 'admin') bg-purple-500 bg-opacity-20 text-purple-300 @else bg-gray-600 text-gray-300 @endif">
                                        {{ $u->role ?? 'user' }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">{{ __('dashboard.email') }}</p>
                                <p class="text-sm break-all">{{ $u->email }}</p>
                            </div>
                            <div class="flex justify-between gap-4">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.id') }}</p>
                                    <p class="text-sm">#{{ $u->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.joined') }}</p>
                                    <p class="text-sm">{{ $u->created_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <div class="pt-2">
                                        @if (auth()->user()->id !== $u->id)
                                            <form method="POST" action="{{ route('users.destroy', $u) }}" onsubmit="return confirm('Are you sure?');" style="display: block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">{{ __('dashboard.delete') }}</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-xs text-center block">—</span>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">{{ __('dashboard.no_users_found') }}</div>
                    @endforelse
                </div>

                @if ($users->hasPages())
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
