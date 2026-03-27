<?php

namespace App\Mail;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class CouponMail extends Mailable
{
    use Queueable, SerializesModels;

    public Coupon $coupon;

    /**
     * Create a new message instance.
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('formular.email_subject'),
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $qrCodePath = $this->coupon->ensureQrCodeSaved();

        $message = $this->view('emails.coupon')
            ->with([
                'coupon' => $this->coupon,
                'logoUrl' => 'http://korza.damaware.sk/logo-korza.png',
            ]);

        // Attach QR code with Content-ID for inline display
        if ($qrCodePath && file_exists($qrCodePath)) {
            $message->attachData(
                file_get_contents($qrCodePath),
                'coupon-qr.png',
                [
                    'mime' => 'image/png',
                ]
            );

            // Get the Swift message to set Content-ID
            $this->withSwiftMessage(function ($message) {
                $message->getSwiftMessage()->getChildren()[1]->setId('coupon-qr-code');
            });
        }

        return $message;
    }
}
