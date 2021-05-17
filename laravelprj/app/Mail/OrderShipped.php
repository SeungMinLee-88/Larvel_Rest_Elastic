<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    protected $temppass;
    public function __construct($temppass)
    {
        //
        $this->temppass = $temppass;
    }

    public function build()
    {
        return $this->view('email.order.shipped')->with([
            'temppass' => $this->temppass]);
    }
}
