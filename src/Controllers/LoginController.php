<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\LoginModel;


class LoginController {

    public function index(){
        if(isset($_SESSION['nome'])){
            header('Location: home');
            die();
        }

        MainView::render('login', array('titulo' => 'Login'));
    }

    public static function verificaLogin(){
    }


    public function consultarLogin(){
        $model = new LoginModel;
        $existeUsuario = $model->consultarUsuario();
        if($existeUsuario != false){
            session_start();
            $_SESSION['email_login'] = $existeUsuario['email_login'];
            header('location: home');
            die();
        }else{
            echo 'usuario ou senha incorretos!';
        }
           
        
    }
}