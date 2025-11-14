<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class ProductoFactory extends Factory
{
    protected $table = 'sgies_productos';

    private $productosFromCSV = [];
    private $csvLoaded = false;

    public function definition(): array
    {
        // Cargar productos desde CSV solo una vez
        if (!$this->csvLoaded) {
            $this->loadProductsFromCSV();
            $this->csvLoaded = true;
        }

        // Si hay productos del CSV, usar uno aleatorio
        if (!empty($this->productosFromCSV)) {
            $productoCSV = $this->faker->randomElement($this->productosFromCSV);
            
            return [
                'referencia' => $productoCSV['referencia'],
                'nombre' => $productoCSV['nombre'],
                'cantidad' => $productoCSV['cantidad'],
                'precio' => $productoCSV['precio'],
            ];
        }

        // Fallback: datos por defecto si no hay CSV
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

    private function loadProductsFromCSV(): void
    {
        $filePath = database_path('factories/src/catalogo-9-04-2024.csv');
        
        // Si no existe CSV, intentar con nombre alternativo
        if (!file_exists($filePath)) {
            $filePath = database_path('factories/src/productos.csv');
        }
        
        if (!file_exists($filePath)) {
            Log::warning("Archivo CSV no encontrado: " . database_path('factories/src/catalogo-9-04-2024.csv'));
            return;
        }

        try {
            $file = fopen($filePath, 'r');
            
            if (!$file) {
                throw new \Exception("No se pudo abrir el archivo CSV");
            }

            // Saltar la primera fila (cabeceras)
            fgetcsv($file);

            $contador = 0;
            while (($row = fgetcsv($file)) !== FALSE) {
                // Verificar que la fila tenga suficientes columnas
                if (count($row) >= 5) {
                    // Columna 1 (índice 1): nombre (segunda columna)
                    // Columna 2 (índice 2): referencia (tercera columna)  
                    // Columna 3 (índice 3): cantidad (cuarta columna)
                    // Columna 4 (índice 4): precio (quinta columna)
                    
                    $nombre = $this->cleanString($row[1] ?? '');
                    $referencia = $this->cleanString($row[2] ?? '');
                    $cantidad = $this->parseCantidad($row[3] ?? '0');
                    $precio = $this->parsePrecio($row[4] ?? '0');

                    // Validar que tenga datos mínimos y precio > 0
                    if (!empty($referencia) && !empty($nombre) && $precio > 0 && $cantidad >= 0) {
                        $this->productosFromCSV[] = [
                            'referencia' => $referencia,
                            'nombre' => $nombre,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                        ];
                        $contador++;
                    }
                }
            }

            fclose($file);
            
            Log::info("Productos cargados desde CSV: " . $contador);

        } catch (\Exception $e) {
            Log::error("Error leyendo CSV: " . $e->getMessage());
        }
    }

    private function cleanString($value): string
    {
        if (is_null($value)) {
            return '';
        }
        return trim(strval($value));
    }

    private function parseCantidad($value): int
    {
        $value = $this->cleanString($value);
        
        if ($value === '') {
            return 0;
        }
        
        // Remover comas y convertir a float primero
        $value = str_replace(',', '', $value);
        $floatValue = floatval($value);
        
        // Ignorar ceros después de la coma (convertir a entero)
        return intval($floatValue);
    }

    private function parsePrecio($value): float
    {
        $value = $this->cleanString($value);
        
        if ($value === '') {
            return 0.0;
        }
        
        // Remover puntos (separadores de miles) y comas (decimales)
        // Asumiendo formato: 1.500.000 o 1,500,000 o 1500000
        $value = str_replace('.', '', $value); // Eliminar puntos
        $value = str_replace(',', '.', $value); // Convertir comas a puntos decimales
        
        $floatValue = floatval($value);
        
        // Redondear a 2 decimales
        return round($floatValue, 2);
    }
}