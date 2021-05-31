<?php

namespace App\Controllers;

use App\Views\MainView;
use App\Models\ContatoModel;

class ContatoController {

    public function index(){
        
        MainView::render('contato', array(
            'titulo' => 'Contato',
            'icon' => 'icon_contato.png'
        ));  
    }


    public function enviarContato(){
        $model = new ContatoModel;

        if($model->salvarUsuario()){
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