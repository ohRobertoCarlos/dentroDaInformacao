<?php

namespace App\Controllers;

use App\Views\MainView;


class LoginController {

    public function index(){
        if(isset($_SESSION['nome'])){
            header('Location: home');
            die();
        }

        MainView::render('login');
    }

    public static function verificaLogin(){
    }
}