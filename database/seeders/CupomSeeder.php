<?php

namespace Database\Seeders;

use App\Models\Cupom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CupomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cupom::factory()->count(10)->create();
    }
}
