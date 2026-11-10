<?php
declare(strict_types=1);

namespace touiteur\page;

require_once __DIR__ . '/../class/outils/Autoloader.php';

\touiteur\class\outils\Autoloader::register();

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\outils\Router;
use touiteur\class\outils\RouterException;

DatabaseLoad::setConfig(__DIR__ . '/../../db.config.ini');

// Racine web du projet, quel que soit le nom du dossier (ex : /SAE-Dev_application_web)
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME'], 3), '/'));

$router = new Router();
session_start();

try {
    $contenu = $router->run();
} catch (RouterException $e) {
    $contenu = '<p>Page introuvable.</p>';
}

echo $contenu;
?>
