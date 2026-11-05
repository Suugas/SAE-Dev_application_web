<?php
namespace touiteur\class\action;
use touiteur\class\action\Action;
use touiteur\class\outils\DatabaseLoad;

class ActionFollow extends Action{

    public function execute(): string{
        $follower = $_POST['email'];
        $followed = $_SESSION['email'];
        $db = DatabaseLoad::getInstance();
        $db->follow($follower, $followed);
        return "";
    }
}
