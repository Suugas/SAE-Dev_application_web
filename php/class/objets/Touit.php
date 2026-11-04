<?php

namespace touiter\class\objets;
require_once 'connexion.php';


class Touit
{

    private PDO $bdd;


    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

//envoyer un touit
    public function addTouit($touit)
    {
        $requete = $this->bdd->prepare(
            'INSERT INTO touite (Message, DateMessage)
         VALUES (:message, CURDATE())'
        );

        return $requete->execute(['message' => $touit]);
    }

// like un touit
    public function likerTouit($touitId)
    {
        // Code to like a Touit
    }

// notter un touit
    public function notterTouit($touitId)
    {
        // Code to not like a Touit
    }

    public function supprimerTouit($touitId)
    {
        // Code to delete a Touit
    }


}