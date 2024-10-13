<?php

namespace App\Services;

use App\Mail\VendaRealizada;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Envia um e-mail de venda realizada.
     *
     * @param string $email
     * @param mixed $venda
     * @return void
     */
    public function sendVendaRealizadaEmail($email, $venda)
    {
        Mail::to($email)->queue(new VendaRealizada($venda));
    }
}
