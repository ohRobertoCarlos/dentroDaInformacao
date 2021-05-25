<?php

namespace App\Models;

use App\Connection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class ContatoModel {

    private $emailDestino;
    private $mensagem;
    private $assunto;


    public function salvarUsuario(){
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        strval($telefone);

        if(strlen($telefone) != 11){
            return false;
        }

        $sql = "INSERT INTO usuario(nome,telefone,email) VALUES (:nome,:telefone,:email)";

        $db = Connection::connect();

        if($this->existeEmail() != true){

        if($this->existeTelefone() == true){
                return false;
            }

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':nome',$nome);
            $stmt->bindValue(':telefone',$telefone);
            $stmt->bindValue(':email',$email);
            $stmt->execute();

            //Envia e-mail de saudações para o usuário recém cadastrado.
            $this->setEmailDestino($email);
            $this->setAssunto('Obrigado por nos enviar seu contato!');
            $this->setMensagem('Oi '.$nome.', é importante ter uma forma como a gente se comunicar');
            $this->notificarUsuario();
            
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



    public function existeTelefone(){

        $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';

        $db = Connection::connect();
        $stmt = $db->prepare("SELECT * FROM usuario WHERE telefone = :telefone");
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
            $mail->Username   = 'rcpp157@gmail.com';                     // SMTP username
            $mail->Password   = 'robertofla123';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('rcpp157@gmail.com');
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