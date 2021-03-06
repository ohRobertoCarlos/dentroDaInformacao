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
        $noticias = $this->model->getUltimasNoticias();
        $noticiasDestaque = $this->model->getNoticiasDestaques();

        $totalNoticias = count($noticias);

        if($totalNoticias == 0){
            $totalNoticias = 'Não há noticias cadastradas!';
        }

        MainView::render('home',array(
            'titulo' => 'Home',
            'noticias' => $noticias,
            'noticias_destaque' => $noticiasDestaque,
            'total_noticias' => $totalNoticias,
            'icon' => 'icon_home.png'
        ));
    }

    public static function redirectHome(){
        $caminho = PATH_INDEX. 'home';
        header('location: '. $caminho);
        die();
    }


    public function mostrarNoticia(){
        $idNoticia = isset($_GET['id']) ? $_GET['id'] : '';
        $noticia = $this->model->mostrarNoticia($idNoticia);

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
        $page = $_GET['page'] ?? 1;
        $itemsPagina = 5;

        $qtd_noticias = $this->model->qtdNoticias()['qtd_noticias'];
        $noticias = $this->model->todasNoticias($page, $itemsPagina);

        //Ajustar noticias na ordem correta
        $noticias = array_reverse($noticias);

        $pages = $this->model->pagination($qtd_noticias,$itemsPagina);

        MainView::render('todas-noticias', array(
            'titulo' => 'Todas notícias',
            'qtd_noticias' => $qtd_noticias,
            'noticias' => $noticias,
            'pages' => $pages,
            'pageAtual' => $page
        ));
    }

    public function avaliarNoticia(){
        header('Access-Control-Allow-Origin: *');
        
        $status = $this->model->avaliarNoticia();
        print_r($status);
    }

}