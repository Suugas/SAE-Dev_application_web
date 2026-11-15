<?php

namespace touiteur\class\action;

use touiteur\class\affichage\TouitRenderer;
use touiteur\class\objets\Touit;
use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Tag;
use touiteur\class\affichage\TagRenderer;

class ActionAfficherMurTag extends Action{
    public function execute(): string{
        $libelleTag = $_GET["libelle"];
        $idTag = DatabaseLoad::getInstance()->getTag($libelleTag)["idTag"] ?? null;
        $nPage = $_GET["page"] ?? 0;
        $touits = DatabaseLoad::getInstance()->getTouitesDuTag($libelleTag, $nPage);
        $tag = DatabaseLoad::getInstance()->getTag($libelleTag);
        $description = $tag["description"] ??"";
        $res = '';
        $session = $_SESSION["email"] ?? '';

        // GESTION DU FOLLOW
        $can_follow = $session !== '';
        $bouton_follow = '';

        if ($can_follow && $this->http_method == 'POST' && isset($_POST['email'])) {
            DatabaseLoad::getInstance()->followTag($session, $idTag);
            header('Location: ?action=tag&libelle=' . urlencode($libelleTag));
            exit;
        }

        if ($can_follow) {
            $libelle = (DatabaseLoad::getInstance()->isTagFollowed($session, $idTag)) ? 'UNFOLLOW' : 'FOLLOW';
            $bouton_follow = '
                <form method="post" action="?action=follow_tag&libelle='. htmlspecialchars(urldecode($libelleTag)).'">
                    <button type="submit" name="follow_tag" value="'. $libelleTag .'">'. $libelle .'</button>
                </form>
                ';
        }

        $res = '
            <article class="tag_box">
                <header class="tag_box_header">
                    <h1>'. $tag["libelle"] .'</h1>
                </header>'.
                    $bouton_follow
                .'<div class="tag_box_body">
                    <p>'. $description .'</p>
                </div>
            </article>
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