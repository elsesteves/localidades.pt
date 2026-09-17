<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Email {
  
  public static function send($data) {
    $smtp = SITE_CONFIGS['smtp'];
    
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    
    try {        
         $mail->Host       = $smtp['smtp_server'];
         $mail->SMTPDebug  = $smtp['debug'];
         $mail->SMTPAuth   = $smtp['auth'];
         $mail->SMTPSecure = $smtp['secure'];
         $mail->SMTPAutoTLS = false;
         $mail->Port       = $smtp['port'];
         $mail->Username   = $smtp['sender_address'];
         $mail->Password   = $smtp['password'];

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

         if (exists($data['email'])) {
           $mail->AddAddress($data['email'], $data['email']);
         } else {
           $mail->AddAddress($smtp['to_address'], $smtp['to_alias']);
         }

         
         if (exists($smtp['reply_address'])) {
           $mail->AddReplyTo($smtp['reply_address'], \Data\Str::replaceIfEmpty($smtp['reply_alias'], $smtp['reply_address']));
         }         
         
         $mail->SetFrom($smtp['sender_address'], $smtp['sender_alias']);


         if(exists($data['cc'])) {
           if (!exists($data['ccName'])) {
             $data['ccName'] = $data['cc'];
           }
            $mail->AddCC($data['cc'], $data['ccName']);
         } else {
          if (exists($smtp['cc'])) {
            if (!exists($smtp['ccName'])) {
            $smtp['ccName'] = $smtp['cc'];
            }
           $mail->AddCC($smtp['cc'], $smtp['ccName']);
          }           
         }         

         if (exists($smtp['bcc'])) {
           $mail->AddBCC($smtp['bcc'], $smtp['bccName']);
         }
         
         
         if (exists($data['subject'])) {
           $mail->Subject = $data['subject'];
         }
         
         $mail->AltBody = 'Activate the HTML view, in order to view the message correctly.'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($data['message']);
         
         if (exists($data['attachment'])) {
           //attachment must be the path to resource
           
           if (isset($data['attachment_with_root']) && $data['attachment_with_root'] == true) {
             //path must include the real root
             $mail->AddAttachment($data['attachment']); 
           } else {
             //path is relative to project, no need for actual root
             $mail->AddAttachment(SITE_ROOT.'/'.$data['attachment']); 
           }
           
         }

      }
      catch (Exception $e) { echo $e->errorMessage(); }   //Pretty error messages from PHPMailer

      if(!$mail->Send()){
         return false;
      } else {
         return true;
      }
  }
  
}