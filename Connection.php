<?php

class Connection{


	public static function connect(){

		try{
			$db = new PDO('mysql:host='. HOST .';dbname=' .DBNAME. ';charset=utf8',USER,PASSWORD);
		}catch(PDOException $e){
			echo 'Algo de errado!!';
		}

		return $db;
		
	}
}


?>