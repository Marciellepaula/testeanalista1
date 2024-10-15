<?php

namespace Database\Factories;

use App\Models\Cupom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cupom>
 */
class CupomFactory extends Factory
{
    protected $model = Cupom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->word . '-' . $this->faker->randomNumber(5),
            'desconto_percentual' => $this->faker->numberBetween(5, 50),
            'desconto_fixo' => $this->faker->randomFloat(2, 10, 100),
            'ativo' => $this->faker->boolean(80),
            'data_inicio' => $this->faker->dateTimeBetween('now', '+1 month'),
            'data_fim' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
