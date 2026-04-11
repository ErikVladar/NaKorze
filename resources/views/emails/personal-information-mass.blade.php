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
            color: #1f2937 !important;
            -webkit-text-fill-color: #1f2937 !important;
            line-height: 1.7;
        }
        .message-shell {
            background-color: #faf8f2 !important;
            border: 1px solid #d6d3d1;
            border-radius: 8px;
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
                                        <h1 class="heading" style="margin: 0; color: #4b3923 !important; -webkit-text-fill-color: #4b3923 !important;">{{ $subjectLine }}</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="body-copy" style="padding-top: 24px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; line-height: 1.7; font-size: 16px;">
                                        <p style="margin: 0 0 20px; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('dashboard.mass_email_greeting') }}</p>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="message-shell" bgcolor="#faf8f2" style="margin: 0 0 20px; background-color: #faf8f2 !important; border: 1px solid #d6d3d1; border-radius: 8px;">
                                            <tr>
                                                <td bgcolor="#faf8f2" style="padding: 20px; background-color: #faf8f2 !important; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important; font-size: 16px; line-height: 1.7; border-radius: 8px;">
                                                    {!! nl2br(e($messageBody)) !!}
                                                </td>
                                            </tr>
                                        </table>

                                        @if($senderName)
                                            <p style="margin: 0; color: #1f2937 !important; -webkit-text-fill-color: #1f2937 !important;">{{ __('dashboard.mass_email_sender') }} <strong>{{ $senderName }}</strong></p>
                                        @endif

                                    </td>
                                </tr>
                                <tr>
                                    <td class="footer-copy" style="padding-top: 30px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280 !important; -webkit-text-fill-color: #6b7280 !important; font-size: 12px;">
                                        <p style="margin: 0; color: #6b7280 !important; -webkit-text-fill-color: #6b7280 !important;">&copy; 2026 Na Korze. Cukráreň & Kaviareň. All rights reserved.</p>
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
