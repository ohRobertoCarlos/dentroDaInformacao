<?php
namespace app\Models;

use App\Connection;


class HomeModel {

    public function getNoticias(){
        $db = Connection::connect();
        $stmt = $db->prepare('SELECT * FROM noticia ORDER BY data_publicacao desc LIMIT 4');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function mostrarNoticia($slug){
        $db = Connection::connect();
        $stmt = $db->prepare('SELECT * from noticia WHERE slug = :slug');
        $stmt->bindValue(':slug',$slug);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }else{
            return false;
        }

    }
}