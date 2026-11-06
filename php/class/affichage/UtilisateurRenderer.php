<?php
namespace touiteur\class\affichage;

use touiteur\class\objets\Utilisateur;

class UtilisateurRenderer implements Renderer
{
    public Utilisateur $utilisateur;

    public function __construct(Utilisateur $utilisateur){
        $this->utilisateur = $utilisateur;
    }

    public function render(): string{
        $res = '<div class="user_box"> <h1>' . $this->utilisateur->nom . " - " . $this->utilisateur->prenom . '</h1></div>';
        return $res;
    }
}