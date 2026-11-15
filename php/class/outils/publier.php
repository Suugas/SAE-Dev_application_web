<?php

require_once 'connexion.php';
require_once 'Touit.php';

header('Content-Type: application/json');

$message = trim($_POST['message'] ?? '');

if ($message === '' || mb_strlen($message) > 250) {
    echo json_encode(['succes' => false, 'erreur' => 'Message invalide']);
    exit;
}

try {
    $touit = new Touit($bdd);
    $ajoute = $touit->addTouit($message);
} catch (PDOException $e) {
    echo json_encode(['succes' => false, 'erreur' => 'Enregistrement impossible']);
    exit;
}

echo json_encode(['succes' => $ajoute]);
