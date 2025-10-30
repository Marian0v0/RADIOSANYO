<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    use HasFactory;
    
    protected $table = 'sgies_bodegas';
    public $timestamps = false;
    protected $fillable = ['nombre'];
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'sgies_productos_bodega', 'id_bodega', 'referencia_producto');
    }
    
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_bodega');
    }
}