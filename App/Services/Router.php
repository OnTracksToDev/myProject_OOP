<?php

namespace App\Services;

/**
 * A very simple class router
 */
class Router
{
    private $page;
    private $action;

    public function __construct()
    {
        $this->setPage();
        $this->setAction();
    }

    public function setPage()
    {
        $this->page = isset($_GET['page']) ? strtolower($_GET['page']) : 'home';
    }
    public function getPage()
    {
        return $this->page;
    }

    public function setAction()
    {
        // Validation de l'action 
        $this->action = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';
    }

    public function getAction()
    {
        return $this->action;
    }

    public function redirectToHome()
    {
        header('Location: index.php?page=home');
        exit();
    }
    public function run()
{
    $action = 'index';
    $controllerName = 'App\Controllers\NotFoundController';

    // On charge le controller correspondant
    // En déterminant le nom du controller ex:HomeController
    // Si le fichier existe
    $controllerFile = __DIR__ . "/../Controllers/" . ucfirst($this->getPage()) . 'Controller.php';
    if (file_exists($controllerFile)) {
        $controllerName = 'App\Controllers\\' . ucfirst($this->getPage()) . 'Controller';
    }

    // On instancie la classe du controller
    $controller = new $controllerName();

    // On définit la méthode correspondante
    // Si elle existe
    if (method_exists($controller, $this->getAction())) {
        $action = $this->getAction();
    }

    // On peut exécuter ensuite la méthode
    $controller->$action();
}

    
}
