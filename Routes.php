<?php

//exemplo Application::get($rota,$controller,$funcao);

Application::get('/','home','redirectHome');
Application::get('home','home','index');
Application::get('sobre','sobre','index');
Application::get('login','login','index');
Application::get('consultaLogin','login','consultarLogin');
Application::get('sair','login','sairSessao');


?>