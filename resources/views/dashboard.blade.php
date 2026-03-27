<x-app-layout>
    <div id="form" class="font-mono rounded-2xl bg-stone-900 relative z-30 overflow-hidden group min-h-auto bg-opacity-95 p-8"
        x-data="{
            activeTab: 'coupons',
            couponFilter: '',
            couponStatus: 'all',
            personalFilter: '',
            userFilter: '',
            userRole: 'all',
            matchText(haystack, needle) {
                if (!needle) return true;
                return (haystack || '').toString().toLowerCase().includes(needle.toLowerCase().trim());
            },
            couponVisible(code, isValid, isRedeemed) {
                const byCode = this.matchText(code, this.couponFilter);
                let byStatus = true;
                if (this.couponStatus === 'valid') byStatus = isValid;
                if (this.couponStatus === 'invalid') byStatus = !isValid && !isRedeemed;
                if (this.couponStatus === 'redeemed') byStatus = isRedeemed;
                if (this.couponStatus === 'not_redeemed') byStatus = !isRedeemed;
                return byCode && byStatus;
            },
            personalVisible(name, email, phone, message, city, postalCode, address) {
                const q = this.personalFilter;
                if (!q) return true;
                return this.matchText(name, q) || this.matchText(email, q) || this.matchText(phone, q) || this.matchText(message, q) || this.matchText(city, q) || this.matchText(postalCode, q) || this.matchText(address, q);
            },
            userVisible(id, name, email, role) {
                const byText = this.matchText(id, this.userFilter) || this.matchText(name, this.userFilter) || this.matchText(email, this.userFilter);
                const byRole = this.userRole === 'all' ? true : (role || 'user') === this.userRole;
                return byText && byRole;
            }
        }">
        <div class="w-full mx-auto">

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

            <div class="mb-0 flex flex-wrap gap-1 pl-1 relative z-30">
                <button type="button" @click="activeTab = 'coupons'"
                    :class="activeTab === 'coupons'
                        ? 'bg-stone-700 text-white z-40'
                        : 'bg-stone-800 text-gray-300 hover:bg-stone-700 hover:text-white mt-2 opacity-95'"
                    class="px-5 py-2 text-sm font-semibold transition-all duration-150 relative"
                    style="border-radius: 0.5rem 0.5rem 0 0;">
                    {{ __('dashboard.coupons') }}
                </button>

                @if (auth()->user()->isAdmin())
                    <button type="button" @click="activeTab = 'personal'"
                        :class="activeTab === 'personal'
                            ? 'bg-stone-700 text-white z-40'
                            : 'bg-stone-800 text-gray-300 hover:bg-stone-700 hover:text-white mt-2 opacity-95'"
                        class="px-5 py-2 text-sm font-semibold transition-all duration-150 relative"
                        style="border-radius: 0.5rem 0.5rem 0 0;">
                        {{ __('dashboard.personal_information') ?? 'Personal Information' }}
                    </button>

                    <button type="button" @click="activeTab = 'users'"
                        :class="activeTab === 'users'
                            ? 'bg-stone-700 text-white z-40'
                            : 'bg-stone-800 text-gray-300 hover:bg-stone-700 hover:text-white mt-2 opacity-95'"
                        class="px-5 py-2 text-sm font-semibold transition-all duration-150 relative"
                        style="border-radius: 0.5rem 0.5rem 0 0;">
                        {{ __('dashboard.users') }}
                    </button>
                @endif
            </div>

            <div x-show="activeTab === 'coupons'" class="pt-8 px-4 pb-4 bg-stone-700 rounded-b-xl">
                {{-- <h2 class="text-xl font-semibold text-white mb-4">{{ __('dashboard.coupons') }}</h2> --}}

                @auth
                    <form method="POST" action="{{ route('coupons.redeem') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
                        @csrf
                        <input name="code" type="text" placeholder="{{ __('dashboard.code') }}"
                            class="px-3 py-2 rounded bg-gray-800 text-gray-200 flex-1" />
                        <button
                            class="px-4 py-2 bg-green-600 text-white rounded whitespace-nowrap">{{ __('dashboard.redeem') }}</button>
                    </form>
                @endauth

                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input x-model="couponFilter" type="text" placeholder="{{ __('dashboard.filter_by_code') }}"
                        class="px-3 py-2 rounded bg-gray-800 text-gray-200 border border-gray-600" />
                    <select x-model="couponStatus" class="px-3 py-2 rounded bg-gray-800 text-gray-200 border border-gray-600">
                        <option value="all">{{ __('dashboard.all_statuses') }}</option>
                        <option value="valid">{{ __('dashboard.valid') }}</option>
                        <option value="invalid">{{ __('dashboard.invalid_not_redeemed') }}</option>
                        <option value="redeemed">{{ __('dashboard.redeemed') }}</option>
                        <option value="not_redeemed">{{ __('dashboard.not_redeemed') }}</option>
                    </select>
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-gray-200">
                        <thead>
                            <tr class="border-b border-gray-500 bg-gray-700">
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.code') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.valid_from') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.valid_until') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.status') }}</th>
                                <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.redeemed') }}</th>
                                @auth
                                    <th class="text-left px-4 py-3 font-semibold"></th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-600">
                            @forelse ($coupons as $c)
                                <tr class="hover:bg-gray-700 transition"
                                    x-show="couponVisible(@js(strtolower($c->code)), {{ $c->isValid() ? 'true' : 'false' }}, {{ $c->is_redeemed ? 'true' : 'false' }})">
                                    <td class="px-4 py-3 font-semibold text-yellow-400">{{ $c->code }}</td>
                                    <td class="px-4 py-3">{{ $c->valid_from->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">{{ $c->valid_until->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        @if ($c->is_redeemed)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 bg-opacity-20 text-blue-300">
                                                ✓ {{ __('dashboard.redeemed_status') }}
                                            </span>
                                        @elseif ($c->isValid())
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 bg-opacity-20 text-green-300">
                                                ✓ {{ __('dashboard.valid') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 bg-opacity-20 text-red-300">
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
                                            @unless ($c->is_redeemed)
                                                <form method="POST" action="{{ route('coupons.redeem') }}" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="coupon_id" value="{{ $c->id }}">
                                                    <button
                                                        class="px-2 py-1 bg-green-600 text-white text-xs rounded">{{ __('dashboard.redeem') }}</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endunless
                                        </td>
                                    @endauth
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->check() ? 7 : 6 }}" class="px-4 py-6 text-center text-gray-500">
                                        {{ __('dashboard.no_coupons_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden space-y-4 text-gray-100">
                    @forelse ($coupons as $c)
                        <div class="bg-gray-700 text-gray-100 p-4 rounded-lg space-y-2"
                            x-show="couponVisible(@js(strtolower($c->code)), {{ $c->isValid() ? 'true' : 'false' }}, {{ $c->is_redeemed ? 'true' : 'false' }})">
                            <div class="flex justify-between items-start gap-2">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.code') }}</p>
                                    <p class="font-mono font-semibold text-yellow-400 break-all">{{ $c->code }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">{{ __('dashboard.discount') }}</p>
                                    <p class="text-sm font-semibold text-gray-100">{{ $c->discount_percent }}%</p>
                                </div>
                            </div>
                            <div class="flex justify-between gap-2">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.valid_from') }}</p>
                                    <p class="text-sm text-gray-100">{{ $c->valid_from->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.valid_until') }}</p>
                                    <p class="text-sm text-gray-100">{{ $c->valid_until->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('dashboard.status') }}</p>
                                @if ($c->is_redeemed)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500 bg-opacity-20 text-blue-300">
                                        ✓ {{ __('dashboard.redeemed_status') }}
                                    </span>
                                @elseif ($c->isValid())
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500 bg-opacity-20 text-green-300">
                                        ✓ {{ __('dashboard.valid') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 bg-opacity-20 text-red-300">
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
                                @unless ($c->is_redeemed)
                                    <form method="POST" action="{{ route('coupons.redeem') }}" class="pt-2">
                                        @csrf
                                        <input type="hidden" name="coupon_id" value="{{ $c->id }}">
                                        <button
                                            class="w-full px-2 py-1 bg-green-600 text-white text-xs rounded">{{ __('dashboard.redeem') }}</button>
                                    </form>
                                @endunless
                            @endauth
                        </div>
                    @empty
                        <div class="text-center text-gray-300 py-6">{{ __('dashboard.no_coupons_found') }}</div>
                    @endforelse
                </div>

                @if ($coupons->hasPages())
                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>

            @if (auth()->user()->isAdmin())
                <div x-show="activeTab === 'personal'" class="mb-8 pt-8 px-4 pb-4 bg-stone-700 rounded-b-xl">
                    {{-- <h2 class="text-xl font-semibold text-white mb-4">
                        {{ __('dashboard.personal_information') ?? 'Personal Information' }}
                    </h2> --}}

                    <div class="mb-4">
                        <input x-model="personalFilter" type="text"
                            placeholder="{{ __('dashboard.filter_personal') }}"
                            class="w-full px-3 py-2 rounded bg-gray-800 text-gray-200 border border-gray-600" />
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-gray-200">
                            <thead>
                                <tr class="border-b border-gray-500 bg-gray-700">
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.name') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.email') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.phone') ?? 'Phone' }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.submitted') ?? 'Submitted' }}</th>
                                    <th class="text-left px-4 py-3 font-semibold"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-600">
                                @forelse ($personalInfo as $info)
                                    <tr class="hover:bg-gray-700 transition"
                                        x-show="personalVisible(@js(strtolower($info->name)), @js(strtolower($info->email)), @js(strtolower($info->phone ?? '')), @js(strtolower($info->message ?? '')), @js(strtolower($info->city?->name ?? '')), @js(strtolower($info->postal_code ?? '')), @js(strtolower($info->address ?? '')))">
                                        <td class="px-4 py-3">{{ $info->name }}</td>
                                        <td class="px-4 py-3">{{ $info->email }}</td>
                                        <td class="px-4 py-3">{{ $info->phone ?? '—' }}</td>
                                        <td class="px-4 py-3">{{ $info->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('personal-information.show', $info->id) }}"
                                                class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                                {{ __('dashboard.view_details') ?? 'View' }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                            {{ __('dashboard.no_personal_information') ?? 'No personal information found' }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden space-y-4 text-gray-100">
                        @forelse ($personalInfo as $info)
                            <div class="bg-gray-700 text-gray-100 p-4 rounded-lg space-y-2"
                                x-show="personalVisible(@js(strtolower($info->name)), @js(strtolower($info->email)), @js(strtolower($info->phone ?? '')), @js(strtolower($info->message ?? '')), @js(strtolower($info->city?->name ?? '')), @js(strtolower($info->postal_code ?? '')), @js(strtolower($info->address ?? '')))">
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.name') }}</p>
                                    <p class="font-semibold text-gray-100">{{ $info->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.email') }}</p>
                                    <p class="text-sm break-all text-gray-100">{{ $info->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.phone') ?? 'Phone' }}</p>
                                    <p class="text-sm text-gray-100">{{ $info->phone ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.message') ?? 'Message' }}</p>
                                    <p class="text-sm break-words text-gray-100">{{ $info->message ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.submitted') ?? 'Submitted' }}</p>
                                    <p class="text-sm text-gray-100">{{ $info->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                                <div class="pt-2">
                                    <a href="{{ route('personal-information.show', $info->id) }}"
                                        class="w-full block text-center px-3 py-2 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                        {{ __('dashboard.view_details') ?? 'View Details' }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-300 py-6">
                                {{ __('dashboard.no_personal_information') ?? 'No personal information found' }}
                            </div>
                        @endforelse
                    </div>

                    @if ($personalInfo->hasPages())
                        <div class="mt-4">
                            {{ $personalInfo->links() }}
                        </div>
                    @endif
                </div>

                <div x-show="activeTab === 'users'" class="mb-8 pt-8 px-4 pb-4 bg-stone-700">
                    {{-- <h2 class="text-xl font-semibold text-white mb-4">{{ __('dashboard.users') }}</h2> --}}

                    <div class="mb-4 gap-3">
                        <input x-model="userFilter" type="text" placeholder="{{ __('dashboard.filter_user') }}"
                            class="px-3 py-2 rounded. w-full bg-gray-800 text-gray-200 border border-gray-600" />
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-gray-200">
                            <thead>
                                <tr class="border-b border-gray-500 bg-gray-700">
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.id') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.name') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.email') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.role') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold">{{ __('dashboard.joined') }}</th>
                                    <th class="text-left px-4 py-3 font-semibold"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-600">
                                @forelse ($users as $u)
                                    <tr class="hover:bg-gray-700 transition"
                                        x-show="userVisible(@js((string) $u->id), @js(strtolower($u->name)), @js(strtolower($u->email)), @js($u->role ?? 'user'))">
                                        <td class="px-4 py-3">{{ $u->id }}</td>
                                        <td class="px-4 py-3">{{ $u->name }}</td>
                                        <td class="px-4 py-3">{{ $u->email }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium @if ($u->role === 'admin') bg-purple-500 bg-opacity-20 text-purple-300 @else bg-gray-600 text-gray-300 @endif">
                                                {{ $u->role ?? 'user' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $u->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3">
                                            @if (auth()->user()->id !== $u->id)
                                                <form method="POST" action="{{ route('users.destroy', $u) }}"
                                                    onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">{{ __('dashboard.delete') }}</button>
                                                </form>
                                            @else
                                                <span class="text-gray-500 text-xs">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                            {{ __('dashboard.no_users_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden space-y-4 text-gray-100">
                        @forelse ($users as $u)
                            <div class="bg-gray-700 text-gray-100 p-4 rounded-lg space-y-2"
                                x-show="userVisible(@js((string) $u->id), @js(strtolower($u->name)), @js(strtolower($u->email)), @js($u->role ?? 'user'))">
                                <div class="flex justify-between items-start gap-2">
                                    <div>
                                        <p class="text-xs text-gray-400">{{ __('dashboard.name') }}</p>
                                        <p class="font-semibold text-gray-100">{{ $u->name }}</p>
                                    </div>
                                    <div>
                                        <span
                                            class="px-2 py-1 rounded text-xs font-medium @if ($u->role === 'admin') bg-purple-500 bg-opacity-20 text-purple-300 @else bg-gray-600 text-gray-300 @endif">
                                            {{ $u->role ?? 'user' }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">{{ __('dashboard.email') }}</p>
                                    <p class="text-sm break-all text-gray-100">{{ $u->email }}</p>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <div>
                                        <p class="text-xs text-gray-400">{{ __('dashboard.id') }}</p>
                                        <p class="text-sm text-gray-100">#{{ $u->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">{{ __('dashboard.joined') }}</p>
                                        <p class="text-sm text-gray-100">{{ $u->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    @if (auth()->user()->id !== $u->id)
                                        <form method="POST" action="{{ route('users.destroy', $u) }}"
                                            onsubmit="return confirm('Are you sure?');" style="display: block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">{{ __('dashboard.delete') }}</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-xs text-center block">—</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-300 py-6">{{ __('dashboard.no_users_found') }}</div>
                        @endforelse
                    </div>

                    @if ($users->hasPages())
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
