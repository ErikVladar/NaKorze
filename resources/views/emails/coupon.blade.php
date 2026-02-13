<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif !important;
            background-color: #18181b !important;
            color: #f3f3f3 !important;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #23232b !important;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ecba14;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #ecba14 !important;
            margin: 0;
        }
        .content {
            line-height: 1.6;
            color: #f3f3f3 !important;
        }
        .coupon-box {
            background-color: #23232b !important;
            border: 2px solid #ecba14;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .coupon-code {
            font-size: 24px;
            font-weight: bold;
            color: #38f9a6 !important;
            font-family: monospace;
            letter-spacing: 2px;
            background: #18181b !important;
            padding: 8px 16px;
            border-radius: 6px;
            display: inline-block;
        }
        .coupon-benefit {
            font-size: 18px;
            color: #ffe066 !important;
            margin-top: 10px;
        }
        .details {
            background-color: #18181b !important;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }
        .detail-label {
            font-weight: bold;
            color: #ffe066 !important;
        }
        .detail-value {
            color: #f3f3f3 !important;
            font-weight: 500;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #3f3f46;
            padding-top: 20px;
            margin-top: 30px;
            font-size: 12px;
            color: #bdbdbd !important;
        }
        .button {
            display: inline-block;
            background-color: #ecba14 !important;
            color: #18181b !important;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($logoUrl)
            <div style="margin-bottom: 15px;">
                <img src="{{ $logoUrl }}" alt="Na Korze Logo" style="max-width: 80px; height: auto; display: inline-block;" />
            </div>
            @endif
            <h1>🎉 {{ __('formular.email_heading') }}</h1>
        </div>

        <div class="content">
            <p>{!! __('formular.email_greeting', ['name' => $coupon->name]) !!}</p>

            <p>{{ __('formular.email_thank_you') }}</p>

            <div class="coupon-box">
                <div class="coupon-benefit">{{ __('formular.free_drink') }}</div>
                <a href="{{ url('/coupon/' . $coupon->code) }}" class="coupon-code" style="text-decoration: underline; color: #38f9a6 !important;">
                    {{ $coupon->code }}
                </a>
            </div>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">{{ __('formular.valid_from') }}:</span>
                    <span class="detail-value"> {{ $coupon->valid_from->format('d.m.Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('formular.valid_until') }}:</span>
                    <span class="detail-value"> {{ $coupon->valid_until->format('d.m.Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">{{ __('formular.coupon_details') }}:</span>
                    <span class="detail-value"> {{ $coupon->is_redeemed ? __('formular.coupon_redeemed') : __('formular.coupon_available') }}</span>
                </div>
            </div>

            <p>{{ __('formular.email_use') }}</p>

            <p>{!! __('formular.email_contact', ['contact' => 'info@kaviarennakorze.sk']) !!}</p>

            <p>{{ __('formular.email_regards') }}<br>
            <strong>{{ __('formular.email_signature') }}</strong></p>
        </div>

        <div class="footer">
            <p>&copy; 2025 Na Korze. Cukráreň & Kaviareň. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
