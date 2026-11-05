<?php

namespace touiteur\class\action;

use touiteur\class\action\Action;
use touiteur\class\outils\DatabaseLoad;

class ActionUtilisateur extends Action{
    public function execute(): string{
        $db = DatabaseLoad::getInstance();
        $user = $db->getUser($_GET['email']);
        $s =<<<HTML
        <Div id="Username">
            <p>{$user['nom']} {$user['prenom']}</p>
            </div>
        <div id="subscribes">
            <a href="?action=voirsubtag">Tags</a>
            <from id="abonnements" method="GET" action="?action=voirabonnements">
                <button type=submit value {$user['email']}>Abonnements: </button>
            </form>
            <from id="abonnes" method="GET" action="?action=voirabonnes">
                <button type=submit value {$user['email']}>Abonnés: </button>
            </form>
        </div>
        <br>
        <div id="touitesUtilisateur">
            <p>Nombre de touites:</p>
            <p>{$user['nombre_touites']}</p>
        </div>
        HTML;
        return $s;


    }
}
