<?php

namespace App\Controllers;

use App\Views\MainView;

class ContatoController {

    public function index(){
        MainView::render('contato', array(
            'titulo' => 'Contato',
            'icon' => 'icon_contato.png'
        ));  
    }
}