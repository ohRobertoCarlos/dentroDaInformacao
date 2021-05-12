<?php

Application::get('/','home','index');
Application::get('sobre','sobre','index');
Application::get('login','login','index');
Application::get('consultaLogin','login','consultarLogin');


?>