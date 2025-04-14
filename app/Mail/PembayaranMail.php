<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Swift_Image;

class PembayaranMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $logoCid;
    /**
     * Create a new message instance.
     * @param array $data
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
        $logoPath = public_path('logo.png');

        $logoCid = null;

        if (file_exists($logoPath)) {
            $logoCid = $this->embed($logoPath);
        }

        return $this->view('emailstruk')
            ->with([
                'data' => $this->data,
                'logoCid' => $logoCid,
            ])
            ->subject('Struk Pembayaran Anda');
    }
}
