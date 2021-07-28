<?php
namespace App\Controllers;

use App\Views\MainView;
use App\Models\HomeModel;

class HomeController{ 

    private $model;

    public function __construct(){
        $this->model = new HomeModel;
    }

    public function index(){
        $noticias = $this->model->getNoticias();

        
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
        $noticia = $this->model->mostrarNoticia($slug);

        /*echo '<pre>';
        print_r($noticia);
        echo '</pre>';
        exit();*/

        if($noticia != false){
            MainView::render('noticia',array(
                'titulo' => $noticia->titulo,
                'noticia' => $noticia
            ));
        }else{
            MainView::render('noticia-nao-encontrada',array(
                'titulo' => 'Error'
            ));
        }
        
    }

    public function todasNoticias(){
        $model = new HomeModel;
        $noticias = $this->model->todasNoticias();

        MainView::render('todas-noticias', array(
            'titulo' => 'Todas notícias',
            'noticias' => $noticias
        ));
    }

}