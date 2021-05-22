<?php
namespace App\Controllers;

use App\Views\MainView;
use App\Models\HomeModel;

class HomeController{ 

    public function index(){
        $model = new HomeModel;
        $noticias = $model->getNoticias();

        
        MainView::render('home',array(
            'titulo' => 'Home',
            'noticias' => $noticias,
            'icon' => 'icon_home.png'
        ));
    }



    public static function redirectHome(){
        $caminho = PATH_INDEX. 'home';
        header('location: '. $caminho);
        die();
    }

/*public static function getNoticias(){
        $model = new HomeModel;
        $noticias = [
            [
            'titulo_noticia' => 'Flamengo ou Fluminense?',
            'descricao_noticia' => 'Quem ganha o jogo de hoje?'
            ]
        ];
        $contentNoticia = MainView::getContent('item-noticia');

        foreach($noticias => $noticia){
            str_replace($noticia, array_keys($noticia), $contentNoticia);

            return $contentNoticia;
        }

    }*/

    public function mostrarNoticia(){
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        $model = new HomeModel;
        $noticia = $model->mostrarNoticia($slug);
        
        MainView::render('noticia',array(
            'titulo' => $noticia->titulo,
            'noticia' => $noticia
        ));
    }

}