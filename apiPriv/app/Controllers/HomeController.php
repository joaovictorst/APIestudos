<?php

namespace App\Controllers;

use App\Factories\PDOFactory;

class HomeController {

    private  $homeArray = [
        'message' => "BEM VINDO AO HOME DA API ",
        'stats' => "200"
    ];
    
    public function profile() {

        exit(json_encode($this->homeArray));
    }
}