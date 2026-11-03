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
        // si $this→action est présent dans $this→actions
        // instancier la classe correspondante et appeler la méthode
        // execute()
        // sinon

        throw new \RouterException("Action '{$this->action}' not found");
    }
}