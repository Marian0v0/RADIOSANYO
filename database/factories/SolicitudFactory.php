<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bodega;

class SolicitudFactory extends Factory
{
    protected $table = 'sgies_solicitud';

    public function definition(): array
    {
        $fechaSolicitud = $this->faker->dateTimeBetween('-6 months', 'now');
        $resuelto = $this->faker->boolean(70);
        
        return [
            'id_bodega' => Bodega::factory(),
            'fecha_solicitud' => $fechaSolicitud,
            'fecha_cierre' => $resuelto 
                ? $this->faker->dateTimeBetween($fechaSolicitud, 'now') 
                : null,
            'resuelto' => $resuelto ? 1 : 0,
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha_cierre' => null,
            'resuelto' => 0,
        ]);
    }

    public function resuelta(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'fecha_cierre' => $this->faker->dateTimeBetween($attributes['fecha_solicitud'], 'now'),
                'resuelto' => 1,
            ];
        });
    }
}