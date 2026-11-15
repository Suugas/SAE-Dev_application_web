<?php

namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;

class ActionFollowTag extends Action {
    public function execute(): string {
        // 1. Récupération sécurisée avec une chaîne vide par défaut si la session n'existe pas
        $session = $_SESSION['email'] ?? '';
        
        // 2. Récupération de l'email cible (depuis le bouton POST ou l'URL GET)
        $libelle_tag = $_POST['follow_tag'] ?? $_GET['libelle'] ?? '';
        $tagToFollow = DatabaseLoad::getInstance()->getTag($libelle_tag)["idTag"];

        // 3. Boucliers de sécurité avant de toucher à la base de données
        if ($session === '') {
            // L'utilisateur n'est pas connecté : on le redirige vers l'accueil ou la connexion
            header('Location: ?action=tag&libelle' . urlencode($libelle_tag)); 
            exit;
        }

        // 4. Exécution de la requête SQL car les variables sont saines (des strings valides)
        DatabaseLoad::getInstance()->followTag($session, $tagToFollow);

        // 5. Redirection vers le mur de l'utilisateur suivi
        header('Location: ?action=tag&libelle=' . urlencode($libelle_tag));
        exit;
    }
}