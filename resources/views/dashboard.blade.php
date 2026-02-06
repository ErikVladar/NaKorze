<x-app-layout>
    <div id="form" class="relative z-30 rounded-2xl overflow-hidden group min-h-auto bg-opacity-95 p-8">
        <div class="w-full mx-auto">


            

            <!-- Coupons Section -->
            <div>
                <h2 class="text-xl font-semibold text-white mb-4">{{ __('dashboard.coupons') }}</h2>

                <!-- Verification Form (authenticated users) -->
                @auth
                    <form method="POST" action="{{ route('coupons.verify') }}" class="mb-4 flex gap-2">
                        @csrf
                        <input name="code" type="text" placeholder="{{ __('dashboard.code') }}" class="px-3 py-2 rounded bg-gray-800 text-gray-200 w-full" />
                        <button class="px-4 py-2 bg-green-600 text-white rounded">{{ __('dashboard.verify') }}</button>
                    </form>
                @endauth

                <div class="overflow-x-auto">
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

                                        @if ($c->is_verified)
                                            <div class="mt-2 text-xs text-gray-300">
                                                {{ __('dashboard.verified') }} @if($c->verified_at) ({{ $c->verified_at->format('Y-m-d') }}) @endif
                                            </div>
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
                                            @unless($c->is_verified)
                                                <form method="POST" action="{{ route('coupons.verify') }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="coupon_id" value="{{ $c->id }}">
                                                    <button class="px-2 py-1 bg-yellow-600 text-black text-xs rounded">{{ __('dashboard.verify') }}</button>
                                                </form>
                                            @endunless
                                        </td>
                                    @endauth
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">{{ __('dashboard.no_coupons_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

                <div class="overflow-x-auto">
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
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">{{ __('dashboard.no_users_found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
