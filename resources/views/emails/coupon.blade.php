<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #28a745;
            margin: 0;
        }
        .content {
            line-height: 1.6;
        }
        .coupon-box {
            background-color: #f9f9f9;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .coupon-code {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            font-family: monospace;
            letter-spacing: 2px;
        }
        .coupon-benefit {
            font-size: 18px;
            color: #333;
            margin-top: 10px;
        }
        .details {
            background-color: #f0f0f0;
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
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
        .button {
            display: inline-block;
            background-color: #28a745;
            color: white;
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
            <h1>🎉 Your Na Korze Coupon</h1>
        </div>

        <div class="content">
            <p>Dear {{ $coupon->email }},</p>

            <p>Thank you for filling out our form! We're excited to offer you a special reward.</p>

            <div class="coupon-box">
                <div class="coupon-benefit">1 Free Drink</div>
                <div class="coupon-code">{{ $coupon->code }}</div>
            </div>

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Valid From:</span>
                    <span class="detail-value">{{ $coupon->valid_from->format('d.m.Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Valid Until:</span>
                    <span class="detail-value">{{ $coupon->valid_until->format('d.m.Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">{{ $coupon->is_redeemed ? 'Redeemed' : 'Active' }}</span>
                </div>
            </div>

            <p>You can use this coupon at our café to get a free drink. Simply present this code or scan the QR code when placing your order.</p>

            <p>If you have any questions, feel free to contact us at <strong>info@kaviarennakorze.sk</strong>.</p>

            <p>Best regards,<br>
            <strong>Na Korze Team</strong></p>
        </div>

        <div class="footer">
            <p>&copy; 2025 Na Korze. Cukráreň & Kaviareň. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
