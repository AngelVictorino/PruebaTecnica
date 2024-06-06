<?php
ini_set("display_errors",1);
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    require __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__.'/../middlewares/jsonFormaterMiddleware.php';
    require __DIR__ . '/../src/controllers/UserController.php';

    
    use Selective\BasePath\BasePathMiddleware;

    $userController = new UserController(__DIR__ . '/../data/users.json');

    $app = AppFactory::create();
    
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8080')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
    $app->addBodyParsingMiddleware();

    $app->setBasePath("/PruebaTecnica/public");
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true,true,true);

    $app->add(new jsonFormaterMiddleware());
    
    $app->get('/', function (Request $request, Response $response, Array $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    

    $app->get('/saludo/{nombre}', function (Request $request, Response $response, Array $args) {
        $response->getBody()->write("Hello world!: ".$args['nombre']);
        return $response;
    });
    //crud usuario
    $app->post('/register', function (Request $request, Response $response,Array $args)use($userController) {
        $response = $userController->createUser($request,$response,$args);
        // $response->getBody()->write("User registered!");
        return $response;
    });
    $app->get('/users', function (Request $request, Response $response,Array $args)use($userController) {
        $response = $userController->getAllUsers($request,$response,$args);
        // $response->getBody()->write("User registered!");
        return $response;
    });
    $app->get('/users/{id}', function (Request $request, Response $response, $args) use ($userController) {
        return $userController->getUserById($request, $response, $args);
    });
    $app->delete('/users/{id}', function (Request $request, Response $response, $args) use ($userController) {
        return $userController->deleteUserById($request, $response, $args);
    });
    $app->post('/login', function (Request $request, Response $response, array $args) use ($userController) {
        return $userController->authenticateUser($request, $response, $args);
    });
    $app->post('/logout', function (Request $request, Response $response, $args) use ($userController) {
        return $userController->logout($request, $response, $args);
    });
   $app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});
    
    $app->run();
?>