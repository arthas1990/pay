<?php
session_start();
// ini_set('display_errors','off');
require('lib/nusoap/nusoap.php'); 
require ("conf/conf.php");
$config=new aConf();
require ("lib/db.php");
require ("lib/error.php");
require ("lib/sms.php");
require ("lib/mail.php");

 
if(isset($_POST['user']) && isset($_POST['pass'])){
	$user=mysql_escape_string($_POST['user']);
	$pass=mysql_escape_string($_POST['pass']);
	
	$_SESSION['user']=$mydb->get_user($user,$pass); 
}else{
	if(isset($_SESSION['user']))
		$_SESSION['user']=$mydb->get_user_by_session($_SESSION['user']);
	else
		$err->login('emptyUPass') ;
}
$task='misc';
if(isset($_REQUEST['task']) ){ 
$task=$_REQUEST['task'];
}



if(isset($_REQUEST['verify']))
	if(file_exists("verify/".$_REQUEST['verify']."_verify.php"))
		require "verify/".$_REQUEST['verify']."_verify.php";



if(isset($_REQUEST['step']) && !empty($_REQUEST['step']) )	 
		$_SESSION['other']['step']=$_REQUEST['step'];
	else
		 if(!isset($_SESSION['other']['step'])){
			$_SESSION['other']['step']=$task;}
	
 


 
	switch($task){
	case 'misc':{
	$_SESSION['other']['maintask']=$task;
	 
	if(isset($_POST['price']))$service_cost=$_POST['price'];
	break;}
	
	
	
	
	}
$pay_type='bank';	
if(isset($_SESSION['other']['pay_type']))$pay_type=$_SESSION['other']['pay_type'];
if(isset($_POST['pay_type']))$pay_type=$_POST['pay_type'];
 
if($_SESSION['other']['step']=='process' && $_SESSION['other']['service_need_sms'] && (!isset($_SESSION['other']['sms_confirmed']) || $_SESSION['other']['sms_confirmed']=='0'))
	$err->login('wrongSecurityCode') ;
 
 
 
 
$service_cost=$mydb->get_service_cost($_SESSION['other']['maintask']);
if(!isset($_SESSION['other']['sms_wrong']))$_SESSION['other']['sms_wrong']=0;
$_SESSION['other']['pay_type']=$pay_type;
$_SESSION['other']['service_cost']=$service_cost;
$_SESSION['other']['service_name']=$mydb->get_service_name($_SESSION['other']['maintask']);
if(!isset($_SESSION['other']['service_need_sms']))
	$_SESSION['other']['service_need_sms']=$mydb->service_need_sms($_SESSION['other']['maintask']);
$_SESSION['other']['service_need_hero']=$mydb->service_need_hero($_SESSION['other']['maintask']);
if(empty($_SESSION['other']['securitycode']) || !isset($_SESSION['other']['securitycode']))
	$_SESSION['other']['securitycode']=substr(md5(microtime()),rand(0,26),5);;
$_SESSION['user']['pay_type']=$_SESSION['other']['pay_type'];
$_SESSION['user']['service_cost']=$_SESSION['other']['service_cost'];
$_SESSION['user']['service_name']=$_SESSION['other']['service_name'];
$_SESSION['user']['securitycode']=$_SESSION['other']['securitycode'];
$_SESSION['user']['maintask']=$_SESSION['other']['maintask'];
$_SESSION['user']['service_need_sms']=$_SESSION['other']['service_need_sms'];
$_SESSION['user']['service_need_hero']=$_SESSION['other']['service_need_hero'];
$_SESSION['user']['step']=$_SESSION['other']['step'];
$_SESSION['user']['heros']=$mydb->get_hero_list($_SESSION['user']['username']);





$Logged_User=$_SESSION['user'];
 
 

?>