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

        
        
        $materia->materia = $body['materia'];
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

        $rta = Materia::find($args['idMateria']);

        $decoded = JWT::decode($token, $key, array('HS256'));


        switch ($decoded->tipo) {
            case 'alumno':
                
                $response = "Debe ser Admin o Profesor";
                return $response;

                break;

            case 'profesor':
                $rta = AlumnoMateriaController::getAlumnoMaterias($rta->idMateria);
                $response->getBody()->write(json_encode(($rta)));
                return $response;
                break;

            case 'admin':
                $rta =AlumnoMateriaController::getAlumnoMaterias($rta->idMateria);
                $response->getBody()->write(json_encode(($rta)));
                return $response;
                break;
            
            
        }
        

    }

    public function getAll(Request $request, Response $response, $args)
    {
        
        $rta = Materia::get();
        
        $response->getBody()->write(json_encode(($rta)));
        return $response;
     }



}

