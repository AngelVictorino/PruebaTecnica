<?php

use Slim\App;

return function (App $app) {
    // Importar los controladores
    require __DIR__ . '/Controllers/AuthController.php';
    require __DIR__ . '/Controllers/UserController.php';
    require __DIR__ . '/Controllers/VideoController.php';
};
?>