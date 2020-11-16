<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;

use App\Models\Materia;
use App\Models\AlumnoMateria;
use App\Models\ProfesorMateria;



class ProfesorMateriaController
{


    public static function getProfesorMaterias($legajo){

    $profesorMateria = ProfesorMateria::select('usuario','nombre')
    
    ->join('materias','materias.idMateria','=','profesormateria.idMateria')
    ->join('usuarios','usuarios.legajo','=','profesormateria.legajo')
    ->where('profesormateria.legajo',$legajo)
    ->get();

    return $profesorMateria;

    }

}