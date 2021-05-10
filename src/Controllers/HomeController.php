<?php
namespace App\Controllers;

use App\Views\MainView;

class HomeController{

    public function index(){
       MainView::render('home');
    }

}