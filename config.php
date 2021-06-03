<?php
date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors','on');

const HOST = 'localhost';
const DBNAME = 'dentro_da_informacao';
const USER = 'root';
const PASSWORD = '';

const PATH_INDEX = 'http://localhost/dentroDaInformacao/';
const PATH_ROOT = __DIR__.'/';

require 'vendor/autoload.php';

require 'Application.php';
require 'Routes.php';