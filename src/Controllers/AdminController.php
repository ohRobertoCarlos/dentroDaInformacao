<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\AdminModel;


class AdminController {

    public function index(){

        session_start();
        if(isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'painel';
            header('Location: '.$caminho);
            die();
        }

        MainView::render('admin-login', array(
            'titulo' => 'Admin - Login'
        ));
    }

    public static function verificaLogin(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        return true;
    }


    public function consultarLogin(){
        $model = new AdminModel;
        $existeUsuario = $model->consultarUsuario();
        if($existeUsuario != false){
            session_start();
            $_SESSION['email'] = $existeUsuario['email_login'];
            $_SESSION['id_usuario'] = $existeUsuario['id_usuario'];
            $caminho = PATH_INDEX. 'admin-login';
            header('location: '. $caminho);
            die();
        }else{
            echo 'usuario ou senha incorretos!';
        }
           
        
    }

    public function sairSessao(){
        session_start();
        unset($_SESSION['email']);
        header('location: admin-login');
        die();
    }

    public function home(){

        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
        }

        $model = new AdminModel;
        $totalNoticias = $model->totalNoticias();

        MainView::render('painel-home', array(
            'titulo' => 'Painel - HOME',
            'totalNoticias' => $totalNoticias
        ));
    }

    public function adicionarNoticia(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }
        
        MainView::render('cadastrar-noticia', array(
            'titulo' => 'Adicionar Notícia'
        ));
    }

    public function salvarNoticia(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        if(!isset($_POST['acao'])){
            die('opção inválida');
        }


        $model = new AdminModel;
        
        if($model->salvarNoticia()){
            $caminho = PATH_INDEX. 'home';
            header('Location: '.$caminho);
            die();
        }

        die('não foi possível salvar a notícia, tente novamente mais tarde!');

    }
}