<?php
namespace touiteur\class\action;

use touiteur\class\action\Action;
use touiteur\class\outils\DatabaseLoad;

require_once("Action.php");

class ActionAjouterUtilisateur extends Action{
    public function execute(): string{
        $s = '<form id="login" method="POST" action="/add" >
            <p> Login: </p>
            <input type = "email" name="email" required placeholder="Votre Email">
            <input type="text" name="nom" value="Prinny" placeholder="Nom">
            <input type="text name="prenom" value="Dood" placeholder="Prenom">
            <button type="submit">Connection</button>
        </form>';
        if($this->http_method ==='POST'){
                $db = DatabaseLoad::getInstance();
                $user = $db->getUser($_POST['email']);
                if(count($user)<1){
                    $db->addUser($_POST['email'],$_POST['nom'],$_POST['prenom']);
                    $valid = "<p> Connection effectuée</p>";
                    $s = $s.$valid;
                    $_SESSION['email'] = $_POST['email'];
                }
        }

        return $s;
    }
}
