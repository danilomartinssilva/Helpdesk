<?php
namespace Admin\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use \PHPMailer;


class EnviarEmail extends AbstractPlugin
{
    public function Envio($destinatario,$assunto,$html){
        $email = new \PHPMailer();
        //SMTP
        $email->isSMTP();
        $email->Host = "smtp.googlemail.com";
        $email->SMTPAuth = true;
        $email->Username = "suporte.prefshego@gmail.com";
        $email->Password = "arroba2012";
        $email->SMTPSecure = 'ssl';
        $email->Port = 465;
         
         
        $email->From = 'suporte.prefshego@gmail.com';
        $email->FromName = 'Suporte - Prefeitura Municipal de Santa Helena de Goiás';
      /*  $email->addAddress('danilo.silva@valec.gov.br', 'Danilo Martins da Silva');
        $email->addAddress('danilomartinssilva@r7.com','Danilo Martins da Silva');*/
        for($i=0;$i<count($destinatario);$i++){
        $email->addAddress($destinatario[$i]['email'],$destinatario[$i]['nomeDestinatario']);
        }
        
        $email->addReplyTo('suporte.prefshego@gmail.com', 'Suporte');
         
        $email->isHTML(true);                                  // Set email format to HTML
         
        $email->Subject = trim($assunto);
        $email->Body = $html;
        $retorno = "";
        
         
        if(!$email->send()) {
         $retorno =  'Message could not be sent.';
        $retorno = 'Mailer Error: ' . $email->ErrorInfo;
        } else {
        $retorno = 'Message has been sent';
        }
       
        
        return $retorno;   
        
    }
    
}

?>