<?php

class Application{


	public static function getUrl(){
		if(!isset($_GET['url'])){
			$url = '/';

			return $url;
		}

		$url = $_GET['url'];

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
					//echo $e->getMessage();
					echo 'Erro!';
				}
			}else{
				return false;
			}
		}
}


?>