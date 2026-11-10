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
        $this->extraireTag();
        $texte = trim($_POST['contenu'] ?? '');
        $lienImage = trim($_POST['lien_image'] ?? null);

        if ($texte === '' || mb_strlen($texte) > 235) {
            return $this->formulaire('Message invalide (vide ou plus de 235 caractères).');
        }

        // a changer vu qu'on a pas encore de mail
        $email = $_SESSION['email'];

        try {
            if ($lienImage !== null) {
                if (count(DatabaseLoad::getInstance()->getImage($lienImage)) == 0){
                    DatabaseLoad::getInstance()->addImage($lienImage, $_POST["description_image"]);
                }
            }
            DatabaseLoad::getInstance()->addTouit($texte, $email, $lienImage);
        } catch (\Exception $e) {
            return $this->formulaire("Erreur : " . htmlspecialchars($e->getMessage()));
        }

        return $this->formulaire('Touit publié');
    }

    public function extraireTag(): void{
        $db = DatabaseLoad::getInstance();
        $texte = $_POST['contenu'];
        $decoupage = explode("#", $texte);
        $count = 0;
        foreach($decoupage as $tag){
            if($count>0){
                $existance = $db->getTag($tag);
                if($existance === false){
                    $db->addTag($tag);
                }
                $connexion = $db->getTag($tag);
                $lastMessage = $db->getLastTouite();
                $db->addTagMessage($lastMessage, $connexion['idTag']);
            }
            $count++;
        }
    }
}
