<?php
require_once 'connexion.php';


class Touit {

    private PDO $bdd;



public function __construct(PDO $bdd) {
    $this->bdd = $bdd;
}

//envoyer un touit
public function addTouit($touit) {
    // IDMessage n'est pas auto-incrémenté : on prend le numéro suivant
    $requete = $this->bdd->prepare(
        'INSERT INTO touite (IDMessage, Message, DateMessage)
         SELECT COALESCE(MAX(IDMessage), 0) + 1, :message, CURDATE()
         FROM touite'
    );

    return $requete->execute(['message' => $touit]);
}

// like un touit
public function likerTouit($touitId) {
    // Code to like a Touit
}

// notter un touit
public function notterTouit($touitId) {
    // Code to not like a Touit
}

public function supprimerTouit($touitId){
    // Code to delete a Touit
}



}