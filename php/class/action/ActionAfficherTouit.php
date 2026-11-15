<?php

namespace touiteur\class\action;

use touiteur\class\affichage\TouitRenderer;
use touiteur\class\objets\Touit;
use touiteur\class\outils\DatabaseLoad;

class ActionAfficherTouit extends Action
{
    public function execute(): string
    {
        $idMessage = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if ($idMessage === false || $idMessage === null || $idMessage < 1) {
            return '<p class="touit-message touit-message--error">Identifiant de touit invalide.</p>';
        }

        $touit = DatabaseLoad::getInstance()->getTouite($idMessage);
        if ($touit === false) {
            return '<p class="touit-message">Ce touit est introuvable.</p>';
        }

        $detail = new Touit(
            (int) $touit['idMessage'],
            (string) $touit['texte'],
            (string) $touit['date_publication'],
            (string) $touit['email'],
            $touit['cheminFichier'],
            (int) $touit['Likes'],
            (float) $touit['Note']
        );

        return '
            <a class="touit-detail__back" href="?">← Retour au fil</a>
            <h2>Détail du touit</h2>
            ' . (new TouitRenderer($detail, true))->render();
    }
}