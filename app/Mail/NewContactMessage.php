<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $msg
    ) {}

    public function build()
    {
        return $this->subject('[' . setting('site_name', 'MATIXO') . '] Yeni İletişim Mesajı Alındı')
            ->view('emails.new-contact-message');
    }
}
