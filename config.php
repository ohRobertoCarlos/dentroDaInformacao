<?php
use App\Common\Environment;

date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors','on');

const PATH_INDEX = 'https://localhost/dentroDaInformacao/';
const PATH_ROOT = __DIR__.'/';

//Inicia as variaveis de ambiente.
Environment::load(PATH_ROOT);

require 'Application.php';
require 'Routes.php';
