<?php

namespace touiteur\class\objets;


class Touit
{
    public int $idMessage;
    public string $texte;
    public string $date_publication;
    public string $email;
    public string $cheminFichier;
    public int $likes;
    public int $note_moy;

    public function __construct(int $idMessage, string $texte, string $date_publication, string $email, string $cheminFichier, int $likes, int $note_moy){
        $this->idMessage = $idMessage;
        $this->texte = $texte;
        $this->date_publication = $date_publication;
        $this->email = $email;
        $this->cheminFichier = $cheminFichier;
        $this->likes = $likes;
        $this->note_moy = $note_moy;
    }

// like un touit
// notter un touit



}