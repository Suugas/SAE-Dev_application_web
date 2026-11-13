<?php

namespace touiteur\class\action;

use touiteur\class\affichage\TouitRenderer;
use touiteur\class\affichage\UtilisateurRenderer;
use touiteur\class\objets\Touit;
use touiteur\class\objets\Utilisateur;
use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Tag;
use touiteur\class\affichage\TagRenderer;

class ActionAfficherMurUtilisateur extends Action{
    public function execute(): string{
        $emailUser = $_GET["email"];
        $nPage = $_GET["page"] ?? 0;
        // A CHANGER
        $touits = DatabaseLoad::getInstance()->getMurUser($emailUser, $nPage);
        $user = DatabaseLoad::getInstance()->getUser($emailUser);
        $utilisateurRenderer = new UtilisateurRenderer(
            new Utilisateur(
                $user["email"],
                $user["nom"],
                $user["prenom"],
                $user["nombre_touites"],
                ));
        $bouton_follow = ($_SESSION['email'] == $emailUser ? '' :
            '

            '
        );
        $res = '
            <article class="tag_box">
                <header class="tag_box_header">
                    <h1>'. $user["email"] .'</h1>
                </header>
                <div class="tag_box_body">
                    <p>'. $user["nom"] .' '. $user["prenom"] .'</p>
                </div>'.
                $bouton_follow
            .'</article>
        ';
        foreach ($touits as $tou) {
            $res .= new TouitRenderer(
                new Touit(
                    $tou["idMessage"],
                    $tou["texte"],
                    $tou["date_publication"],
                    $tou["email"],
                    $tou["cheminFichier"],
                    $tou["Likes"],
                    $tou["Note"]
                    ))->render();
        }

        return $res;
    }
}