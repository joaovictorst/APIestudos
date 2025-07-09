<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;

class UserController
{
    public function store()
    {
        
        // $json = Request::body();
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        $userService = UserService::create($json);

        if(isset($userService['error'])) {
            return Response::json([
                'error'     => true,
                'success'   => false,
                'message'   => $userService['error']
            ], 400);
        }
        Response::json([
            'error'     => false,
            'success'   => true,
            'data'      => $userService
        ], 201);
    }

    public function login(){
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        $userService = UserService::auth($json);

        if(isset($userService['error'])) {
            return Response::json([
                'error'     => true,
                'success'   => false,
                'message'   => $userService['error']
            ], 400);
        }

        Response::json([
            'error'     => false,
            'success'   => true,
            'jwt'       => $userService
        ], 200);
        return;
    }

    public function fetch(){
        $authorization = Request::authorization();

        $userService = UserService::fetch($authorization);

        if(isset($userService['error'])){
            return Response::json([
                'error'     => true,
                'success'   => false,
                'message'   => $userService['error']
            ], 400);
        }

        return Response::json([
            'error'     => false,
            'success'   => true,
            'message'   => $userService
        ], 200);

        return;
    }
}
