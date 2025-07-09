<?php

namespace App;

use App\Core\Router;

class App {

    private static $Router; 

    public function __construct() {
       self::$Router = new Router();

       require __DIR__ . '/../routes/web.php';
    }
    public function handleRequest() {   
        $url = $_SERVER['REQUEST_URI'];
        self::$Router->dispatch($url);
    }

    public function getRoute(){
        return self::$Router->getRoutes();
    }
}