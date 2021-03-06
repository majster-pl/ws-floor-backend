<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingBreakdownConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $updated;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.bookingBreakdownConfirmation')
            ->subject('New Breakdown Confirmation - ' . $this->data['reg'])
            ->with('data', $this->data);
    }
}
