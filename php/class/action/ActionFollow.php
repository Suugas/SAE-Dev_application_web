<?php

namespace touiteur\class\action;

use touiteur\class\outils\DatabaseLoad;

class ActionFollow extends Action {
    public function execute(): string {
        // 1. Récupération sécurisée avec une chaîne vide par défaut si la session n'existe pas
        $session = $_SESSION['email'] ?? '';
        
        // 2. Récupération de l'email cible (depuis le bouton POST ou l'URL GET)
        $emailToFollow = $_POST['follow'] ?? $_GET['email'] ?? '';

        // 3. Boucliers de sécurité avant de toucher à la base de données
        if ($session === '') {
            // L'utilisateur n'est pas connecté : on le redirige vers l'accueil ou la connexion
            header('Location: ?action=default'); 
            exit;
        }

        if ($emailToFollow === '' || $session === $emailToFollow) {
            // Pas de cible, ou tentative de se suivre soi-même
            header('Location: ?action=user&email=' . urlencode($session)); 
            exit;
        }

        // 4. Exécution de la requête SQL car les variables sont saines (des strings valides)
        DatabaseLoad::getInstance()->follow($session, $emailToFollow);

        // 5. Redirection vers le mur de l'utilisateur suivi
        header('Location: ?action=user&email=' . urlencode($emailToFollow));
        exit;
    }
}