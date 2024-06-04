<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VideoController {
    private $videosFile = __DIR__ . '/../data/videos.json';
    private $favoritesFile = __DIR__ . '/../data/favorites.json';

    public function listVideos(Request $request, Response $response) {
        $videos = $this->getVideos();
        return $response->withJson($videos);
    }

    public function favoriteVideo(Request $request, Response $response, array $args) {
        $videoId = $args['id'];
        $userId = $request->getAttribute('user_id');
        $favorites = $this->getFavorites();

        if (!isset($favorites[$userId])) {
            $favorites[$userId] = [];
        }

        if (!in_array($videoId, $favorites[$userId])) {
            $favorites[$userId][] = $videoId;
        }

        file_put_contents($this->favoritesFile, json_encode($favorites));

        return $response->withJson(['status' => 'success']);
    }

    public function unfavoriteVideo(Request $request, Response $response, array $args) {
        $videoId = $args['id'];
        $userId = $request->getAttribute('user_id');
        $favorites = $this->getFavorites();

        if (isset($favorites[$userId])) {
            $favorites[$userId] = array_filter($favorites[$userId], function($id) use ($videoId) {
                return $id !== $videoId;
            });
        }

        file_put_contents($this->favoritesFile, json_encode($favorites));

        return $response->withJson(['status' => 'success']);
    }

    private function getVideos() {
        if (!file_exists($this->videosFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->videosFile), true);
    }

    private function getFavorites() {
        if (!file_exists($this->favoritesFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->favoritesFile), true);
    }
}
