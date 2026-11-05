<?php
namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Touit;
use touiteur\class\affichage\TouitRenderer;

class ActionForYouPage extends Action{
    public function execute(): string
    {
        $touits = DatabaseLoad::getInstance()->getTouites(0);
        $res = '<div class="touits_box">';
        foreach ($touits as $row) {
            $touit = new Touit(
                (int) $row['idMessage'],
                (string) $row['texte'],
                (string) $row['date_publication'],
                (string) $row['email'],
                (string) ($row['cheminFichier'] ?? ''),
                (int) $row['Likes'],
                (int) $row['Note']
            );
            $res .= (new TouitRenderer($touit))->render();
        }

        $res .= '</div>';
        return $res;
    }
}
