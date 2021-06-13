<?php

class Application{


	public static function getUrl(){
		//Se a rota for a raiz, retorna o que tiver nesta rota
		if(!isset($_GET['url']))
		{
			$url = '/';

			return $url;
		}

		//se a rota nao for a raiz, retorna o que estiver nesta rota
		$url = $_GET['url'];
		//$url = explode('/',$_GET['url']);

		return $url;
	}
		



	public static function get($route,$controller,$func){


			if(self::getUrl() == $route){

				try{
					//rota encontrada
					$control = ucfirst($controller).'Controller';
					$class = 'App\\Controllers\\'.$control;
					$newController = new $class;
					$newController->$func();
				}catch(Exception $e){		
					echo "Erro!";
				}
			}else{
				return false;
			}
		}
}


?>