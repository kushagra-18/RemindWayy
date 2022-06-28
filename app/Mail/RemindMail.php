<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Reminder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reminder;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
        $this->subject = 'Reminder: ' . $reminder->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.remind')
            ->from($address = 'messironaldo@gmail.com', $name = 'RemindWayy')
            ->subject($this->subject);
    }
}
