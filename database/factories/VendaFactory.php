<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venda>
 */
class VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Venda::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(),
            'total' => $this->faker->randomFloat(2, 50, 500),
            'codigo' => Str::uuid(),
            'status' => $this->faker->word,
            'quantidade' => $this->faker->numberBetween(1, 10),
        ];
    }
}
