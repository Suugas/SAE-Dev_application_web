<?php
namespace touiteur\class\objets;
use touiteur\class\outils\DatabaseLoad;
class Utilisateur
{
    public string $prenom;
    public string $nom;
    public string $mail;
    public int $nbTouit;

    public function __construct(string $prenom, string $nom, string $mail, int $nbTouit){
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->nbTouit = $nbTouit;
    }

    // Renvoie une liste des utilisateurs ayant follow ce profil
    private function getFollowers(): array {
        // Requete sql
        return array();
    }

    // Renvoie une liste des utilisateurs que follow ce profil
    private function getFollowed(): array
    {
        // Requete sql
        return array();
    }

    public function to_html(): string{
        return "";
    }

    public function affichage(): string {
        return "Utilisateur : " . $this->nom;
    }

    public function addUtilisateur()
    {
        $db = DadabaseLoad::getInstance();
        if ($db->getUser($this->mail).len == 0){
            $db->addUser($this->mail, $this->nom, $this->prenom);
        }
    }
}