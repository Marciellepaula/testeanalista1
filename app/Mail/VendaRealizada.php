<?php

namespace App\Mail;

use App\Models\Venda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendaRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $venda;


    public function __construct(Venda $venda)
    {
        $this->venda = $venda;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Venda Realizada',
        );
    }


    public function build()
    {
        return $this->view('emails.vendas')
            ->subject('Venda Realizada com Sucesso!')
            ->with(['venda' => $this->venda]);
    }

    public function attachments(): array
    {
        return [];
    }
}
