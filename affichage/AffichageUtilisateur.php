<?php
namespace touiteur\src\affichage;
use touiteur\objets\Utilisateur;

class AffichageUtilisateur
{
    public Utilisateur $utilisateur;

    public function __construct(Utilisateur $utilisateur){
        $this->utilisateur = $utilisateur;
    }

    public function afficherPageUtilisateur(): string{
        $res = '<div id="profil_user"> <h1>' . $utilisateur . '</h1></div>';
        return $res;
    }
}