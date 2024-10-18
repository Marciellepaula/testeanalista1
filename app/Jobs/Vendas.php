<?php

namespace App\Jobs;

use App\Mail\VendaRealizada;
use App\Models\Venda;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class Vendas implements ShouldQueue
{
    use Queueable;



    public $venda;
    public $email;


    public function __construct(Venda $venda, $emailback)
    {
        $this->venda = $venda;
        $this->email = $emailback;
    }


    public function handle(): void
    {

        Mail::to('marcielle0644@gmail.com')->send(new VendaRealizada($this->venda));
    }
}
