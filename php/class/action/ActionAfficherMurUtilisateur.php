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
        $res = '';
        $emailUser = $_GET["email"];
        $session = $_SESSION["email"] ?? '';
        $nPage = $_GET["page"] ?? 0;
        $touits = DatabaseLoad::getInstance()->getMurUser($emailUser, $nPage);
        $touitsUser = DatabaseLoad::getInstance()->getTouitesUtilisateur($nPage, $emailUser);
        $user = DatabaseLoad::getInstance()->getUser($emailUser);
        $utilisateurRenderer = new UtilisateurRenderer(
            new Utilisateur(
                $user["email"],
                $user["nom"],
                $user["prenom"],
                $user["nombre_touites"],
                ));

        // GESTION DU FOLLOW
        $can_follow = $session !== '' && $session !== $emailUser;
        $bouton_follow = '';

        if ($can_follow && $this->http_method == 'POST' && isset($_POST['email'])) {
            DatabaseLoad::getInstance()->follow($session, $emailUser);
            header('Location: ?action=user&email=' . urlencode($emailUser));
            exit;
        }

        if ($can_follow) {
            $libelle = (DatabaseLoad::getInstance()->isFollowed($session, $emailUser)) ? 'UNFOLLOW' : 'FOLLOW';
            $bouton_follow = '
                <form method="post" action="?action=follow&email='. htmlspecialchars(urldecode($emailUser)).'">
                    <button type="submit" name="follow" value="'. $emailUser .'">'. $libelle .'</button>
                </form>
                ';
        }

        // AFFICHAGE DU PROFILE
        $res .= '
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
            $renderer = new TouitRenderer(
                new Touit(
                    $tou["idMessage"],
                    $tou["texte"],
                    $tou["date_publication"],
                    $tou["email"],
                    $tou["cheminFichier"],
                    $tou["Likes"],
                    $tou["Note"]
                )
            );
            $res .= $renderer->render();
        }

        $res .= "<h1> Touites de l'utilisateur</h1>";
        foreach ($touitsUser as $tou) {
            $renderer = new TouitRenderer(
                new Touit(
                    $tou["idMessage"],
                    $tou["texte"],
                    $tou["date_publication"],
                    $tou["email"],
                    $tou["cheminFichier"],
                    $tou["Likes"],
                    $tou["Note"]
                )
            );
            $res .= $renderer->render();
        }

        return $res;
    }
}
