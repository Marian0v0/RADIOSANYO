<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $table = 'sgies_productos';

    public function definition(): array
    {
        return [
            'referencia' => strtoupper($this->faker->unique()->bothify('PROD-####??')),
            'nombre' => $this->faker->randomElement([
                'Cable HDMI',
                'Mouse inalámbrico',
                'Teclado mecánico',
                'Monitor LED',
                'Disco duro externo',
                'Memoria USB',
                'Audífonos Bluetooth',
                'Cargador portátil',
                'Hub USB',
                'Webcam HD',
            ]) . ' ' . $this->faker->word(),
            'cantidad' => $this->faker->numberBetween(0, 500),
            'precio' => $this->faker->randomFloat(2, 10, 5000),
        ];
    }
}