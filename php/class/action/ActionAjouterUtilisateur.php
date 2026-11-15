<?php
namespace touiteur\class\action;

use touiteur\class\action\Action;
use touiteur\class\outils\DatabaseLoad;

class ActionAjouterUtilisateur extends Action{
    public function execute(): string{
        $s = '<div id="connect">
            <form id="login" method="POST" action="?action=ajouterUtilisateur" >
                <p> Login: </p>
                <input type = "email" name="email" required placeholder="Votre Email">
                <input type="text" name="nom" value="Prinny" placeholder="Nom">
                <input type="text" name="prenom" value="Dood" placeholder="Prenom">
                <button type="submit">Connection</button>
            </form>
        </div>';
        print_r($_SESSION);
        if($this->http_method === 'POST'){
            $db = DatabaseLoad::getInstance();
            $user = $db->getUser($_POST['email']);
            if($user === false){
                $db->addUser($_POST['email'], $_POST['nom'], $_POST['prenom']);
                $valid = "<p> Inscription et connexion effectuées</p>";
            } else {
                $valid = "<p> Connexion effectuée (compte existant)</p>";
            }
            $_SESSION['email'] = $_POST['email'];
            $s = $s . $valid;
        }

        return $s;
    }
}
