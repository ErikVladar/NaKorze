<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PersonalInformationMassMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $messageBody,
        public ?string $senderName = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function build(): self
    {
        return $this->view('emails.personal-information-mass')
            ->with([
                'subjectLine' => $this->subjectLine,
                'messageBody' => $this->messageBody,
                'senderName' => $this->senderName,
                'logoUrl' => 'http://korza.damaware.sk/logo-korza.png',
            ]);
    }
}
