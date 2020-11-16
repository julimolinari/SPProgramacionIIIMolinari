<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use \Firebase\JWT\JWT;



use App\Models\Usuario;



class UserController{

    public function getAll(Request $request, Response $response, $args)
    {
        
        $rta = Usuario::get();
        
        $response->getBody()->write(json_encode(($rta)));
        return $response;
     }

   

      public function add(Request $request, Response $response, $args)
    {
        $user = new Usuario;
        
        $body = $request->getParsedBody();

        $clave= [
            $salt = "progra3"
        ];

        
        $user->email = $body['email'];
        $user->tipo = $body['tipo'];
        $user->nombre = $body['nombre'];
        $user->clave = password_hash($body['clave'], PASSWORD_DEFAULT, $clave);
        
        $rta=400;
        $resCode = 500;

        if(!$this->emailExists($user->email) && $this->checkPassword($user->clave) &&
        !$this->checkName($user->nombre)) {
            
                $rta = json_encode(array("message" => $user->save()));
                $resCode = 201;
                var_dump("Se registró el usuario con exito.");
        }
        else {
            $rta = json_encode(array("message" => "Tiene datos erroneos o ya esta registrado."));
            $resCode = 400;
        }
        $response->getBody()->write($rta);

        return $response->withStatus($resCode);
    }

    

     public function updateOne(Request $request, Response $response, $args) {
        
        
        $user = Usuario::find($args['legajo']);

        $body = $request->getParsedBody();

        
        $user->usuario=$body['usuario'];
        $user->email = $body['email'];
        $user->tipo = $body['tipo'];
        $user->clave = $body['clave'];
                
        $rta = $user->save();
    
        $response->getBody()->write(json_encode($user));
        
         return $response;
     }

   

     public function login(Request $request, Response $response, $args) 
    {
        $body = $request->getParsedBody();

        $login = new Usuario;
        
        

        $login->email = $body['email'];
        $login->clave = $body['clave'];        
        

        $user = Usuario::where('email', '=', $login->email)->first();
        
        $isValidPass = password_verify($login->clave, $user->clave);
        
        $rta="";       
        $resCode = 500;


        if($user != null &&  !$isValidPass)
        {
            $key = "sp";
            $payload = array(
                "nombre" => $user->nombre,
                "clave" => $user->clave,
                "tipo" => $user->tipo,
                "legajo" =>$user->legajo
                
                
            );
        
            $jwt = JWT::encode($payload, $key);
            $rta = json_encode(array("message" => "Bienvenido $login->email", "token" => $jwt));
            $resCode = 200;
        }
        else {
            $rta = json_encode(array("message" => "Email o Clave erroneo."));
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

