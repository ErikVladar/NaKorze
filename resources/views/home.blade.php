<x-app-layout>
    <div class="min-h-screen rounded-2xl bg-gradient-to-br from-stone-900 to-stone-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Welcome Section -->
            <div class="bg-stone-800 rounded-lg shadow-xl p-8 mb-6">
                <h1 class="text-3xl font-bold text-white mb-2">{{ __('home.welcome', ['name' => auth()->user()->name]) }}</h1>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Dashboard Button -->
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 transition-colors rounded-lg shadow-lg p-6 text-center group">
                    <svg class="w-12 h-12 mx-auto mb-3 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-white mb-2">{{ __('home.dashboard') }}</h2>
                    <p class="text-blue-100 text-sm">{{ __('home.view_coupons_history') }}</p>
                </a>

                <!-- QR Scanner Button -->
                <button onclick="toggleScanner()" class="bg-green-600 hover:bg-green-700 transition-colors rounded-lg shadow-lg p-6 text-center group">
                    <svg class="w-12 h-12 mx-auto mb-3 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-white mb-2">{{ __('home.scan_codes') }}</h2>
                    <p class="text-green-100 text-sm">{{ __('home.scan_qr_code') }}</p>
                </button>
            </div>

            <!-- QR Scanner Container (Hidden by default) -->
            <div id="scanner-container" class="hidden bg-stone-800 rounded-lg shadow-xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-white">{{ __('home.qr_code_scanner') }}</h3>
                    <button onclick="toggleScanner()" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Camera Feed -->
                <div id="qr-reader" class="mb-4 rounded-lg overflow-hidden bg-black"></div>

                <!-- Result Display -->
                <div id="qr-result" class="hidden bg-green-900 bg-opacity-50 border border-green-500 rounded-lg p-4 mb-4">
                    <p class="text-green-100 text-sm mb-2">{{ __('home.scanned_code') }}</p>
                    <p id="qr-result-text" class="text-white font-mono break-all text-lg"></p>
                </div>

                <!-- Error Display -->
                <div id="qr-error" class="hidden bg-red-900 bg-opacity-50 border border-red-500 rounded-lg p-4">
                    <p id="qr-error-text" class="text-red-100"></p>
                </div>

                <!-- Info -->
                <p class="text-gray-400 text-center text-sm mt-4">
                    {{ __('home.qr_instructions') }}
                </p>
            </div>
        </div>
    </div>

    <!-- html5-qrcode Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeJqsToxS6F+evs5SPDungBjr4N9IsKFmMTQ0V5D7J6g5IK3AFxnwbruqyd5cc3SrwKBPapnDVRjVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let html5QrcodeScanner = null;
        let scannerActive = false;

        function toggleScanner() {
            const container = document.getElementById('scanner-container');
            container.classList.toggle('hidden');

            if (!scannerActive) {
                startScanner();
            } else {
                stopScanner();
            }
        }

        function startScanner() {
            if (scannerActive) return;

            // Try to use environment (back) camera on mobile
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                experimentalFeatures: { useBarCodeDetectorIfSupported: true },
                rememberLastUsedCamera: true,
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            };

            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader",
                config,
                false
            );

            html5QrcodeScanner.render(onScanSuccess, function(error) {
                // Show error if camera permission denied
                const errorDiv = document.getElementById('qr-error');
                const errorText = document.getElementById('qr-error-text');
                if (error && error.name === 'NotAllowedError') {
                    errorText.textContent = 'Camera access denied. Please allow camera permissions to scan QR codes.';
                    errorDiv.classList.remove('hidden');
                } else {
                    errorDiv.classList.add('hidden');
                }
                onScanError(error);
            });
            scannerActive = true;
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(error => {
                    console.log('Error stopping scanner:', error);
                });
                scannerActive = false;
                html5QrcodeScanner = null;
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log('QR Code detected:', decodedText);

            // Show result
            const resultDiv = document.getElementById('qr-result');
            const resultText = document.getElementById('qr-result-text');
            const errorDiv = document.getElementById('qr-error');

            resultText.textContent = decodedText;
            resultDiv.classList.remove('hidden');
            errorDiv.classList.add('hidden');

            // Stop scanner after successful scan
            stopScanner();
            document.getElementById('scanner-container').classList.add('hidden');

            // Redirect to coupon info view
            window.location.href = `/coupons/${decodedText}/view`;
        }

        function onScanError(error) {
            // Silently handle errors - they happen frequently during scanning
            // Only show error if it's something other than a normal "not detected" message
            if (error && !error.toString().includes('No MultiFormat')) {
                console.log('QR scan error:', error);
            }
        }
    </script>
</x-app-layout>
