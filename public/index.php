<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../src/controllers/UserController.php';

    $userController = new UserController(__DIR__ . '/../data/users.json');

    $app = AppFactory::create();

    $app->setBasePath("/pruebatecnica/public");
    
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    

    $app->get('/saludo/{nombre}', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello world!: ".$args['nombre']);
        return $response;
    });
    //crud usuario
    $app->post('/register', function (Request $request, Response $response, $args) {
        $response->getBody()->write("User registered!");
        return $response;
    });
    //$app->get('/users', function (Request $request, Response $response, $args) {
      //  $response->getBody()->write("Get all users!");
    //    return $response;
   // });
    
    $app->run();
?>