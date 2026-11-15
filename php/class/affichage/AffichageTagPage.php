<?php

namespace touiteur\class\affichage;

use touiteur\class\objets\Tag;

class AffichageTagPage
{
    public Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function to_html(): string{
        return '<div class="tag"><h1>'.$this->tag->nom.'</h1><p>'.$this->tag->description.'</p></div>';
    }
    //
}