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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touiteur</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <h1>Touiteur</h1>
        <nav>
            <a href="?action=addTouit">Publier</a>
        </nav>
    </header>

    <main>
        <?= $contenu ?>
    </main>
</body>
</html>
