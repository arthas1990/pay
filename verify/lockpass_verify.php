<?php
$warn=0;
 $cnfg=new aConf();  $mydb=new db(); 
if(!$mydb->get_count("select * from $cnfg->cnf_chardb_name.itemlock where  $cnfg->cnf_chardb_name.itemlock.`name` = '" . $_POST['chname']. "' ")){
$err=new error();$err->add('invalidHeroLock','site','err') ;
}

 
if(strlen($_POST['newlock'])<3){
	$err->add('invalidPassLock','site','warn') ;$warn++;
} 
if($warn!=0){
$_REQUEST['step']=$_SESSION['other']['step'];
}
 if($warn==0){

$var['service_name']=$_SESSION['other']['maintask'];
$var['username']=$_POST['username'];
$var['newlock']=$_POST['newlock'];
$var['chname']=$_POST['chname'];
$var['price']=0;
$var['user_id']=$_SESSION['user']['id'];
$_SESSION['other']['vars_before_bank']=json_encode($var);	
}
?>
