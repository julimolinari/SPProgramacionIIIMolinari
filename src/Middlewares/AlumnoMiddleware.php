<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
// use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

class AlumnoMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        
            $token = $request->getHeader("token")[0];
            
            $key="sp";
        
        //$_SERVER['HTTP_TOKEN']
        $decoded = JWT::decode($token, $key, array('HS256'));
        
        if ($decoded->tipo != "alumno") {
            $response = new Response();
            $response->getBody()->write("No es alumno");
           
            
            return $response->withStatus(403);
        } else {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            $resp->getBody()->write("Es alumno");
            return $resp;
        }
    }
}
