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
Application::get('adicionar-noticia','admin','adicionarNoticia');
Application::get('todas-noticias','home','todasNoticias');
Application::get('salvar-noticia','admin','salvarNoticia');
Application::get('gerenciar-noticias','admin','gerenciarNoticias');
Application::get('delete','admin','deletarNoticia');
Application::get('edit','admin','editarNoticia');
Application::get('atualizar-noticia','admin','atualizarNoticia');


?>