<?php
namespace touiteur\class\affichage;

use touiteur\class\objets\Utilisateur;

class AffichageUtilisateur implements Renderer
{
    public Utilisateur $utilisateur;

    public function __construct(Utilisateur $utilisateur){
        $this->utilisateur = $utilisateur;
    }

    public function render(): string{
        $res = '<div id="profil_user"> <h1>' . $this->utilisateur->nom . '</h1></div>';
        return $res;
    }
}