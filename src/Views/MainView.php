<?php
namespace App\Views;

class MainView{
    public static function render($view){
        include 'src/Views/templates/'.$view. '.phtml';
    }
}