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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sgies_productos_solicitud')->truncate();
        DB::table('sgies_productos_listado')->truncate();
        DB::table('sgies_productos_bodega')->truncate();
        DB::table('sgies_solicitud')->truncate();
        DB::table('sgies_listado_contable')->truncate();
        DB::table('sgies_productos')->truncate();
        DB::table('sgies_bodegas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Crear bodegas con contraseñas usando el factory
        $bodegas = Bodega::factory()->count(5)->create();
        
        // También crear una bodega específica para testing
        Bodega::create([
            'nombre' => 'Bodega Principal',
            'password' => 'admin123', // El mutator la hasheará automáticamente
        ]);
        
        $productos = Producto::factory()->count(50)->create();
        
        $listados = ListadoContable::factory()->count(10)->create();
        
        foreach ($bodegas as $bodega) {
            $productosAleatorios = $productos->random(rand(5, 15));
            
            foreach ($productosAleatorios as $producto) {
                DB::table('sgies_productos_bodega')->insert([
                    'id_bodega' => $bodega->id,
                    'referencia_producto' => $producto->referencia,
                ]);
            }
        }
        
        foreach ($listados as $listado) {
            $productosAleatorios = $productos->random(rand(3, 8));
            
            foreach ($productosAleatorios as $producto) {
                $existe = DB::table('sgies_productos_listado')
                    ->where('referencia_producto', $producto->referencia)
                    ->where('id_listado_contable', $listado->id)
                    ->exists();
                
                if (!$existe) {
                    DB::table('sgies_productos_listado')->insert([
                        'referencia_producto' => $producto->referencia,
                        'id_listado_contable' => $listado->id,
                        'cambio_precio' => rand(0, 1),
                        'nuevo_producto' => rand(0, 1),
                    ]);
                }
            }
        }
        
        $solicitudes = Solicitud::factory()->count(15)->create();
        
        foreach ($solicitudes as $solicitud) {
            $productosAleatorios = $productos->random(rand(1, 5));
            
            foreach ($productosAleatorios as $producto) {
                $existe = DB::table('sgies_productos_solicitud')
                    ->where('id_solicitud', $solicitud->id)
                    ->where('referencia_producto', $producto->referencia)
                    ->exists();
                
                if (!$existe) {
                    DB::table('sgies_productos_solicitud')->insert([
                        'id_solicitud' => $solicitud->id,
                        'referencia_producto' => $producto->referencia,
                        'cantidad_solicitada' => rand(1, 100),
                    ]);
                }
            }
        }
        
        $this->command->info('Base de datos poblada exitosamente!');
        $this->command->info('Bodegas: ' . ($bodegas->count() + 1));
        $this->command->info('Productos: ' . $productos->count());
        $this->command->info('Listados contables: ' . $listados->count());
        $this->command->info('Solicitudes: ' . $solicitudes->count());
        $this->command->info('Credenciales de prueba:');
        $this->command->info('Bodega: Bodega Principal');
        $this->command->info('Contraseña: admin123');
    }
}