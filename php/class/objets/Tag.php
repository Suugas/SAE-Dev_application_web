<?php

namespace objets;

class Tag
{
    private int $id;
    public string $nom;
    public string $description;

    public function __construct(int $id, string $nom, string $description){
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
    }

    public function to_html():string
    {
        return "";
    }
}