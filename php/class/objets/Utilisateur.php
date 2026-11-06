<?php

namespace touiteur\class\objets;

class Utilisateur {
    public string $email;
    public string $nom;
    public string $prenom;
    public int $nb_touites;

    public function __construct(string $email, string $nom, string $prenom, int $nb_touites) {
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nb_touites = $nb_touites;
    }
}