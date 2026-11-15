<?php

namespace touiteur\class\action;
use touiteur\class\outils\DatabaseLoad;

class ActionAddTouit extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->publier();
        }

        // GET : on affiche le formulaire
        return $this->formulaire();
    }

    private function formulaire(string $message = ''): string {
        return <<<HTML
            <p>{$message}</p>
            <form method="post" action="?action=addTouit">
                <textarea name="contenu" rows="4" cols="50" placeholder="Quoi de neuf ?" required></textarea>
                <br>
                <p>Pour l'image :</p>
                <textarea name="lien_image" rows="1" cols="50" placeholder="image.png"></textarea>
                <textarea name="description_image" rows="3" cols="50" placeholder="description de l'image"></textarea>
                <br>
                <button type="submit">Publier</button>
            </form>
            HTML;
    }

    private function publier(): string {
        $texte = trim($_POST['contenu'] ?? '');
        $lienImage = trim($_POST['lien_image'] ?? '');
        $descriptionImage = trim($_POST['description_image'] ?? '');

        if ($texte === '' || mb_strlen($texte) > 235) {
            return $this->formulaire('Message invalide (vide ou plus de 235 caractères).');
        }
        // Image facultative : champ vide = pas d'image
        if ($lienImage === '') {
            $lienImage = null;
        } else {
            $urlValide = preg_match('#^https?://#i', $lienImage) && filter_var($lienImage, FILTER_VALIDATE_URL);
            $fichierLocalValide = preg_match('#^[\w./-]+$#', $lienImage);
            if ((!$urlValide && !$fichierLocalValide) || mb_strlen($lienImage) > 255) {
                return $this->formulaire("Lien d'image invalide.");
            }
        }

        $email = $_SESSION['email'] ?? null;
        if ($email === null) {
            return $this->formulaire('Vous devez être connecté pour publier.');
        }

        try {
            $db = DatabaseLoad::getInstance();

            if ($lienImage !== null && count($db->getImage($lienImage)) === 0) {
                $db->addImage($lienImage, $descriptionImage);
            }

            $idMessage = $db->addTouit($texte, $email, $lienImage);
            $this->extraireTag($texte, $idMessage);
        } catch (\Exception $e) {
            return $this->formulaire('Erreur : ' . htmlspecialchars($e->getMessage()));
        }

        return $this->formulaire('Touit publié');
    }

    private function extraireTag(string $texte, int $idMessage): void
    {
        $db = DatabaseLoad::getInstance();
        preg_match_all('/#([\p{L}\p{N}_]+)/u', $texte, $m);

        foreach (array_unique(array_map('mb_strtolower', $m[1])) as $libelle) {
            $libelle = mb_substr($libelle, 0, 50);
            if ($db->getTag($libelle) === false) {
                $db->addTag($libelle);
            }
            $tag = $db->getTag($libelle);
            $db->addTagMessage($idMessage, (int)$tag['idTag']);
        }
    }
}
