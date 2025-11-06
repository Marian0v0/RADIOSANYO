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
                'Bodega Secundaria',
                'Almacén Norte',
                'Almacén Sur',
                'Bodega Central',
                'Depósito ' . $this->faker->city(),
            ]),
            'password' => 'password123', // La contraseña en texto plano, el mutator la hasheará
        ];
    }

    /**
     * Para crear una bodega específica con contraseña conocida
     */
    public function withPassword($password)
    {
        return $this->state([
            'password' => $password,
        ]);
    }
}