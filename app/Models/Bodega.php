<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Bodega extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'sgies_bodegas';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre', 
        'password'
    ];
    
    protected $hidden = [
        'password',
    ];
    
    // Eliminar el cast 'hashed' y usar un mutator en su lugar
    // protected $casts = [
    //     'password' => 'hashed',
    // ];
    
    /**
     * Mutator para hashear la contraseña automáticamente
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'sgies_productos_bodega', 'id_bodega', 'referencia_producto');
    }
    
    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_bodega');
    }
}