<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    
    protected $table = 'sgies_solicitud';
    public $timestamps = false;
    
    protected $fillable = ['id_bodega', 'fecha_solicitud', 'fecha_cierre', 'resuelto'];
    
    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_cierre' => 'datetime',
    ];
    
    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'id_bodega');
    }
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'sgies_productos_solicitud', 'id_solicitud', 'referencia_producto')
                    ->withPivot('cantidad_solicitada');
    }
}