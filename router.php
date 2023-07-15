<?php

// Include the necessary controller files
require_once __DIR__ . '/app/controllers/EpisodesController.php';
require_once __DIR__ . '/app/controllers/CharactersController.php';
require_once __DIR__ . '/app/controllers/LocationsController.php';

// Instantiate the controllers
$episodesController = new EpisodesController();
$charactersController = new CharactersController();
$locationsController = new LocationsController();

// Parse the request URL
$requestUrl = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($requestUrl, '/'));

// Extract the controller and action from the URL
$controllerName = isset($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'EpisodesController';
$action = isset($parts[1]) ? $parts[1] : 'index';

// Dispatch the request to the appropriate controller and action
switch ($controllerName) {
    case 'EpisodesController':
        if ($action === 'show' && isset($parts[2])) {
            $episodesController->show($parts[2]);
        } else {
            $episodesController->index();
        }
        break;
    case 'CharactersController':
        if ($action === 'show' && isset($parts[2])) {
            $charactersController->show($parts[2]);
        } else {
            $charactersController->index();
        }
        break;
    case 'LocationsController':
        if ($action === 'show' && isset($parts[2])) {
            $locationsController->show($parts[2]);
        } else {
            $locationsController->index();
        }
        break;
    default:
		require_once __DIR__ . '/app/views/home.php';
        break;
}