<?php
namespace App\Controllers;

use App\Views\MainView;

class HomeController{

    public function index(){
    
       MainView::render('home',
        array(
            'titulo' => 'Home',
            'thumbnail' => 'resources/images/Karol.jpg',
            'titulo_noticia' => 'Flamengo ou Fluminense?',
            'descricao_noticia' => 'Quem ganha o jogo de hoje?' 
        ));
    }



    public static function redirectHome(){
        header('location: home');
        die();
    }

}