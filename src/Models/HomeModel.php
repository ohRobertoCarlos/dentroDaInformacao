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
        $stmt = $db->prepare('SELECT *,DATE_FORMAT(data_publicacao,"%d/%m/%Y") AS data_formatada,n.id_autor,u.nome FROM noticia AS n LEFT JOIN usuario AS u ON (n.id_autor = u.id) WHERE slug = :slug');
        $stmt->bindValue(':slug',$slug);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }else{
            return false;
        }

    }

    public function todasNoticias(){
        //estabelço conexão com banco
        $db = Connection::connect();

        //Query para buscar todas noticias
        $stmt = $db->prepare('SELECT * FROM noticia');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}