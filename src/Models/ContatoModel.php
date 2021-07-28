<?php

namespace App\Models;

use App\Connection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class ContatoModel {

    private $db;

    private $emailDestino;
    private $mensagem;
    private $assunto;

    public function __construct(){
        $this->db = Connection::connect();
    }


    public function salvarUsuario(){
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $id_usuario = rand(1000000,100000000);

        strval($telefone);

        if(strlen($telefone) != 11){
            return false;
        }
        //Se existir o email digitado no banco retorna 'false'
        if($this->existeEmail() != true){

        //Se já existir o telefone digitatdo no banco retorna 'false'
        if($this->existeTelefone() == true){
                return false;
            }

            $stmt = $this->db->prepare('INSERT INTO usuario(id,nome,telefone,email) VALUES (:id,:nome,:telefone,:email)');
            $stmt->bindValue(':id',$id_usuario);
            $stmt->bindValue(':nome',$nome);
            $stmt->bindValue(':telefone',$telefone);
            $stmt->bindValue(':email',$email);

            if(!$stmt->execute()){
                die('Não foi possível enviar o e-mail!');
            }

            //Envia e-mail de saudações para o usuário recém cadastrado.
            $this->setEmailDestino($email);
            $this->setAssunto('Obrigado por nos enviar seu contato!');
            $this->setMensagem('Oi '.$nome.', é importante ter uma forma como a gente se comunicar');
            $this->notificarUsuario();
            
            return true;

        }
        
        
        return false;

    }

    public function existeEmail(){

        $email = isset($_POST['email']) ? $_POST['email'] : '';

        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->bindValue(':email',$email);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }



    public function existeTelefone(){

        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';

        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE telefone = :telefone");
        $stmt->bindValue(':telefone',$telefone);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }

    public function getAssunto(){
        return $this->assunto;
    }

    public function setAssunto($assunto){
        $this->assunto = $assunto;
    }

    public function getMensagem(){
        return $this->mensagem;
    }

    public function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }

    public function getEmailDestino(){
        return $this->emailDestino;
    }

    public function setEmailDestino($emailDestino){
        $this->emailDestino = $emailDestino;
    }


    public function notificarUsuario(){

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = false;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username = getenv('EMAIL_REMETENTE');                     // SMTP username
            $mail->Password = getenv('SENHA_EMAIL_REMETENTE');                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom(getenv('EMAIL_REMETENTE'));
            $mail->addAddress($this->getEmailDestino());     // Add a recipient
           // $mail->addAddress('ellen@example.com');               // Name is optional
           // $mail->addReplyTo('info@example.com', 'Information');
           // $mail->addCC('cc@example.com');
           // $mail->addBCC('bcc@example.com');
        
            // Attachments
          //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
         //   $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->getAssunto();
            $mail->Body    = $this->getMensagem();
            $mail->AltBody = 'É necessário utilizar um client que suporte HTML para visualizar este conteúdo';
        
            $mail->send();

        } catch (Exception $e) {
            echo "Não foi possível enviar este e-mail! Por favor tente mais tarde . Detalhes do erro: {$mail->ErrorInfo}";
        }
    }
}