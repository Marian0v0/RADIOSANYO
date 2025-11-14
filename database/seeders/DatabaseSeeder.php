<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bodega;
use App\Models\Producto;
use App\Models\ListadoContable;
use App\Models\Solicitud;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivar verificaciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Limpiar tablas en orden correcto (hijos primero)
        DB::table('sgies_productos_solicitud')->truncate();
        DB::table('sgies_productos_listado')->truncate();
        DB::table('sgies_productos_bodega')->truncate();
        DB::table('sgies_solicitud')->truncate();
        DB::table('sgies_listado_contable')->truncate();
        DB::table('sgies_productos')->truncate();
        DB::table('sgies_bodegas')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Creando bodegas...');
        // Crear bodegas con contraseñas usando el factory
        $bodegas = Bodega::factory()->count(5)->create();
        
        // También crear una bodega específica para testing
        Bodega::create([
            'nombre' => 'Bodega Principal',
            'password' => 'admin123',
        ]);

        $this->command->info('Creando productos desde CSV...');
        // Crear productos - el Factory intentará cargar desde CSV
        // Crear suficientes para cubrir todos los productos del CSV
        $productos = Producto::factory()->count(100)->create();
        
        // Contar productos únicos realmente creados
        $productosUnicos = $productos->unique('referencia')->values();
        $this->command->info('Productos únicos creados: ' . $productosUnicos->count());

        // Mostrar algunos productos creados para verificación
        if ($productosUnicos->count() > 0) {
            $this->command->info('Primeros 5 productos:');
            foreach ($productosUnicos->take(5) as $producto) {
                $this->command->info(" - {$producto->referencia}: {$producto->nombre} | {$producto->cantidad} | {$producto->precio}");
            }
        }

        $this->command->info('Creando listados contables...');
        $listados = ListadoContable::factory()->count(5)->create();
        
        $this->command->info('Asignando productos a bodegas...');
        foreach ($bodegas as $bodega) {
            $productosAleatorios = $productosUnicos->random(min(10, $productosUnicos->count()));
            
            foreach ($productosAleatorios as $producto) {
                DB::table('sgies_productos_bodega')->insert([
                    'id_bodega' => $bodega->id,
                    'referencia_producto' => $producto->referencia,
                    // SIN created_at y updated_at
                ]);
            }
        }
        
        $this->command->info('Asignando productos a listados contables...');
        foreach ($listados as $listado) {
            $productosAleatorios = $productosUnicos->random(min(5, $productosUnicos->count()));
            
            foreach ($productosAleatorios as $producto) {
                DB::table('sgies_productos_listado')->insert([
                    'referencia_producto' => $producto->referencia,
                    'id_listado_contable' => $listado->id,
                    'cambio_precio' => rand(0, 1),
                    'nuevo_producto' => rand(0, 1),
                    // SIN created_at y updated_at
                ]);
            }
        }
        
        $this->command->info('Creando solicitudes...');
        $solicitudes = Solicitud::factory()->count(10)->create();
        
        $this->command->info('Asignando productos a solicitudes...');
        foreach ($solicitudes as $solicitud) {
            $productosAleatorios = $productosUnicos->random(min(3, $productosUnicos->count()));
            
            foreach ($productosAleatorios as $producto) {
                DB::table('sgies_productos_solicitud')->insert([
                    'id_solicitud' => $solicitud->id,
                    'referencia_producto' => $producto->referencia,
                    'cantidad_solicitada' => rand(1, 50),
                    // SIN created_at y updated_at
                ]);
            }
        }
        
        $this->command->info('=== BASE DE DATOS POBLADA EXITOSAMENTE ===');
        $this->command->info('Bodegas: ' . ($bodegas->count() + 1));
        $this->command->info('Productos únicos: ' . $productosUnicos->count());
        $this->command->info('Listados contables: ' . $listados->count());
        $this->command->info('Solicitudes: ' . $solicitudes->count());
        $this->command->info('--- Credenciales de prueba ---');
        $this->command->info('Bodega: Bodega Principal');
        $this->command->info('Contraseña: admin123');
    }
}