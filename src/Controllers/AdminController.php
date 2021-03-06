<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\AdminModel;


class AdminController {

    private $model;

    public function __construct(){
        $this->model = new AdminModel;
    }

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
        $existeUsuario = $this->model->consultarUsuario();
        if($existeUsuario != false){
            session_start();
            $_SESSION['email'] = $existeUsuario->email_login;
            $_SESSION['id_usuario'] = $existeUsuario->id_usuario;
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
        unset($_SESSION['id_usuario']);
        header('location: admin-login');
        die();
    }

    public function home(){

        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        $totalNoticias = $this->model->totalNoticias();
        $noticiasHoje = current($this->model->noticiasHoje());

        MainView::render('painel-home', array(
            'titulo' => 'Painel - HOME',
            'totalNoticias' => $totalNoticias->totalNoticias,
            'noticiasHoje' => $noticiasHoje->noticiasHoje
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
            'titulo' => 'Adicionar Not??cia'
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
            die('op????o inv??lida');
        }


        
        if($this->model->salvarNoticia()){
            $caminho = PATH_INDEX. 'home';
            header('Location: '.$caminho);
            die();
        }

        die('n??o foi poss??vel salvar a not??cia, tente novamente mais tarde!');

    }

    public function gerenciarNoticias(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        $noticias = $this->model->gerenciarNoticias();

        MainView::render('gerenciar-noticias',array(
            'titulo' => 'Gerenciar not??cias',
            'noticias' => $noticias
        ));
    }

    public function deletarNoticia(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        $id = $_GET['id'] ?? '';

        if($result = $this->model->deletarNoticia($id)){
            die($result);
        }

        

        return die('n??o foi poss??vel deletar noticia!');
    }

    public function editarNoticia(){
        session_start();
        if(!isset($_SESSION['email'])){
            $caminho = PATH_INDEX. 'admin-login';
            header('Location: '.$caminho);
            die();
        }

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $noticia = $this->model->getNoticia($id);

        MainView::render('editar-noticia', array(
            'titulo' => 'Editar Not??cia',
            'noticia' => $noticia
        ));
    }

    public function atualizarNoticia(){
        $id = $_GET['id'] ?? '';

        if($this->model->atualizarNoticia($id)){
            $caminho = PATH_INDEX. 'gerenciar-noticias';
            header('Location: '. $caminho);
            die();
        }

        return false;
    }
}