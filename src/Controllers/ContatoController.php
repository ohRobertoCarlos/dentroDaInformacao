<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\ContatoModel;

class ContatoController {

    private $model;

    public function __construct(){
        $this->model = new ContatoModel;
    }

    public function index(){
        
        MainView::render('contato', array(
            'titulo' => 'Contato'
        ));  
    }


    public function enviarContato(){

        if($this->model->salvarUsuario()){
            $caminho = PATH_INDEX.'contato?send=true';
            header('Location: '.$caminho);
            die();

        }else{

            $caminho = PATH_INDEX.'contato?error=error';
            header('Location: '.$caminho);
            die();
            
        }
        
    }

}