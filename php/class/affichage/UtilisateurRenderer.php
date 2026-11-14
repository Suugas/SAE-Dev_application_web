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
        $u = $this->utilisateur;

        $email   = htmlspecialchars($u->email);
        $nom     = htmlspecialchars($u->nom);
        $prenom  = htmlspecialchars($u->prenom);
        $lien    = '?action=user&amp;email=' . htmlspecialchars(urlencode($u->email));
        $initiales = htmlspecialchars(
            mb_strtoupper(mb_substr($u->prenom, 0, 1) . mb_substr($u->nom, 0, 1))
        );
        $libelleTouits = $u->nb_touites > 1 ? 'touits' : 'touit';

        return '
            <article class="user-card">
                <a class="user-card__avatar" href="' . $lien . '" aria-hidden="true" tabindex="-1">' . $initiales . '</a>
                <div class="user-card__info">
                    <a class="user-card__name" href="' . $lien . '">' . $prenom . ' ' . $nom . '</a>
                    <span class="user-card__email">' . $email . '</span>
                </div>
                <div class="user-card__stats">
                    <strong>' . (int) $u->nb_touites . '</strong>
                    ' . $libelleTouits . '
                </div>
            </article>
        ';
    }
}