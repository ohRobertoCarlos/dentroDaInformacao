<?php
namespace App\Models;

use App\Database\Connection;


class HomeModel {

    private $db;

    public function __construct(){
        $this->db = Connection::connect();
    }

    public function getNoticias(){
        $stmt = $this->db->prepare('SELECT * FROM noticia ORDER BY data_publicacao desc LIMIT 4');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function mostrarNoticia($slug){
        $stmt = $this->db->prepare('SELECT *,DATE_FORMAT(data_publicacao,"%d/%m/%Y") AS data_formatada,n.id_autor,u.nome FROM noticia AS n LEFT JOIN usuario AS u ON (n.id_autor = u.id) WHERE slug = :slug');
        $stmt->bindValue(':slug',$slug);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }else{
            return false;
        }

    }

    public function todasNoticias($page, $itemsPagina){
        if($page){
            $page = $page - 1;
        }
        $limit = (int) $itemsPagina;
        $offset = (int)($page * $itemsPagina);

        $query = "SELECT * FROM noticia order by data_publicacao desc LIMIT :itemsPagina OFFSET :of";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':itemsPagina', $limit,\PDO::PARAM_INT);
        $stmt->bindValue(':of', $offset,\PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        return false;
    }

    /**
     * Calcula quantidade de páginas
     *
     * @param int $items
     * @param int $itemsPagina
     * @return int
     */
    public function pagination($items, $itemsPagina){
        $pages = ceil($items/$itemsPagina);

        return $pages;
    }

    public function qtdNoticias(){
        $stmt = $this->db->prepare('SELECT COUNT(*) as qtd_noticias FROM noticia');
        if($stmt->execute()){
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return false;
    }
}