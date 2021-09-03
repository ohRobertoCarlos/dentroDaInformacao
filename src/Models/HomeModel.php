<?php
namespace App\Models;

use App\Database\Connection;


class HomeModel {

    private $db;

    public function __construct(){
        $this->db = Connection::connect();
    }

    public function getUltimasNoticias(){
        $stmt = $this->db->prepare('SELECT * FROM noticia ORDER BY data_publicacao desc LIMIT 4');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function mostrarNoticia($id){
        $stmt = $this->db->prepare('SELECT *,DATE_FORMAT(data_publicacao,"%d/%m/%Y") AS data_formatada,n.id_autor,u.nome FROM noticia AS n LEFT JOIN usuario AS u ON (n.id_autor = u.id) WHERE n.id = :id');
        $stmt->bindValue(':id',$id);
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
    
    public function criarUsuarioAvaliarNoticia($dataAtual){
        session_start();
        $id_usuario = $_SESSION['id_usuario'] ?? '';

        //Verifica se algum usuário está logado
        if(isset($id_usuario) && $id_usuario != '' && !empty($id_usuario)){
            return $id_usuario;
        }

        //Verifica se existe algum usuário armazenado em cookies e se ele existe no banco
        if(isset($_COOKIE['usuario_anonimo'])){

            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE id = ?");
            $stmt->execute([ $_COOKIE['usuario_anonimo'] ]);

            if($stmt->rowCount() > 0){
                return $_COOKIE['usuario_anonimo'];
            }
            //insere usuário contido no cookie (e não salvo no banco) no banco de dados
            $stmt = $this->db->prepare('INSERT INTO usuario(id,nome) VALUES (:id,:nome)');

            $nomeUsuario = str_replace([' ','-',':'],'_','user'.$dataAtual.'_'.uniqid());
            $stmt->bindValue( ':nome',$nomeUsuario);
            $stmt->bindValue(':id', $_COOKIE['usuario_anonimo'] , \PDO::PARAM_INT);
            
            if($stmt->execute()) return $_COOKIE['usuario_anonimo'];
        
    }

        $nomeUsuarioAnonimo = str_replace([' ','-',':'],'_','user'.$dataAtual.'_'.uniqid());
        $idUsuarioAnonimo = rand(0,100000000);
        setcookie('usuario_anonimo', $idUsuarioAnonimo, time() + 60*60*24*365);

       try{
            $stmt = $this->db->prepare('INSERT INTO usuario(id,nome) VALUES (:id,:nome)');
            $stmt->bindValue(':nome', $nomeUsuarioAnonimo);
            $stmt->bindValue(':id', $idUsuarioAnonimo, \PDO::PARAM_INT);

        if($stmt->execute()){
            return $idUsuarioAnonimo;
        }

    }catch(\PDOException $e){
        echo $e->getMessage();
    }
    }


    public function avaliarNoticia(){

        $dataAtual = date('Y-m-d H:i:s');

        $comentario = $_POST['comentario_avaliacao'] ?? '';
        $nota = $_POST['nota_avaliacao'] ?? '';

        $id_usuario = $this->criarUsuarioAvaliarNoticia($dataAtual);
        $id_noticia = $_POST['id_noticia'] ?? '';

        try{
        $stmt = $this->db->prepare('INSERT INTO avaliacao_usuario_noticia(comentario,nota,id_usuario,id_noticia, data_avaliacao) VALUES (:comentario,:nota,:id_usuario,:id_noticia,:data_avaliacao)');
        $stmt->bindValue(':comentario', $comentario);
        $stmt->bindValue(':nota', $nota);
        $stmt->bindValue(':data_avaliacao', $dataAtual);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':id_noticia', $id_noticia);

        if($stmt->execute()){
            return json_encode([
                'status' => 'success'
            ]);
        }
    }catch(\PDOException $e){
        echo $e->getMessage();
    }

        return json_encode([
            'status' => 'error'
        ]);
    }

    public function getNoticiasDestaques(){

        $noticias = [];

        $stmt = $this->db->prepare('SELECT id_noticia, AVG(nota) AS media FROM avaliacao_usuario_noticia GROUP BY id_noticia ORDER BY media DESC LIMIT 2');
        $stmt->execute();

        $noticiasDestaque = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach($noticiasDestaque as $key => $noticia){
            $stmt = $this->db->prepare('SELECT * FROM noticia WHERE id = ?');
            $stmt->execute([$noticia['id_noticia']]);
            
            array_push($noticias,$stmt->fetch(\PDO::FETCH_ASSOC));
        }

        return $noticias;

    }
}