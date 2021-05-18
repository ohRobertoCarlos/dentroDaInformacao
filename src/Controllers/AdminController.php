<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\LoginModel;


class AdminController {

    public function index(){
        session_start();
        if(isset($_SESSION['email_login'])){
            $caminho = PATH_INDEX. 'painel';
            header('Location: '.$caminho);
            die();
        }

        MainView::render('admin-login', array(
            'titulo' => 'Admin - Login'
        ));
    }

    public static function verificaLogin(){
    }


    public function consultarLogin(){
        $model = new LoginModel;
        $existeUsuario = $model->consultarUsuario();
        if($existeUsuario != false){
            session_start();
            $_SESSION['email_login'] = $existeUsuario['email_login'];
            $caminho = PATH_INDEX. 'home';
            header('location: '. $caminho);
            die();
        }else{
            echo 'usuario ou senha incorretos!';
        }
           
        
    }

    public function sairSessao(){
        session_start();
        unset($_SESSION['email_login']);
        header('location: admin-login');
        die();
    }

    public function home(){
        MainView::render('painel-home', array(
            'titulo' => 'Painel - HOME'
        ));
    }
}