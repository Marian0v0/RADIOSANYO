<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BodegaFactory extends Factory
{
    protected $table = 'sgies_bodegas';

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement([
                'Bodega Principal',
                'Bodega Secundaria',
                'Almacén Norte',
                'Almacén Sur',
                'Bodega Central',
                'Depósito ' . $this->faker->city(),
            ]),
        ];
    }
}