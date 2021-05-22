<?php

namespace App\Models;

use App\Connection;


class ContatoModel {


    public function salvarUsuario(){
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        $sql = "INSERT INTO usuario(nome,telefone,email) VALUES (:nome,:telefone,:email)";

        $db = Connection::connect();

        if($this->existeEmail() != true){
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':nome',$nome);
            $stmt->bindValue(':telefone',$telefone);
            $stmt->bindValue(':email',$email);
            $stmt->execute();

            return true;
        }else{
            return false;
        }

        
    }

    public function existeEmail(){

        $email = isset($_POST['email']) ? $_POST['email'] : '';

        $db = Connection::connect();
        $stmt = $db->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->bindValue(':email',$email);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }
}