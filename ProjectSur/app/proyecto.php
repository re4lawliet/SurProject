<?php

namespace SUR;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    //
    public function scopeName($query, $name){

        if($name)
            return $query->where('nombre_proyecto', 'LIKE', "%$name%");
    
    }
}
