<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;

class UserController {
    private $jsonFile;

    public function __construct($jsonFile) {
        $this->jsonFile = $jsonFile;
    }

    public function createUser(Request $request, Response $response, $args) {
        $data = json_decode($request->getBody(), true);

        // Validar datos
        if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
            $response->getBody()->write(json_encode(['error' => 'Todos los campos son obligatorios']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        // Verificar si el email ya existe
        foreach ($users as $user) {
            if ($user['email'] === $data['email']) {
                $response->getBody()->write(json_encode(['error' => 'El email ya está registrado']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        }

        // Crear un nuevo usuario
        $newUser = [
            'id' => uniqid(),
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
        ];

        $users[] = $newUser;

        // Guardar el archivo JSON actualizado
        file_put_contents($this->jsonFile, json_encode($users));

        $response->getBody()->write(json_encode(['message' => 'Usuario registrado exitosamente', 'id' => $newUser['id']]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function authenticateUser(Request $request, Response $response, $args) {
        $data = json_decode($request->getBody(), true);

        // Validar datos
        if (empty($data['email']) || empty($data['password'])) {
            $response->getBody()->write(json_encode(['error' => 'Email y contraseña son obligatorios']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        foreach ($users as $user) {
            if ($user['email'] === $data['email'] && password_verify($data['password'], $user['password'])) {
                $token = $this->generateJWT($user); // Función para generar JWT
                $response->getBody()->write(json_encode(['message' => 'Autenticación exitosa', 'token' => $token]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $response->getBody()->write(json_encode(['error' => 'Credenciales inválidas']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    }

    private function generateJWT($user) {
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'exp' => time() + 3600 // 1 hora de expiración
        ];

        $secret = 'your-secret-key';
        return JWT::encode($payload, $secret, 'HS256');
    }

    public function getAllUsers(Request $request, Response $response, $args) {
        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getUserById(Request $request, Response $response, $args) {
        $id = $args['id'];

        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        foreach ($users as $user) {
            if ($user['id'] === $id) {
                $response->getBody()->write(json_encode($user));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $response->getBody()->write(json_encode(['error' => 'Usuario no encontrado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    public function deleteUserById(Request $request, Response $response, $args) {
        $id = $args['id'];

        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        foreach ($users as $key => $user) {
            if ($user['id'] === $id) {
                unset($users[$key]);

                // Guardar el archivo JSON actualizado
                file_put_contents($this->jsonFile, json_encode($users));

                $response->getBody()->write(json_encode(['message' => 'Usuario eliminado exitosamente']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $response->getBody()->write(json_encode(['error' => 'Usuario no encontrado']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }
    public function logout(Request $request, Response $response, $args) {
        // Obtener el token de autorización del encabezado
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);
    
        // Verificar si el token es válido
        try {
            $decoded = JWT::decode($token, 'your-secret-key', ['HS256']);
        } catch (Exception $e) {
            // Si el token no es válido, retornar un error
            $response->getBody()->write(json_encode(['error' => 'Token inválido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    
        // Invalidar el token actual (en este caso, simplemente devolvemos un mensaje de éxito)
        $response->getBody()->write(json_encode(['message' => 'Sesión cerrada exitosamente']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
?>
