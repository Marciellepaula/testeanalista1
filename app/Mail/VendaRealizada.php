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

    /**
     * Create a new message instance.
     *
     * @param Venda $venda
     * @return void
     */
    public function __construct(Venda $venda)
    {
        $this->venda = $venda;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Venda Realizada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    public function build()
    {
        return $this->view('emails.venda_realizada')
            ->subject('Venda Realizada com Sucesso!')
            ->with(['venda' => $this->venda]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
