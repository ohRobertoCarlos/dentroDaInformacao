<?php
namespace App\Views;

class MainView{
    public static function render($view,$dados = [],$useIndex = true){

        $dados['conteudo'] = file_get_contents( 'src/Views/templates/' .$view. '.phtml');

    $nomes_indexes = array_keys($dados);

	$nomes_indexes = array_map(function($item){
	return '{{' .$item. '}}';
	}, $nomes_indexes);

	$conteudo = str_replace($nomes_indexes, array_values($dados), $dados['conteudo']);

        if($useIndex == true){
            include 'src/Views/templates/index.phtml';
        }else{
            echo $conteudo;
        }
    }
}