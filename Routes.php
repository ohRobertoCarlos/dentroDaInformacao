<?php

//exemplo Application::get($rota,$controller,$funcao);

Application::get('/','home','redirectHome');
Application::get('home','home','index');
Application::get('sobre','sobre','index');
Application::get('admin-login','admin','index');
Application::get('consultaLogin','admin','consultarLogin');
Application::get('sair','admin','sairSessao');
Application::get('contato','contato','index');
Application::get('painel','admin','home');
Application::get('noticia','home','mostrarNoticia');
Application::get('enviar-contato','contato','enviarContato');


?>