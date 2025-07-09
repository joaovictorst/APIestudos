<?php


require_once __DIR__ . "/../vendor/autoload.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


use App\App;
use App\Factories\PDOFactory;
use App\Http\Request;

$app = new App();
$app->handleRequest();
