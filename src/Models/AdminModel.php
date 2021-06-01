<?php

namespace App\Models;

use App\Connection;

class AdminModel{

    //Consultar se usuário existe
    public function consultarUsuario(){

        $senha = isset($_POST['senha']) ? $_POST['senha'] : '' ;
        $email = isset($_POST['email_login']) ? $_POST['email_login'] : '' ;
        $db = Connection::connect();
        $sql = "select * from usuario_admin where email_login = :email and senha = :senha ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':senha',$senha);
        $stmt->execute();

        if($stmt->rowCount() != 1){
            return false;
        }

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Buscar noticias com base no intervalo definido
    public function totalNoticias(String $intervalo){
        $dataAtual = date($intervalo);
        echo $dataAtual;
    }


    public function salvarNoticia(){
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
        $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $nomeCapa = isset($_POST['imagem-capa']) ? $_POST['imagem-capa'] : '';
        $caminhoCapa = 'resources/images/'.$nomeCapa;
        $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : '';

        echo $caminhoCapa;
    }
}