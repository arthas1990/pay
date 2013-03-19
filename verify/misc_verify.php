<?php
$warn=0;

if(strlen($_POST['description'])<3){
	$err->add('invalidData','site','warn') ;$warn++;
}
if(strlen($_POST['price'])<3){
	$err->add('invalidData','site','warn') ;$warn++;
}
if(strlen($_POST['tel'])<7){
	$err->add('invalidData','site','warn') ;$warn++;
}
if(strlen($_POST['name'])<6){
	$err->add('invalidData','site','warn') ;$warn++;
}
if(strlen($_POST['username'])<3){
	$err->add('invalidData','site','warn') ;$warn++;
}
if(isset($_POST['character_id']) && $_POST['character_id']=='-1'){
	 $err->add('invalidData','site','warn') ;$warn++;
}
 
if($warn!=0){
$_REQUEST['step']=$_SESSION['other']['step'];
}
 if($warn==0){
if($_REQUEST['pay_type']=='bank'){
	$_SESSION['other']['service_need_sms']=false;
	$_SESSION['other']['sms_confirmed']=1;
	$_SESSION['other']['step']='process';
	$_REQUEST['step']='process';
	}
$var['description']=$_POST['description'];
$var['price']=$_POST['price'];
$var['name']=$_POST['name'];
$var['service_name']=$_SESSION['other']['service_name'];
$var['username']=$_POST['username'];
$var['tel']=$_POST['tel'];
$var['character_id']=$_POST['character_id'];
$var['pay_type']=$_POST['pay_type'];
$var['user_id']=$_SESSION['user']['id'];
$_SESSION['other']['vars_before_bank']=json_encode($var);	
}
?>
