<?php
$warn=0;

 
if(strlen($_POST['new_pass'])<6){
	$err->add('invalidDataPass','site','warn') ;$warn++;
}
if(strlen($_POST['username'])<3){
	$err->add('invalidDataUsername','site','warn') ;$warn++;
} 
 
if($warn!=0){
$_REQUEST['step']=$_SESSION['other']['step'];
}
 if($warn==0){
 
$var['service_name']=$_SESSION['other']['maintask'];
$var['username']=$_POST['username'];
$var['new_pass']=$_POST['new_pass'];
$var['price']=0;
$var['user_id']=$_SESSION['user']['id'];
$_SESSION['other']['vars_before_bank']=json_encode($var);	
}
?>
