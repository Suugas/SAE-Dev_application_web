<?php

namespace touiteur\class\affichage;

use touiteur\class\objets\Touit;

class TouitRenderer implements Renderer{
    private Touit $touit;

    public function __construct(Touit $touit){
        $this->touit = $touit;
    }
    public function render():string{
        $detailUrl = '?action=afficherTouit&idMessage=' . $this->touit->idMessage;
        $author = htmlspecialchars($this->touit->email, ENT_QUOTES, 'UTF-8');
        $initial = htmlspecialchars(strtoupper(substr($this->touit->email, 0, 1)), ENT_QUOTES, 'UTF-8');

        $imageHtml = '';
        if (!empty($this->touit->cheminFichier)) {
            $imageHtml = '
                <div class="touit__media">
                    <img src="' . BASE_URL . '/' . htmlspecialchars($this->touit->cheminFichier, ENT_QUOTES, 'UTF-8') . '" alt="Image publiée avec le touit de ' . $author . '" class="touit__image">
                </div>';
        }

        return '
            <article class="touit-card" id="touit-' . $this->touit->idMessage . '">
                <a class="touit__detail-link" href="' . $detailUrl . '" aria-label="Voir le touit de ' . $author . ' en détail">
                    <header class="touit__header">
                        <span class="touit__avatar" aria-hidden="true">' . $initial . '</span>
                        <span class="touit__identity">
                            <span class="touit__author">' . $author . '</span>
                            <time class="touit__date">' . htmlspecialchars($this->touit->date_publication, ENT_QUOTES, 'UTF-8') . '</time>
                        </span>
                        <span class="touit__more" aria-hidden="true">···</span>
                    </header>

                    <div class="touit__body">
                        <p class="touit__text">' . nl2br(htmlspecialchars($this->touit->texte, ENT_QUOTES, 'UTF-8')) . '</p>
                        ' . $imageHtml . '
                    </div>
                </a>

                <footer class="touit__footer">
                    <div class="touit__action touit__action--like">
                        <button class="btn-like" type="button" data-id="' . $this->touit->idMessage . '" aria-label="Aimer ce touit">♥</button>
                        <span class="count">' . $this->touit->likes . '</span>
                    </div>
                    <div class="touit__action touit__action--note">
                        <span class="icon-star" aria-hidden="true">★</span>
                        <span class="note-value">' . $this->touit->note_moy . '/5</span>
                    </div>
                </footer>
            </article>
        ';
    }
}
