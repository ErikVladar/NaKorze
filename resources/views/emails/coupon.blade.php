<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <meta name="x-apple-disable-message-reformatting">
    <style>
        :root {
            color-scheme: light only;
            supported-color-schemes: light;
        }
        body {
            font-family: Arial, sans-serif !important;
            background-color: #f5f3ee !important;
            color: #1f2937 !important;
        }
        table, tr, td, div, p, span, strong, h1, a {
            color: inherit;
        }
        .outer-shell {
            background-color: #f5f3ee !important;
        }
        .card {
            background-color: #ffffff !important;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            border: 1px solid #e7e2d8;
        }
        .heading {
            color: #4b3923 !important;
            -webkit-text-fill-color: #4b3923 !important;
        }
        .body-copy {
            line-height: 1.6;
            color: #1f2937 !important;
            -webkit-text-fill-color: #1f2937 !important;
        }
        .coupon-box {
            background-color: #fffaf0 !important;
            border: 1px solid #e5d4ae;
            border-radius: 8px;
            text-align: center;
        }
        .coupon-code {
            font-size: 24px;
            font-weight: bold;
            color: #0f766e !important;
            font-family: monospace;
            letter-spacing: 2px;
            background: #ffffff !important;
            padding: 8px 16px;
            border-radius: 6px;
            display: inline-block;
            -webkit-text-fill-color: #0f766e !important;
            border: 1px solid #9ca3af;
        }
        .coupon-benefit {
            font-size: 18px;
            color: #8a5a00 !important;
            -webkit-text-fill-color: #8a5a00 !important;
            margin-top: 10px;
        }
        .details {
            background-color: #faf8f2 !important;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        .detail-label {
            font-weight: bold;
            color: #6b4f33 !important;
            -webkit-text-fill-color: #6b4f33 !important;
        }
        .detail-value {
            color: #1f2937 !important;
            -webkit-text-fill-color: #1f2937 !important;
            font-weight: 500;
        }
        .footer-copy {
            color: #6b7280 !important;
            -webkit-text-fill-color: #6b7280 !important;
            font-size: 12px;
        }
        .logo-mark {
            display: inline-block;
            filter: drop-shadow(0 0 3px rgba(0,0,0,0.98)) drop-shadow(0 0 14px rgba(60,42,29,0.6));
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
<body class="body" bgcolor="#f5f3ee" style="margin: 0; padding: 24px 12px; background-color: #f5f3ee !important; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f5f3ee" class="outer-shell" style="background-color: #f5f3ee !important;">
        <tr>
            <td align="center" bgcolor="#f5f3ee" class="outer-shell" style="padding: 0; background-color: #f5f3ee !important;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; margin: 0 auto;">
                    <tr>
                        <td bgcolor="#ffffff" class="card" style="padding: 24px 20px; background-color: #ffffff !important; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; border-radius: 8px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border: 1px solid #e7e2d8;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 20px; border-bottom: 2px solid #d6d3d1;">
                                        @if($logoUrl)
                                        <div style="margin-bottom: 15px;">
                                            <img src="{{ $logoUrl }}" alt="Na Korze Logo" class="logo-mark" style="max-width: 220px; height: auto; display: inline-block; filter: drop-shadow(0 0 3px rgba(0,0,0,0.98)) drop-shadow(0 0 14px rgba(60,42,29,0.6));" />
                                        </div>
                                        @endif
                                        <h1 class="heading" style="margin: 0; color: #4b3923 !important; -webkit-text-fill-color: #4b3923 !important;">🎉 {{ __('formular.email_heading') }}</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="body-copy" style="padding-top: 24px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; line-height: 1.6; font-size: 16px;">
                                        <p style="margin: 0 0 16px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{!! __('formular.email_greeting', ['name' => $coupon->name]) !!}</p>

                                        <p style="margin: 0 0 20px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('formular.email_thank_you') }}</p>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="coupon-box" bgcolor="#fffaf0" style="margin: 0 0 20px; background-color: #fffaf0 !important; border: 1px solid #e5d4ae; border-radius: 8px; text-align: center;">
                                            <tr>
                                                <td align="center" style="padding: 20px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">
                                                    <div class="coupon-benefit" style="margin-bottom: 12px; color: #8a5a00 !important; -webkit-text-fill-color: #8a5a00 !important;">{{ __('formular.free_drink') }}</div>
                                                    <a href="{{ url('/coupons/' . $coupon->code . '/view') }}" class="coupon-code" style="display: inline-block; text-decoration: underline; color: #0f766e !important; -webkit-text-fill-color: #0f766e !important; font-size: 24px; font-weight: bold; font-family: monospace; letter-spacing: 2px; background: #ffffff !important; padding: 8px 16px; border-radius: 6px; border: 1px solid #9ca3af;">
                                                        {{ $coupon->code }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="details" bgcolor="#faf8f2" style="margin: 0 0 20px; background-color: #faf8f2 !important; border-radius: 5px; border: 1px solid #e5e7eb;">
                                            <tr>
                                                <td style="padding: 15px;">
                                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td class="detail-label" valign="top" style="padding: 0 12px 8px 0; color: #6b4f33 !important; -webkit-text-fill-color: #6b4f33 !important; font-weight: bold;">{{ __('formular.valid_from') }}:</td>
                                                            <td class="detail-value" align="right" valign="top" style="padding: 0 0 8px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; font-weight: 500;">{{ $coupon->valid_from->format('d.m.Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-label" valign="top" style="padding: 0 12px 8px 0; color: #6b4f33 !important; -webkit-text-fill-color: #6b4f33 !important; font-weight: bold;">{{ __('formular.valid_until') }}:</td>
                                                            <td class="detail-value" align="right" valign="top" style="padding: 0 0 8px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; font-weight: 500;">{{ $coupon->valid_until->format('d.m.Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="detail-label" valign="top" style="padding: 0 12px 0 0; color: #6b4f33 !important; -webkit-text-fill-color: #6b4f33 !important; font-weight: bold;">{{ __('formular.coupon_details') }}:</td>
                                                            <td class="detail-value" align="right" valign="top" style="padding: 0; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; font-weight: 500;">{{ $coupon->is_redeemed ? __('formular.coupon_redeemed') : __('formular.coupon_available') }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin: 0 0 16px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('formular.email_use') }}</p>

                                        <p style="margin: 0 0 16px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{!! __('formular.email_contact', ['contact' => 'info@kaviarennakorze.sk']) !!}</p>

                                        <p style="margin: 0; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('formular.email_regards') }}<br><strong style="color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('formular.email_signature') }}</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="footer-copy" style="padding-top: 30px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280 !important; -webkit-text-fill-color: #6b7280 !important; font-size: 12px;">
                                        <p style="margin: 0; color: #6b7280 !important; -webkit-text-fill-color: #6b7280 !important;">&copy; 2025 Na Korze. Cukráreň & Kaviareň. All rights reserved.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
