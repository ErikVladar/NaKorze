@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Debug: Test Coupon Views</h1>

        @if ($coupons->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">No coupons found. Please create some coupons first by submitting the form.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($coupons as $coupon)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">{{ $coupon->code }}</h2>
                        
                        <div class="mb-4 space-y-2 text-sm text-gray-600">
                            <p><strong>Discount:</strong> {{ $coupon->discount_percent }}%</p>
                            <p><strong>Valid:</strong> {{ $coupon->valid_from->format('d.m.Y') }} - {{ $coupon->valid_until->format('d.m.Y') }}</p>
                            <p><strong>Verified:</strong> {{ $coupon->is_verified ? '✓ Yes' : '✗ No' }}</p>
                            <p><strong>Redeemed:</strong> {{ $coupon->is_redeemed ? '✓ Yes' : '✗ No' }}</p>
                        </div>

                        <div class="space-y-2">
                            <!-- Direct View Link -->
                            <a href="{{ route('coupons.view', $coupon->id) }}" 
                               class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">
                                View Coupon Page
                            </a>

                            <!-- Show QR Code -->
                            <details class="bg-gray-50 rounded-lg p-3">
                                <summary class="cursor-pointer font-semibold text-gray-700">View QR Code</summary>
                                <div class="mt-4 flex justify-center">
                                    {!! $coupon->getQrCode() !!}
                                </div>
                                <p class="text-xs text-gray-500 mt-2 text-center">
                                    Encodes: <code class="bg-gray-200 px-2 py-1 rounded">{{ route('coupons.view', $coupon->id) }}</code>
                                </p>
                            </details>

                            <!-- Show URL -->
                            <details class="bg-gray-50 rounded-lg p-3">
                                <summary class="cursor-pointer font-semibold text-gray-700">View URL</summary>
                                <code class="block bg-gray-200 p-2 rounded mt-2 text-xs break-all">
                                    {{ url(route('coupons.view', $coupon->id)) }}
                                </code>
                            </details>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            <a href="/" class="inline-block px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
