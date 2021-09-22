<?php
use App\Common\Environment;

date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors','on');

const PATH_INDEX = 'http://localhost/dentroDaInformacao/';
const PATH_ROOT = __DIR__.'/';
const PATH_PUBLIC = __DIR__ .'/public/';

// usar caminho raiz do projeto com javascript
setcookie('path_index',PATH_INDEX);

//Inicia as variaveis de ambiente.
Environment::load(PATH_ROOT);

require 'Application.php';
require 'Routes.php';
