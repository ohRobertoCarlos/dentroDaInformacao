<?php
namespace App\Views;

class MainView{
    public static function render($view,$dados = []){
        //Converte os índices associativos em variáveis
        extract($dados, EXTR_PREFIX_SAME, 'other');

        // Manipulando buffer (conteúdo da página) para ser enviado todo de uma vez
        ob_start();
        include PATH_ROOT .'src/Views/templates/' .$view. '.phtml'; 
        // Envia o buffer (conteúdo da página) completo para o usuário 
        ob_end_flush();

    }

}