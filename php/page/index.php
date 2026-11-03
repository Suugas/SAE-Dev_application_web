<?php
declare(strict_types=1);

namespace touiteur\page;

require_once __DIR__ . '/../class/outils/Autoloader.php';

\touiteur\class\outils\Autoloader::register();

use touiteur\class\objets\Utilisateur;
use touiteur\class\affichage\AffichageUtilisateur;
use touiteur\class\affichage\AffichageTagPage;
use touiteur\class\objets\Tag;

// TEST
$t = new Tag(1, "NNN", "C la descripton");
$t_render = new AffichageTagPage($t);

echo $t_render->to_html();