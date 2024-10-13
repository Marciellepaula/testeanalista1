<?php

namespace Database\Factories;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nome_cliente' => $this->faker->name,
            'cpf_cliente' => $this->faker->unique()->numerify('###.###.###-##'),
            'telefone_cliente' => $this->faker->phoneNumber,
            'email_cliente' => $this->faker->unique()->safeEmail,
            'total' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
