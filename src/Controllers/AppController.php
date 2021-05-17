<?php

namespace App\Controllers;

class AppController {

    public static function carregarPagina(){
        if(!isset($_GET['url'])){
            $contentNoticia = MainView::getContent('item-noticia');
        }
    }
}