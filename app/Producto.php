<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
        protected $fillable= 
        [
            'producto_id',
            'nombre',
            'cantidad',    
        ];  
}
