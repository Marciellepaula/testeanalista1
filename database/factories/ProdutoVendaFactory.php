<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdutoVenda>
 */
class ProdutoVendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'produto_id' => Produto::factory(),
            'venda_id' => Venda::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
