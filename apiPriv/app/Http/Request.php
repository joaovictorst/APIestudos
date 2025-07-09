<?php

namespace App\Http;

class Request {
    public const METHOD_GET = "GET";
    public const METHOD_POST = "POST";
    public const METHOD_PUT = "PUT";
    public const METHOD_DELETE = 'DEL';

    public static function body(){
        $json = file_get_contents('php://input') ?? [];
        return $json;
    }


    public static function authorization()
    {
        $authorization = getallheaders();

        if(!isset($authorization['Authorization'])) return ['error' => 'No Authorization header provided'];

        $authorizationPartials = explode(' ', $authorization['Authorization']);

        if(count($authorizationPartials) != 2) return ['error' => 'Please, provide a valid authorization header'];

        return $authorizationPartials[1] ?? '';
    }
}