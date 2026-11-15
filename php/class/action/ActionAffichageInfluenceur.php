<?php
namespace touiteur\class\action;

use touiteur\class\affichage\UtilisateurRenderer;
use touiteur\class\objets\Utilisateur;
use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Touit;
use touiteur\class\affichage\TouitRenderer;

class ActionAffichageInfluenceur extends Action{
    public function execute(): string
    {
        $page = $_GET["page"] ?? 0;
        $users = DatabaseLoad::getInstance()->getInfluenceur($page);
        $res = '<div class="touits_box">';
        foreach ($users as $row) {
            $user = new Utilisateur(
                $row['email'],
                $row['nom'],
                $row['prenom'],
                $row['nombre_touites'],
            );
            $res .= (new UtilisateurRenderer($user))->render();
            $res .= '<p>followers :'. $row["follower"];
        }

        $res .= '</div>';
        return $res;
    }
}
