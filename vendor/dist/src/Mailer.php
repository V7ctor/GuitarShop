<?php 

namespace Dist;

use Rain\Tpl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
	
	const USERNAME = "**********";
	const PASSWORD = "**********";
	const NAME_FROM = "GuitarShop";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {
        $config = array(
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']."/views/email/",
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
            "debug"         => false
        );
        Tpl::configure( $config );
        $tpl = new Tpl;
        foreach ($data as $key => $value) { 
            $tpl->assign($key, $value);
        }
        $html = $tpl->draw($tplName, true);
        $this->mail = new PHPMailer;

        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $this->mail->isSMTP();                                            
            $this->mail->Host       = 'smtp.gmail.com';                     
            $this->mail->SMTPAuth   = true;                                   
            $this->mail->Username   = Mailer::USERNAME;                     
            $this->mail->Password   = Mailer::PASSWORD;                               
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $this->mail->Port       = 465;                                    
        
            //Recipients
            $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
            $this->mail->addAddress($toAddress, $toName);     //Add a recipient
            $this->mail->addReplyTo('info@example.com', 'Information');
            //$this->mail->addCC('cc@example.com');
            //$this->mail->addBCC('bcc@example.com');
        
            //Attachments
            //$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $this->mail->isHTML(true);                                  //Set ethis->mail format to HTML
            $this->mail->Subject = $subject;
            //$this->mail->Body    = $html;
            $this->mail->msgHTML($html);
            $this->mail->AltBody = 'This is the body in plain text for non-HTML this->mail clients';
        
            $this->mail->send();
          
        } catch (\Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
    public function send()
    {
        return $this->mail->send();
        
    }
}

 ?>