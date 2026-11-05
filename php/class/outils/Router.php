<?php

namespace touiteur\class\outils;

use touiteur\class\action\ActionAddTouit;
use touiteur\class\action\ActionFollow;
use touiteur\class\action\ActionLikerTouit;
use touiteur\class\outils;

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
    switch ($this->action) {
        case 'addTouit':
            $action = new ActionAddTouit();
            break;
       case 'liker':
            $action = new ActionLikerTouit();
            break;
        case 'follow':
            $action = new ActionFollow();
            break;
        default:
            throw new RouterException("Action '{$this->action}' not found");
    }

    return $action->execute();
}

    private function renderPage(string $page): string{
        return ('
            <!DOCTYPE html>
            <html>
                <head>
                </head>
                <body>'.
                    $page
                .'</body>
            </html>
            ');
    }

}
