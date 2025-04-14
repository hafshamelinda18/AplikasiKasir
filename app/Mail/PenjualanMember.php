<?php

namespace App\Mail;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenjualanMember extends Mailable
{
    use Queueable, SerializesModels;

    public $penjualan;
    public $pelanggan;

    public function __construct(Penjualan $penjualan, Pelanggan $pelanggan)
    {
        $this->penjualan = $penjualan;
        $this->pelanggan = $pelanggan;
    }

    public function build()
    {
        return $this->view('emails.penjualan-member')
            ->with([
                'penjualan' => $this->penjualan,
                'pelanggan' => $this->pelanggan,
            ])
            ->subject('Konfirmasi Penjualan untuk Member');
    }
}
