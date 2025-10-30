<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListadoContableFactory extends Factory
{
    protected $table = 'sgies_listado_contable';

    public function definition(): array
    {
        return [
            'fecha_registro' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}