<?php

namespace touiteur\class\action;

use touiteur\class\affichage\TouitRenderer;
use touiteur\class\affichage\UtilisateurRenderer;
use touiteur\class\objets\Tag;
use touiteur\class\objets\Touit;
use touiteur\class\objets\Utilisateur;
use touiteur\class\outils\DatabaseLoad;
use touiteur\class\affichage\TagRenderer;

class ActionRechercher extends Action {
    public function execute(): string {
        $res = '
            <form id="form_search" method="post" action="?action=search">
                <label for="form_recherche">Rechercher</label>
                <input type="text" id="form_search" name="txt" placeholder="<txt>" required>

                <button type="submit" name="valider_search" value="valid_form_search">Valider</button>
            </form>
        ';
        if ($this->http_method == "POST"){
            $recherche = $_POST['txt'] ?? '';
            $resultat = DatabaseLoad::getInstance()->rechercherTouit($recherche);
            // AFFICHAGE DES TOUITS
            $res .= '<article class="touits_box">
                <header class="touits_box_header">
                    <p>Touits</p>
                </header>
                <div class="touits_box_body">';
            foreach ($resultat as $touit) {
                $t = new Touit($touit['idMessage'], $touit['texte'], $touit['date_publication'], $touit['email'], $touit['cheminFichier'], $touit['Likes'], $touit['Note']);
                $res .= (new TouitRenderer($t))->render();
            }
            $res .= '</div></article>';
            // AFFICHAGE DES TOUITOS
            $resultat = DatabaseLoad::getInstance()->rechercherUtilisateur($recherche);
            $res .= '<article class="touitos_box">
                <header class="touitos_box_header">
                    <p>Utilisateurs</p>
                </header>
                <div class="touitoss_box_body">';
            foreach ($resultat as $user) {
                $u = new Utilisateur($user['email'], $user['nom'], $user['prenom'], $user['nombre_touites']);
                $res .= (new UtilisateurRenderer($u))->render();
            }
            $res .= '</div></article>';
            // AFFICHAGE DES TAGS
            $resultat = DatabaseLoad::getInstance()->rechercherTag($recherche);
            $res .= '<article class="tags_box">
                <header class="tags_box_header">
                    <p>Tags</p>
                </header>
                <div class="tags_box_body">';
            foreach ($resultat as $tag) {
                $t = new Tag($tag['idTag'], $tag['libelle'], $tag['description']);
                $res .= (new TagRenderer($t))->render();
            }
            $res .= '</div></article>';
        }

        
        return $res;
    }
}