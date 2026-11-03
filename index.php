<?php

namespace touiteur\src;
use touiteur\objets\Utilisateur;
use touiteur\affichage\AffichageUtilisateur;

require_once __DIR__ . '/outils/Autoloader.php';

\touiteur\outils\Autoloader::register();

// TEST
$u = new Utilisateur("Alice", "avatar.png");
$test = new AffichageUtilisateur($u);

echo $test->afficherPageUtilisateur();