<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;

//  use Utils\Auth as auth;


use App\Models\Usuario;



class UserController{

    public function getAll(Request $request, Response $response, $args)
    {
        
        $rta = Usuario::get();
        
        $response->getBody()->write(json_encode(($rta)));
        return $response;
     }

     public function addOne(Request $request, Response $response, $args)
     {
         
        $user = new Usuario;

        $body = $request->getParsedBody();

        
        $user->email = $body['email'];
        $user->tipo = $body['tipo'];
        $user->clave = $body['clave'];
        
        $rta = $user->save();
    
        $response->getBody()->write(json_encode($rta));
        
         return $response;
      }

      public function add(Request $request, Response $response, $args)
    {
        $user = new Usuario;
        //$body = json_decode($response->getBody()->getContents())[0];
        //$body = json_decode($request->getBody());
        $body = $request->getParsedBody();

        $clave= [
            $salt = "progra3"
        ];

        $user->usuario=$body['usuario'];
        $user->email = $body['email'];
        $user->tipo = $body['tipo'];
        $user->clave = password_hash($body['clave'], PASSWORD_DEFAULT, $clave);
        
        $rta=400;
        $resCode = 500;

        if(!$this->emailExists($user->email) && $this->checkPassword($user->clave)) {
            
                $rta = json_encode(array("message" => $user->save()));
                $resCode = 201;
        }
        else {
            $rta = json_encode(array("message" => "Tiene datos erroneos."));
            $resCode = 400;
        }
        $response->getBody()->write($rta);

        return $response->withStatus($resCode);
    }

     public function getOne(Request $request, Response $response, $args) {

      
        $rta = Usuario::find($args['legajo']);
       
        $response->getBody()->write(json_encode(($rta)));

        return $response;
     }

     public function updateOne(Request $request, Response $response, $args) {
        
        
        $user = Usuario::find($args['legajo']);

        $body = $request->getParsedBody();

        $clave= [
            $salt = "progra3"
        ];

        $user->usuario=$body['usuario'];
        $user->email = $body['email'];
        $user->tipo = $body['tipo'];
        $user->clave = password_hash($body['clave'], PASSWORD_DEFAULT, $clave);
                
        $rta = $user->save();
    
        $response->getBody()->write(json_encode($user));
        
         return $response;
     }

     public function deleteOne(Request $request, Response $response, $args) {
        
        $user = Usuario::find(7);
                
        $rta = $user->delete();
    
        $response->getBody()->write(json_encode($user));
        
         return $response;
     }

     public function login(Request $request, Response $response, $args) 
    {
        $body = $request->getParsedBody();

        $login = new Usuario;
        
        
        $login->usuario = $body['usuario'];
        $login->legajo = $body['legajo'];
        
        
        $user = Usuario::where('usuario', '=', $login->usuario)->first();
        
        $rta="";       
        $resCode = 500;

        if($user != null && $user->legajo == $login->legajo)
        {
            $key = "sp";
            $payload = array(
                "usuario" => $user->usuario,
                "legajo" => $user->legajo,
                "tipo" => $user->tipo,
                
                
            );
        
            $jwt = JWT::encode($payload, $key);
            $rta = json_encode(array("message" => "Bienvenido $login->usuario", "token" => $jwt));
            $resCode = 200;
        }
        else {
            $rta = json_encode(array("message" => "Usuario o legajo erronea."));
            $resCode = 400;
        }
        
        $response->getBody()->write($rta);

        return $response->withStatus($resCode);
    }


     private function emailExists(string $email) :string {
        $emails = Usuario::all();
        foreach ($emails as $dbEmail => $value) {
            if ($value->email == $email) {
                return true;
            }
        }
        return false;
     }
     
     private function checkPassword(string $pass) {
        
        if (strlen($pass) > 4) {
            return true;
        }
        return false;
     }
     
     private function checkName(string $name) {
        $names = Usuario::all();
        foreach ($names as $dbName => $value) {
           if($value->nombre != $name && strpos($name, ' ') != false) {
                return true;
           }
        }
        return false;
     }
}

