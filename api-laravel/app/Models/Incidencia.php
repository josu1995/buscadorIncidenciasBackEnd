<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table ='incidencias';

    //Relacion

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
