<?php
namespace App\Controllers;

use App\Views\MainView;

class HomeController{

    public function index(){
        session_start();
        if(!isset($_SESSION['nome'])){
            header('Location: login');
            die();
        }
        
       MainView::render('home');
    }

}
?>