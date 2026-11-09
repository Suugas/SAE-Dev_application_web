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
                <button type="submit">Publier</button>
            </form>
            HTML;
    }

    private function publier(): string {
        $texte = trim($_POST['contenu'] ?? '');

        if ($texte === '' || mb_strlen($texte) > 235) {
            return $this->formulaire('Message invalide (vide ou plus de 235 caractères).');
        }

        // a changer vu qu'on a pas encore de mail
        $email = 'test@test.fr';

        try {
            DatabaseLoad::getInstance()->addTouit($texte, $email, null);
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
                $existance = count($db->getTag($tag))>0;
                if($existance ===false){
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
