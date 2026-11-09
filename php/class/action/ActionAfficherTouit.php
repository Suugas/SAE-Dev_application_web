<?php

namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;
use touiteur\class\objets\Touit;
use touiteur\class\affichage\TouitRenderer;


class ActionAfficherTouit extends Action
{
    public function execute(): string
    {
        $idMessage = filter_var($_GET['idMessage'] ?? null, FILTER_VALIDATE_INT);
        if ($idMessage === false || $idMessage === null || $idMessage < 1) {
            return '<p>Touit invalide.</p>';
        }

        $row = DatabaseLoad::getInstance()->getTouiteById($idMessage);
        if ($row === null) {
            return '<p>Touit introuvable.</p>';
        }

        $touit = new Touit(
            (int) $row['idMessage'],
            (string) $row['texte'],
            (string) $row['date_publication'],
            (string) $row['email'],
            (string) ($row['cheminFichier'] ?? ''),
            (int) $row['Likes'],
            (int) $row['Note']
        );

        return '<p><a href="?">Retour à la ForYouPage</a></p>'
            . (new TouitRenderer($touit))->render();
    }
}