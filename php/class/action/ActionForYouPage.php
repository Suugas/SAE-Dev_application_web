<?php
namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Touit;
use touiteur\class\affichage\TouitRenderer;

class ActionForYouPage extends Action{
    public function execute(): string{
        $touit = DatabaseLoad::getInstance()->getTouites(0);
        $res = '<div class="touits_box">';
        for ($i = 0; $i < count($touit); $i++) {
            $res .= new TouitRenderer(new Touit(
                    $touit[$i][0],
                    $touit[$i][1],
                    $touit[$i][2],
                    $touit[$i][3],
                    $touit[$i][4],
                    $touit[$i][5],
                    $touit[$i][6],
                ))->render();
        }
        $res .= '</div>';

        return $res;
    }
}