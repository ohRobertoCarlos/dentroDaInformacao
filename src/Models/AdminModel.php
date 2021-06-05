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

        $db = Connection::connect();

        $stmt = $db->prepare('INSERT INTO noticia(id, titulo,subtitulo, texto_conteudo, id_autor,thumbnail,descricao,slug) VALUES (:id,:titulo, :subtitulo,:texto_conteudo,:autor,:thumbnail,:descricao,:slug)');

        $stmt->bindValue(':id',$idNoticia);
        $stmt->bindValue(':titulo',$titulo);
        $stmt->bindValue(':subtitulo',$subtitulo);
        $stmt->bindValue(':texto_conteudo',$conteudo);
        $stmt->bindValue(':autor',$autor);
        $stmt->bindValue(':thumbnail',$thumbnail);
        $stmt->bindValue(':descricao',$descricao);
        $stmt->bindValue(':slug',$slug);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function totalNoticias(){
        $db = Connection::connect();
        $stmt = $db->prepare("SELECT COUNT(*) AS totalNoticias FROM noticia");
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function uploadImagem($imagem,$nomeImagem){
        if(move_uploaded_file($imagem['tmp_name'],PATH_ROOT.'resources/images/'.$nomeImagem)){

            return true;
        }

            return false;
    }

    public function validarImagem($imagem){
        $tamanhoImagem = round($imagem['size']/1024);

        if($imagem['type'] == 'image/jpg' || $imagem['type'] == 'image/jpeg' || $imagem['type'] == 'image/png'){
            if($tamanhoImagem < 400){
                return true;
            }
        }

        return false;
    }

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

    public function gerarSlug($titulo){
        $slug = explode(' ',$titulo);

        $slugFormatado = implode('-',$slug);

        $slugFormatado = preg_replace('/(á|ã|â|à)/', 'a',$slugFormatado);
        $slugFormatado = preg_replace('/(é|è|ẽ|ê)/', 'e',$slugFormatado);
        $slugFormatado = preg_replace('/(í|ì|ĩ|î)/', 'i',$slugFormatado);
        $slugFormatado = preg_replace('/(ó|ò|õ|ô)/', 'o',$slugFormatado);
        $slugFormatado = preg_replace('/(ú|ù|ũ|û)/', 'u',$slugFormatado);


        return $slugFormatado;
    }


    public function noticiasHoje(){
        $hoje = date('Y-m-d');

       
        $db = Connection::connect();
        $stmt = $db->prepare('SELECT COUNT(*) as noticiasHoje FROM noticia WHERE data_publicacao = :hoje');
        $stmt->bindValue(':hoje',$hoje);

        $stmt->execute();

        if($stmt->rowCount() == 0){
            return 0;
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}