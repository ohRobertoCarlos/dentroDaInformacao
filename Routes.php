<?php

//exemplo Application::get($rota,$controller,$funcao);

Application::get('home','home','index');
Application::get('sobre','sobre','index');
Application::get('login','login','index');
Application::get('consultaLogin','login','consultarLogin');


?>