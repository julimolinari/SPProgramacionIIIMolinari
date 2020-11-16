<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{

    protected $table = 'usuarios'; // sino le digo el nombre hace una intuicion buscando' usuarios' con s
    protected $primaryKey= 'legajo'; //para setear el pk
    // protected $incrementing = false; //para que no sea incremental
    public  $timestamps= false;//hay que decirle que no lo queremos usar si no lo tenemos, por defecto lo intenta traer.

    //asi cambio el nombre.
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
}