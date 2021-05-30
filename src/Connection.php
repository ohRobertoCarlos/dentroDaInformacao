<?php

namespace App;

class Connection{ 


	public static function connect(){

		try{
			$db = new \PDO('mysql:host='. HOST .';dbname=' .DBNAME. ';charset=utf8',USER,PASSWORD);
		}catch(PDOException $e){
			die("<h3>Não foi possível estabelecer comunicação com o banco de dados</h3>");
		}

		return $db;
		
	}
}


?>