<?php
namespace App\Views;

class MainView{
    public static function render($view,$dados = []){

        $dados['conteudo'] = file_get_contents( 'src/Views/templates/' .$view. '.phtml');

        include 'src/Views/templates/index.phtml';
    }
}