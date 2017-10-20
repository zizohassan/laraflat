<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplayContact extends Mailable
{
    use Queueable, SerializesModels;

    protected  $item;
    protected $text;

    public function __construct($item , $text)
    {
        $this->item = $item;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.contact.replayMessage')
            ->subject(trans('admin.Replay For your message on 5dmat-web'))
            ->with(['item' => $this->item , 'text' => $this->text]);
    }
}
