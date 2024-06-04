<?php
use Slim\App;
use App\Controllers\AuthController;
use App\Controllers\VideoController;

return function (App $app) {
    $app->post('/register', [AuthController::class, 'register']);
    $app->post('/login', [AuthController::class, 'login']);
    
    $app->get('/videos', [VideoController::class, 'listVideos']);
    $app->post('/videos/{id}/favorite', [VideoController::class, 'favoriteVideo']);
    $app->post('/videos/{id}/unfavorite', [VideoController::class, 'unfavoriteVideo']);
};
?>