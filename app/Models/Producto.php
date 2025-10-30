<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    
    protected $table = 'sgies_productos';
    protected $primaryKey = 'referencia';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = ['referencia', 'nombre', 'cantidad', 'precio'];
    
    public function bodegas()
    {
        return $this->belongsToMany(Bodega::class, 'sgies_productos_bodega', 'referencia_producto', 'id_bodega');
    }
    
    public function listados()
    {
        return $this->belongsToMany(ListadoContable::class, 'sgies_productos_listado', 'referencia_producto', 'id_listado_contable')
                    ->withPivot('cambio_precio', 'nuevo_producto');
    }
    
    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'sgies_productos_solicitud', 'referencia_producto', 'id_solicitud')
                    ->withPivot('cantidad_solicitada');
    }
}