<?php
namespace App\Views;

class MainView{
    public static function render($view,$dados = []){
        // Manipulando buffer (conteúdo da página) para ser enviado todo de uma vez
        ob_start();

        include 'src/Views/templates/' .$view. '.phtml'; 

        // Envia o buffer (conteúdo da página) completo para o usuário 
        ob_end_flush();

    }


    public Static function getContent($view){
        $content = file_get_contents('src/Views/templates/'. $view. '.phtml');

        return $content;
    }
}