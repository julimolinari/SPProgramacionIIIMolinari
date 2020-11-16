<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;

use App\Models\Materia;
use App\Models\Notas;



class NotasController
{


    public function asignarNota(Request $request, Response $response, $args)
    {
        $notas = new Notas;
        $rta="";       
        $resCode = 500;
        
        $token = $request->getHeader("token")[0];
        $key = "sp";

        $materia = Materia::find($args['idMateria']);

        $decoded = JWT::decode($token, $key, array('HS256'));

                
        if ($decoded->tipo == "profesor") {            

            $body = $request->getBody();    
            

            $notas->idAlumno = $body->idAlumno;
            $notas->nota = $body->nota;  
            $notas->idProfesor= $decoded->legajo;
            $notas->idMateria= $materia->idMateria;
            if($notas != null){

                $rta = json_encode(array("message" => $notas->save()));
                $resCode = 201;
                var_dump("Se registró la nota.");    
            }
            
        }

        
        $response->getBody()->write($rta);
    
        return $response->withStatus($resCode);
    }

    public static function getNotas(Request $request, Response $response, $args){

        
        $idMateria = Materia::find($args['idMateria']);
        // var_dump($idMateria);
        
        $rta = Notas::select('materias.materia','nota')
        ->join('materias','materias.idMateria','=','notas.idMateria')
        ->where('notas.idMateria',$idMateria->idMateria)
        ->get();
        
        $response->getBody()->write(json_encode(($rta)));
        return $response;
    
      

    }

    
}
