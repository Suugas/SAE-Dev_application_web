<?php

namespace touiteur\page;

use touiteur\class\objets\Utilisateur;
use touiteur\class\affichage\AffichageUtilisateur;

require_once __DIR__ . '/../class/outils/Autoloader.php';

\touiteur\class\outils\Autoloader::register();

// TEST
$u = new Utilisateur("Alice", "avatar.png");
$test = new AffichageUtilisateur($u);

echo $test->afficherPageUtilisateur();