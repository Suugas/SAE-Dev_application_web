<?php

namespace touiteur\class\outils;

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
        $page = '';
        switch ($this->action) {
            case 'default': 
        }

        return $this->renderPage($page);
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