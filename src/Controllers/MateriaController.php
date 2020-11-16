<?php

namespace App\Controllers;

use App\Models\AlumnoMateria;
use App\Models\ProfesorMateria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;

use App\Models\Materia;



class MateriaController{

    public function add(Request $request, Response $response, $args)
    {
        

        $materia = new Materia;
        
        $body = $request->getParsedBody();

        
        
        $materia->nombre = $body['nombre'];
        $materia->cuatrimestre = $body['cuatrimestre'];
        $materia->cupos = $body['cupos'];
        
        
        $rta=400;
        $resCode = 500;

        if($body != null) {
            
                $rta = json_encode(array("message" => $materia->save()));
                $resCode = 201;
        }
        else {
            $rta = json_encode(array("message" => "Tiene datos erroneos o el usuario no es admin"));
            $resCode = 400;
        }
        $response->getBody()->write($rta);

        return $response->withStatus($resCode);
    }


    public function getMaterias(Request $request, Response $response, $args)
    {
        $token = $request->getHeader("token")[0];

        $key = "sp";


        $decoded = JWT::decode($token, $key, array('HS256'));


        switch ($decoded->tipo) {
            case 'alumno':
                
                $rta = AlumnoMateriaController::getAlumnoMaterias($decoded->legajo);
                $response->getBody()->write(json_encode(($rta)));
                return $response;

                break;

            case 'profesor':
                $rta = ProfesorMateriaController::getProfesorMaterias($decoded->legajo);
                $response->getBody()->write(json_encode(($rta)));
                return $response;
                break;

            case 'admin':
                $rta = AlumnoMateriaController::getAlumnoMaterias($decoded->legajo);
                $response->getBody()->write(json_encode(($rta)));
                $rtaAlumno = $response;
                $rta = ProfesorMateriaController::getProfesorMaterias($decoded->legajo);
                $response->getBody()->write(json_encode(($rta)));
                return $rtaAlumno + $response;
                break;
            
            
        }
        

    }



}

