<?php

namespace touiteur\class\outils;

use touiteur\class\action\ActionAddTouit;
use touiteur\class\action\ActionAfficherMurTag;
use touiteur\class\action\ActionAfficherMurUtilisateur;
use touiteur\class\action\ActionFollowTag;
use touiteur\class\action\ActionForYouPage;
use touiteur\class\action\ActionLikerTouit;
use touiteur\class\action\ActionRechercher;
use touiteur\class\action\ActionFollow;
use touiteur\class\objets\Utilisateur;
use touiteur\class\action\ActionAffichageInfluenceur;
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
        case 'user':
            //$user = new ActionUtilisateur();
            $user = new ActionAfficherMurUtilisateur();
            $action = $user->execute();
            break;
        case 'search':
            $search = new ActionRechercher();
            $action = $search->execute();
            break;
        case 'tag':
            $tag = new ActionAfficherMurTag();
            $action = $tag->execute();
            break;
        case 'follow':
            $follow = new ActionFollow();
            $action = $follow->execute();
            break;
        case 'follow_tag':
            $follow = new ActionFollowTag();
            $action = $follow->execute();
            break;
        case 'influenceurs':
            $influenceurs = new ActionAffichageInfluenceur();
            $action = $influenceurs->execute();
            break;
        default:
            $fyp = new ActionForYouPage();
            $action = $fyp->execute();
            break;
    }

    return $this->renderPage($action);
}

    private function renderPage(string $page): string
{
    $liens = '';
    if (isset($_SESSION['email'])) {
        $liens .= '<a href="?action=addTouit">Publier</a>';
    }
    $liens .= '<a href="?action=search">Rechercher</a>';
    if (isset($_SESSION['email'])) {
        $email = htmlspecialchars(urlencode($_SESSION['email']));
        if (in_array($_SESSION['email'] , Utilisateur::admins)){
            $liens .= '<a href="?action=influenceurs">Influenceurs</a>';
        }
        $liens .= '<a href="?action=user&amp;email=' . $email . '">Profil</a>';
    } else {
        $liens .= '<a href="?action=ajouterUtilisateur">Connexion</a>';
    }

    return ('
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Touiteur</title>
                <link rel="stylesheet" href="' . BASE_URL . '/css/style.css">
                <link rel="icon" type="image/png" href="' . BASE_URL . '/icon.png">
            </head>
            <body>
                <header>
                    <h1><a href="?">Touiteur</a><img src="' . BASE_URL . '/icon.png" alt="" class="logo"></h1>
                    <nav>' . $liens . '</nav>
                </header>

                <main>' . $page . '</main>
            </body>
        </html>
    ');
}

}
