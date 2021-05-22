<?php

namespace App\Models;

use App\Connection;

class AdminModel{

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
}