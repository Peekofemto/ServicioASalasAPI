<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'productos', 
        'fecha', 
        'nombre_cliente', 
        'observaciones',
        'sala' ,
        'asiento' ,
        'hora' ,
        'estado', 
];

public $timestamps = false;
}
