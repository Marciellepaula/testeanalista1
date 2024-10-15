<?php

namespace Database\Seeders;

use App\Models\ProdutoVenda;
use App\Models\Venda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendaSeeder extends Seeder
{
    public function run()
    {
        Venda::factory()
            ->count(10)
            ->create()
            ->each(function ($venda) {
                $venda->produtosvenda()->saveMany(ProdutoVenda::factory()->count(3)->make());
            });
    }
}
