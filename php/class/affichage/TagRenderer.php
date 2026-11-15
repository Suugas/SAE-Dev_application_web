<?php

namespace touiteur\class\affichage;

use touiteur\class\objets\Tag;

class TagRenderer implements Renderer{
    private Tag $tag;

    public function __construct(Tag $tag){
        $this->tag = $tag;
    }
    public function render() : string{
        $res = <<<HTML
            <article class="tag_box">
                <header class="tag_box_header">
                    <span><a href="?action=tag&libelle={$this->tag->nom}">{$this->tag->nom}</a></span>
                </header>
                <div class="tag_box_body">
                    <p class="tag_box_description">
                        
                    </p>
                </div>
            </article>
            HTML;

        return $res;
    }
}