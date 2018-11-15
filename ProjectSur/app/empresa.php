<?php

namespace SUR;

use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    //
    public function scopeName($query, $name){

        if($name)
            return $query->where('nombre_empresa', 'LIKE', "%$name%");
    
    }
}

