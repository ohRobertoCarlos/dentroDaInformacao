<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\AdminModel;


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
        $model = new AdminModel;
        $existeUsuario = $model->consultarUsuario();
        if($existeUsuario != false){
            session_start();
            $_SESSION['email_login'] = $existeUsuario['email_login'];
            $caminho = PATH_INDEX. 'admin-login';
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

        $model = new AdminModel;
        $totalNoticias = $model->totalNoticias();

        MainView::render('painel-home', array(
            'titulo' => 'Painel - HOME',
            'totalNoticias' => $totalNoticias
        ));
    }

    public function adicionarNoticia(){
        
        MainView::render('cadastrar-noticia', array(
            'titulo' => 'Adicionar Notícia'
        ));
    }

    public function salvarNoticia(){
        $model = new AdminModel;
        $model->salvarNoticia();
    }
}