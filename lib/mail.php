<?php
 
class mail{
 
private $email_default = "";
private $email_fromTitle = "";
private $email_from = "";
private $email_description = "";
private $email_footer = "";
 
 
function send_sec_code($to,$msg){
 $to      = $to;
$subject = $this->email_description;
$message = $this->email_description."\r\n".$msg."\r\n\r\n".$this->email_footer;
$headers = 'From: '.$this->email_fromTitle.' <'.$this->email_fromTitle . "> \r\n" .
    'Reply-To: '.$this->email_fromTitle. "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(!mail($to, $subject, $message, $headers)){
	$err=new error();$err->add('soapError','mail','err') ;}
	
} 
function __construct(){
	$cnfg=new aConf();
 	$this->email_default = $cnfg->cnf_email_default;
	$this->email_fromTitle =$cnfg->cnf_email_fromTitle;
	$this->email_from = $cnfg->cnf_email_from;
	$this->email_description = $cnfg->cnf_email_description;
	$this->email_footer= $cnfg->cnf_email_footer;
 }
}
 $mail= new mail();
  $mail->send_sec_code('shokoohsoft@gmail.com','تغییر رمز');
