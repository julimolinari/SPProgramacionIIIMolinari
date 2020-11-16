<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;

use App\Models\Materia;
use App\Models\AlumnoMateria;



class AlumnoMateriaController
{


    public function inscripcion(Request $request, Response $response, $args)
    {

        $materia = Materia::find($args['idMateria']);

        $token = $request->getHeader("token")[0];

        $key = "sp";


        $decoded = JWT::decode($token, $key, array('HS256'));
        
        if ($materia->cupos > 0) {

            $alumnoMateria = new AlumnoMateria;

            $alumnoMateria->legajo = $decoded->legajo;
            $alumnoMateria->idMateria = $materia->idMateria;
            print "Se Inscribió el alumno: " . $decoded->nombre . " a la materia: " . $materia->materia;


            $rta = $alumnoMateria->save();

            $response->getBody()->write(json_encode($rta));

            $materia->cupos = $materia->cupos - 1;
            $materia->save();

            return $response;
        }
    }


    public static function getAlumnoMaterias($idMateria){

        $alumnoMateria = AlumnoMateria::select('nombre','email')
    
        ->join('materias','materias.idMateria','=','alumnomateria.idMateria')
        ->join('usuarios','usuarios.legajo','=','alumnomateria.legajo')
        ->where('alumnomateria.idMateria',$idMateria)
        ->get();
        
        return $alumnoMateria;

    }

    
}
