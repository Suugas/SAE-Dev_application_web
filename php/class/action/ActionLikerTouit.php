<?php

class ActionLikerTouit extends Action {

    public function execute(): string {
        if ($this->http_method !== 'POST') {
            return '<p>Méthode non autorisé.</p>';
        }

        $id = filter_var($_POST['idMessage'] ?? null, FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            return '<p>Touit invalide.</p>';
        }


        //truc tempo comme addtouit
        $email = 'test@test.fr'; 

        try {
            $estLike = DatabaseLoad::getInstance()->toggleLike($email, $id);
        } catch (\Exception $e) {
            return '<p>Erreur</p>';
        }

        return $estLike ? '<p>Touit liké </p>' : '<p>tweet unlike</p>';
    }
}

?>