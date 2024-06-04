<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public function __invoke(Request $request, Response $response, $next) {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            return $response->withJson(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);
        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            $request = $request->withAttribute('user_id', $decoded->id);
        } catch (\Exception $e) {
            return $response->withJson(['error' => 'Unauthorized'], 401);
        }

        return $next($request, $response);
    }
}
