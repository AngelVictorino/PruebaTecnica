<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class jsonFormaterMiddleware implements MiddlewareInterface{
    public function process (Request $request, RequestHandlerInterface  $handler):Response{
        // Obtener la respuesta generada por los manejadores (rutas, otros middlewares, etc.)
        $response = $handler->handle($request);
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    }
}