<?php

require_once 'vendor/autoload.php';

$autoload = function($class){
	if(file_exists($class. '.php')){
		include($class. '.php');
	}else{
		die('Não conseguimos encontrar a classe: '. $class);
	}
};

spl_autoload_register($autoload);

require 'config.php';