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
        $nPage = $_GET["page"] ?? 1;
        $touits = DatabaseLoad::getInstance()->getTouitesDuTag($libelleTag, $nPage);
        $tag = DatabaseLoad::getInstance()->getTag($libelleTag);
        $tagRenderer = new TagRenderer(new Tag($tag["idTag"], $tag["libelle"], $tag["description"]));

        $res = '
            <article class="tag_box">
                <header class="tag_box_header">
                    <h1>'. $tag["libelle"] .'</h1>
                </header>
                <div class="tag_box_body">
                    <p>'. $tag["description"] .'</p>
                </div>
            </article>
        ';
        foreach ($touits as $tou) {
            $res .= new TouitRenderer($tou)->render();
        }

        return $res;
    }
}