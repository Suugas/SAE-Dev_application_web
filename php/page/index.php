<?php
declare(strict_types=1);

namespace touiteur\page;

require_once __DIR__ . '/../class/outils/Autoloader.php';

\touiteur\class\outils\Autoloader::register();

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\outils\Router;
use touiteur\class\outils\RouterException;

DatabaseLoad::setConfig(__DIR__ . '/../../db.config.ini');

$router = new Router();

try {
    $contenu = $router->run();
} catch (RouterException $e) {
    $contenu = '<p>Page introuvable.</p>';
}

echo $contenu;
?>
