<?php

namespace touiteur\class\affichage;

use touiteur\class\objets\Touit;

class TouitRenderer implements Renderer{
    private Touit $touit;

    public function __construct(Touit $touit){
        $this->touit = $touit;
    }
    public function render():string{
        // On vérifie s'il y a une image associée pour l'afficher ou non
        $imageHtml = '';
        if (!empty($this->touit->cheminFichier)) {
            $imageHtml = '
                <div class="touit__media">
                    <img src="' . htmlspecialchars($this->touit->cheminFichier) . '" alt="Image du touit" class="touit__image">
                </div>';
        }

        // On retourne la structure HTML complète
        return '
            <article class="touit-card" id="touit-' . $this->touit->idMessage . '">
                <header class="touit__header">
                    <span class="touit__author"><a href="?action=user&email='. htmlspecialchars($this->touit->email) .'">' . htmlspecialchars($this->touit->email) . '</a></span>
                    <span class="touit__date">' . htmlspecialchars($this->touit->date_publication) . '</span>
                </header>

                <div class="touit__body">
                    <p class="touit__text">' . nl2br(htmlspecialchars($this->touit->texte)) . '</p>
                    ' . $imageHtml . '
                </div>

                <footer class="touit__footer">
                    <div class="touit__action touit__action--like">
                        <button class="btn-like" data-id="' . $this->touit->idMessage . '">❤️</button>
                        <span class="count">' . $this->touit->likes . '</span>
                    </div>
                    <div class="touit__action touit__action--note">
                        <span class="icon-star">⭐</span>
                        <span class="note-value">' . $this->touit->note . '/5</span>
                    </div>
                </footer>
            </article>
        ';
    }
}
