<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class BodegaFactory extends Factory
{
    protected $table = 'sgies_bodegas';

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement([
                'Bodega Principal',
                'Radio Sanyo 1',
                'Radio Sanyo 2',
                'Radio Sanyo 3',
                'Radio Sanyo 4',
                'Radio Sanyo 5',
            ]),
            'password' => 'password123', // La contraseña en texto plano, el mutator la hasheará
        ];
    }

    public function withPassword($password)
    {
        return $this->state([
            'password' => $password,
        ]);
    }
}