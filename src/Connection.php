<?php

namespace App;

class Connection{ 


	public static function connect(){

		try{
			
			$db = new \PDO('mysql:host='. getenv('DB_HOST') .';dbname=' .getenv('DB_NAME'). ';charset=utf8',getenv('DB_USER'),getenv('DB_PASSWORD'));

		}catch(PDOException $e){
			die("<h3>Não foi possível estabelecer comunicação com o banco de dados</h3>");
		}

		return $db;
		
	}
}


?>