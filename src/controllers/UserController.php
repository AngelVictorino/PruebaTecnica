<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController {
    private $jsonFile;

    public function __construct($jsonFile) {
        $this->jsonFile = $jsonFile;
    }

    public function createUser(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();

        // Validar datos
        if (empty($data['nombre']) || empty($data['email']) || empty($data['password'])) {
            return $response->withJson(['error' => 'Faltan datos obligatorios'])->withStatus(400);
        }

        // Leer el archivo JSON existente
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        // Generar ID único para el nuevo usuario
        $id = uniqid();

        // Crear nuevo registro de usuario
        $newUser = [
            'id' => $id,
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT) // Guardar la contraseña cifrada
        ];

        // Agregar el nuevo usuario al array existente
        $users[] = $newUser;

        // Guardar el array actualizado en el archivo JSON
        file_put_contents($this->jsonFile, json_encode($users, JSON_PRETTY_PRINT));

        return $response->withJson(['message' => 'Registro exitoso', 'id' => $id])->withStatus(200);
    }

    public function getAllUsers(Request $request, Response $response, $args) {
        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        return $response->withJson($users)->withStatus(200);
    }

    public function getUserById(Request $request, Response $response, $args) {
        $id = $args['id'];

        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        foreach ($users as $user) {
            if ($user['id'] === $id) {
                return $response->withJson($user)->withStatus(200);
            }
        }

        return $response->withJson(['error' => 'Usuario no encontrado'])->withStatus(404);
    }

    public function deleteUserById(Request $request, Response $response, $args) {
        $id = $args['id'];

        $jsonData = file_get_contents($this->jsonFile);
        $users = json_decode($jsonData, true);

        $filteredUsers = array_filter($users, function ($user) use ($id) {
            return $user['id'] !== $id;
        });

        if (count($filteredUsers) < count($users)) {
            file_put_contents($this->jsonFile, json_encode(array_values($filteredUsers), JSON_PRETTY_PRINT));
            return $response->withJson(['message' => 'Usuario eliminado'])->withStatus(200);
        }

        return $response->withJson(['error' => 'Usuario no encontrado'])->withStatus(404);
    }
}

?>
