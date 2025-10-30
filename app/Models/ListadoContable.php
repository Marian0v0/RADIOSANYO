<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ListadoContable extends Model
{
    use HasFactory;
    
    protected $table = 'sgies_listado_contable';
    public $timestamps = false;
    protected $fillable = ['fecha_registro'];
    
    // Agrega las conversiones de fecha
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'sgies_productos_listado', 'id_listado_contable', 'referencia_producto')
                    ->withPivot('cambio_precio', 'nuevo_producto');
    }
}