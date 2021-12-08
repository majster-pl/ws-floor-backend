<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingArrivalConfirmation extends Mailable 
{
    use Queueable, SerializesModels;

    public $data;
    public $updated;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $updated)
    {
        $this->data = $data;
        $this->updated = $updated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.bookingArrivalConfirmation')
            ->subject('Status update [Arrived] - ' . $this->data['reg'])
            ->with('data', $this->data)->with('updated', $this->updated);
    }
}
