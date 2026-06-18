<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $original,
        public string $subjectLine,
        public string $body
    ) {}

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.contact-reply');
    }
}
