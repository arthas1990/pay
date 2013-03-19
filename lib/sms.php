<?php
 
class sms{
private $sms_url = "";
private $sms_number = "";
private $sms_username = "";
private $sms_password = "";
private $sms_confrimMessage = "";
private $sms_confrimSignature = "";
public $sms_total_resend = "";
 
function send($to,$msg){
 

	$client = new nusoap_client($this->sms_url, 'wsdl');
	$client->decodeUTF8(false);
	$myMess = $this->sms_confrimMessage." \n".$msg." \n".$this->sms_confrimSignature;
	$res = $client->call('send', array(
	'username'	=> $this->sms_username, 
	'password'	=> $this->sms_password, 
	'to'		=> $to, 
	'from'		=> $this->sms_number, 
	'message'	=> $myMess
	));
	if (is_array($res) && isset($res['status']) && $res['status'] === 0) {
		echo '<div class ="note">پیام شماره '.$res['identifier'].' ارسال شد.</div><br>';
		 
	} elseif (is_array($res)) {
		$err=new error();$err->add('soapError','sms','err') ;
	} else {
		echo $client->getError();
	}
	
	
	
} 
function __construct(){
	$cnfg=new aConf();
	$this->sms_url = $cnfg->cnf_sms_url;
	$this->sms_number = $cnfg->cnf_sms_number;
	$this->sms_username =$cnfg->cnf_sms_username;
	$this->sms_password = $cnfg->cnf_sms_password;
	$this->sms_confrimMessage = $cnfg->cnf_sms_confrimMessage;
	$this->sms_confrimSignature= $cnfg->cnf_sms_confrimSignature;
	$this->sms_total_resend= $cnfg->cnf_sms_total_resend;
}
}
 $sms= new sms();
 // $sms->send('09379678117','تغییر رمز');
