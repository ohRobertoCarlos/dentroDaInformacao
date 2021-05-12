<?php
namespace App\Controllers;

use App\Views\MainView;

class SobreController{

    public function index(){
       MainView::render('sobre');
    }

}