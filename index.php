<?php

namespace touiteur\src;
require_once __DIR__ . '/outils/Autoloader.php';

\touiteur\outils\Autoloader::register();

// TEST
$u = new \touiteur\objets\Utilisateur("Alice", "avatar.png");
echo $u->affichage();