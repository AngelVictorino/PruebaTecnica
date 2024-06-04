<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    private $usersFile = __DIR__ . '/../data/users.json';

    public function register(Request $request, Response $response) {
        $data = $request->getParsedBody();

        // Validar ReCaptcha
        $recaptchaResponse = $data['recaptcha'];
        $recaptchaSecret = $_ENV['RECAPTCHA_SECRET'];
        $recaptchaValid = $this->validateRecaptcha($recaptchaResponse, $recaptchaSecret);
        if (!$recaptchaValid) {
            return $response->withJson(['error' => 'Invalid ReCaptcha'], 400);
        }

        // Validar datos
        if ($data['password'] !== $data['confirm_password']) {
            return $response->withJson(['error' => 'Passwords do not match'], 400);
        }

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        $users = $this->getUsers();
        $user = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $passwordHash,
        ];
        $users[] = $user;

        file_put_contents($this->usersFile, json_encode($users));

        return $response->withJson($user);
    }

    public function login(Request $request, Response $response) {
        $data = $request->getParsedBody();
        $users = $this->getUsers();

        $user = array_filter($users, function($user) use ($data) {
            return ($user['email'] === $data['email'] || $user['username'] === $data['username']) && password_verify($data['password'], $user['password']);
        });

        if (empty($user)) {
            return $response->withJson(['error' => 'Invalid credentials'], 401);
        }

        $user = array_values($user)[0];
        $token = JWT::encode(['id' => $user['username']], $_ENV['JWT_SECRET'], 'HS256');
        return $response->withJson(['token' => $token]);
    }

    private function getUsers() {
        if (!file_exists($this->usersFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->usersFile), true);
    }

    private function validateRecaptcha($response, $secret) {
        $client = new \GuzzleHttp\Client();
        $res = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secret,
                'response' => $response
            ]
        ]);
        $body = json_decode($res->getBody(), true);
        return $body['success'];
    }
}
