<?php

namespace touiteur\class\outils;

use touiteur\class\action\ActionAddTouit;
use touiteur\class\action\ActionLikerTouit;
use touiteur\class\outils;
use touiteur\class\action\ActionTagDescription;
use touiteur\class\action\ActionAjouterUtilisateur;

class Router
{
    protected ?string $action = null;
    protected $actions = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function addRoute(string $action, string $action_class): Router
    {
        $this->actions[$action] = $action_class;
        return $this;
    }

   public function run(): string
{
    $action = '';
    switch ($this->action) {
        case 'default': // page d'accueil (aucune action dans l'URL)
        case 'addTouit':
            $addTouite = new ActionAddTouit();
            $action = $addTouite->execute();
            break;
        case 'liker':
            $likeTouit = new ActionLikerTouit();
            $action = $likeTouit->execute();
            break;
        case 'ajouterUtilisateur':
            $ajoutUtilisateur = new ActionAjouterUtilisateur();
            $action = $ajoutUtilisateur->execute();
            break;
        case 'tag_description':
            $tagDescription = new ActionTagDescription();
            $action = $tagDescription->execute();
            break;
        default:
            $action = 'Acceuil';
            break;
    }

    return $this->renderPage($action);
}

    private function renderPage(string $page): string{
        return ('
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Touiteur</title>
                    <link rel="stylesheet" href="' . BASE_URL . '/css/style.css">
                </head>
                <body>
                    <header>
                        <h1><a href="?">Touiteur</a></h1>
                        <nav>
                            <a href="?action=addTouit">Publier</a>
                        </nav>
                    </header>

                    <main>'. $page.
                    '</main>
                </body>
            </html>
            ');
    }

}