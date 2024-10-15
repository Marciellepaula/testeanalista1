<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'preco_venda' => $this->faker->randomFloat(2, 1, 100),
            'descricao' => $this->faker->sentence,
            'preco_compra' => $this->faker->randomFloat(2, 1, 100),
            'quantidade_estoque' => $this->faker->numberBetween(1, 100),
            'imagem' => $this->faker->imageUrl(),
            'categoria_id' =>  Categoria::factory(),
        ];
    }
}
