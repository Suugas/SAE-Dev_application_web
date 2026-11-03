<?php

class Utilisateur
{
    public string $nom;
    public string $pp;

    public function __construct(string $nom, string $pp){
        $this->nom = $nom;
        $this->pp = $pp;
    }

    // Renvoie une liste des utilisateurs ayant follow ce profil
    public function getFollowers(): array {
        // Requete sql
        return array();
    }

    // Renvoie une liste des utilisateurs que follow ce profil
    public function getFollowed(): array {
        // Requete sql
        return array();
    }
}