<?php

//exemplo Application::get($rota,$controller,$funcao);

Application::get('/','home','redirectHome');
Application::get('home','home','index');
Application::get('sobre','sobre','index');
Application::get('admin','admin','index');
Application::get('consultaLogin','login','consultarLogin');
Application::get('sair','admin','sairSessao');
Application::get('contato','contato','index');


?>