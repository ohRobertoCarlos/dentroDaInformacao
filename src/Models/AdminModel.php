<?php

namespace App\Models;

use App\Database\Connection;

class AdminModel{

    private $db;
    public $nomeImagem;

    public function __construct(){
        $this->db = Connection::connect();
    }

    /**
     * Verifica a existência de um usuário
     *
     * @return boolean|array
     */
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


    /**
     * Centraliza a lógica de salvar a noticia
     *
     * @return boolean
     */
    public function salvarNoticia(){

        $imagemDetails = $_FILES['imagem-capa'];

        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
        $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : '';
        $autor = $_SESSION['id_usuario'];
        $data_publicacao = date('Y-m-d');
        $slug = $this->gerarSlug($titulo);
        $idNoticia = uniqid();


        if($this->validarImagem($imagemDetails) != true){
            die('Imagem não válida');
        }

        $nomeImagem = $this->gerarNomeImagem($imagemDetails['name']);
            
        if($this->uploadImagem($imagemDetails,$nomeImagem) != true){
                die('Erro ao cadastrar notícia!');
        }

        $thumbnail ='resources/images/'.$nomeImagem;

        $stmt = $this->db->prepare('INSERT INTO noticia(id, titulo,subtitulo, texto_conteudo, id_autor,thumbnail,descricao,slug,data_publicacao) VALUES (:id,:titulo, :subtitulo,:texto_conteudo,:autor,:thumbnail,:descricao,:slug,:data_publicacao)');

        $stmt->bindValue(':id',$idNoticia);
        $stmt->bindValue(':titulo',$titulo);
        $stmt->bindValue(':subtitulo',$subtitulo);
        $stmt->bindValue(':texto_conteudo',$conteudo);
        $stmt->bindValue(':data_publicacao',$data_publicacao);
        $stmt->bindValue(':autor',$autor);
        $stmt->bindValue(':thumbnail',$thumbnail);
        $stmt->bindValue(':descricao',$descricao);
        $stmt->bindValue(':slug',$slug);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    /**
     * pega o total de noticias cadastradas
     *
     * @return boolean|array
     */
    public function totalNoticias(){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS totalNoticias FROM noticia");
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return false;
    }

    /**
     * Faz o upload da imagem
     *
     * @param array $imagem
     * @param string $nomeImagem
     * @return boolean
     */
    public function uploadImagem($imagem,$nomeImagem){
        if(move_uploaded_file($imagem['tmp_name'],PATH_ROOT.'resources/images/'.$nomeImagem)){
            return true;
        }

        return false;
    }

    /**
     * Valida a imagem em si
     *
     * @param array $imagem
     * @return boolean
     */
    public function validarImagem($imagem){
        $tamanhoImagem = round($imagem['size']/1024);

        if($imagem['type'] == 'image/jpg' || $imagem['type'] == 'image/jpeg' || $imagem['type'] == 'image/png'){
            if($tamanhoImagem < 400){
                return true;
            }
        }

        return false;
    }

    /**
     * Gera o nome da imagem
     *
     * @param string $nomeImagem
     * @return string
     */
    public function gerarNomeImagem($nomeImagem){
        $imagem = explode('.',$nomeImagem);
        $nome = 'image';

        for($i=0;$i<10;$i++){
            $randomico = rand(1,20);
            $randomico = utf8_encode(intval($randomico));
            $nome .= $randomico;
        }

        $nomeFormatado = $nome.'.'.$imagem[1];


        return $nomeFormatado;
    }


    /**
     * Gera o slug da noticia
     *
     * @param string $titulo
     * @return string
     */
    public function gerarSlug($titulo){



        $slug = explode(' ',$titulo);

        $slugFormatado = implode('-',$slug);

        $slugFormatado = mb_strtolower($slugFormatado,'UTF-8');

        
        $slugFormatado = preg_replace('/(á|ã|â|à)/', 'a',$slugFormatado);
        $slugFormatado = preg_replace('/(é|è|ẽ|ê)/', 'e',$slugFormatado);
        $slugFormatado = preg_replace('/(í|ì|ĩ|î)/', 'i',$slugFormatado);
        $slugFormatado = preg_replace('/(ó|ò|õ|ô)/', 'o',$slugFormatado);
        $slugFormatado = preg_replace('/(ú|ù|ũ|û)/', 'u',$slugFormatado);
        $slugFormatado = str_replace(['?','!','%','+'
                                        ,'*','/','=',
                                        '(',')',',',
                                        '.'], '',$slugFormatado);

        return $slugFormatado;
    }


    /**
     * Consulta o número de noticias publicadas hoje
     *
     * @return int|array
     */
    public function noticiasHoje(){
        $hoje = date('Y-m-d');

        $stmt = $this->db->prepare('SELECT COUNT(*) as noticiasHoje FROM noticia WHERE data_publicacao = :hoje');
        $stmt->bindValue(':hoje',$hoje);

        $stmt->execute();

        if($stmt->rowCount() == 0){
            return intval(0);
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Recupera as noticias para serem gerenciadas
     *
     * @return array
     */
    public function gerenciarNoticias(){
        //Query para buscar todas noticias
        $stmt = $this->db->prepare('SELECT * FROM noticia');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Deleta uma noticia
     *
     * @param string $slug
     * @return boolean
     */
    public function deletarNoticia($id){
        //Busca a thumbnail da notícia para posteriormente ser deletada
        $stmtArquivo = $this->db->prepare('select thumbnail from noticia where id = :id');
        $stmtArquivo->bindValue(':id', $id);

        if($stmtArquivo->execute()){

            $caminhoThumbnail = $stmtArquivo->fetchAll(\PDO::FETCH_ASSOC)[0]['thumbnail'];
        }
        //Deletando notícia do banco de dados
        $stmt = $this->db->prepare("DELETE FROM noticia WHERE id = :id");
        $stmt->bindValue(':id', $id);
        
       try{
            if($stmt->execute()){
                //deleta o arquivo de thumbnail da notícia
                if(file_exists(PATH_ROOT.$caminhoThumbnail)){
                unlink(PATH_ROOT.$caminhoThumbnail);
                }
            return true;
        }
    }catch(\PDOException $e){
        echo $e->getMessage();
    }

        return false;
    }

    /**
     * Pega uma noticia em específico
     *
     * @param string $slug
     * @return array|string
     */
    public function getNoticia($id){
        $sql = 'SELECT * FROM noticia WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }

        return 'não encontrada';
    }


    /**
     * Atualiza uma noticia
     *
     * @param string $id
     * @return boolean
     */
    public function atualizarNoticia($id){
        session_start();

        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
        $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : '';
        $autor = $_SESSION['id_usuario'];
        $slug = $this->gerarSlug($titulo);
        $idNoticia = uniqid();

        if($_FILES['imagem-capa']['size'] > 0){
            $imagemDetails = $_FILES['imagem-capa'];

            if($this->validarImagem($imagemDetails) != true){
                die('Imagem não válida');
            }
    
            $this->nomeImagem = $this->gerarNomeImagem($imagemDetails['name']);
                
            if($this->uploadImagem($imagemDetails,$this->nomeImagem) != true){
                    die('Erro ao cadastrar notícia!');
            }
        }

        $thumbnail ='resources/images/'.$this->nomeImagem;

        if($_FILES['imagem-capa']['size'] > 0){
            $stmt = $this->db->prepare('UPDATE noticia set id = :id, titulo = :titulo,subtitulo = :subtitulo, texto_conteudo = :texto_conteudo, id_autor = :autor,thumbnail = :thumbnail,descricao = :descricao,slug = :slug WHERE id = :idAntigo');
            $stmt->bindValue(':thumbnail',$thumbnail);
        }else{
            $stmt = $this->db->prepare('UPDATE noticia set id = :id, titulo = :titulo,subtitulo = :subtitulo, texto_conteudo = :texto_conteudo, id_autor = :autor,descricao = :descricao,slug = :slug  WHERE id = :idAntigo');
        }


        $stmt->bindValue(':id',$idNoticia);
        $stmt->bindValue(':titulo',$titulo);
        $stmt->bindValue(':subtitulo',$subtitulo);
        $stmt->bindValue(':texto_conteudo',$conteudo);
        $stmt->bindValue(':autor',$autor);
        $stmt->bindValue(':descricao',$descricao);
        $stmt->bindValue(':slug',$slug);
        $stmt->bindValue(':idAntigo',$id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

}