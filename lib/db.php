<?php
class db{
private $host = "";
private $dbname = "";
private $user = "";
private $pass = "";
public function insert($q){
	if(mysql_query($q))
		return mysql_insert_id();
	return false;
}
public function update($q){
	if(mysql_query($q))
		return mysql_affected_rows();
	return false;
}
public function delete($q){
	if(mysql_query($q))
		return mysql_affected_rows();
	return false;
}
public function select($q){
	$tmp=mysql_query($q);
	$vars='';
	if(($tmp)){
	while($row=mysql_fetch_array($tmp) )
		$vars[]=$row;
	return $vars;
	}
	return false;
}
public function get_count($q){
	$tmp=mysql_query($q);
	return mysql_num_rows($tmp);
}
public function insert_bank_start($un,$ci,$sn,$pr,$name,$tel,$des){ 
	$service_id=$this->get_service_id("$sn");
 	$q = "INSERT INTO  `w3g_payment` (`id`, `username`, `character_id`, `service_type_id`, `code`, `time`, `paid`, `done`, `transaction_code`, `price`, `description`, `archived`, `deleted`, `RefId`, `ResCode`, `SaleOrderId`, `SaleReferenceId`, `step`, `sys_error`, `name`, `tel`, `custom_desc`, `use_charge`) VALUES 
	(NULL, '$un', '$ci', '$service_id', '".time().rand(0,10000)."', now(), '1', '0', NULL, '$pr', NULL, '0', '0', '1', NULL, NULL, NULL, '0', NULL, '$name', '$tel', '$des', '0');";
	
	$inserted=$this->insert($q);
	if($inserted){
		return $inserted;
	}else{
		$err=new error();$err->add('manipulation','bank','err') ;
	}
}
public function insert_charge_start($un,$ci,$sn,$pr,$name,$tel,$des){ 
	$service_id=$this->get_service_id("$sn");
 	$q = "INSERT INTO  `w3g_payment` (`id`, `username`, `character_id`, `service_type_id`, `code`, `time`, `paid`, `done`, `transaction_code`, `price`, `description`, `archived`, `deleted`, `RefId`, `ResCode`, `SaleOrderId`, `SaleReferenceId`, `step`, `sys_error`, `name`, `tel`, `custom_desc`, `use_charge`) VALUES 
	(NULL, '$un', '$ci', '$service_id', '".time().rand(0,10000)."', now(), '1', '0', NULL, '$pr', NULL, '0', '0', '1', NULL, NULL, NULL, '0', NULL, '$name', '$tel', '$des', '1');";
	
	$inserted=$this->insert($q);
	if($inserted){
		return $inserted;
	}else{
		$err=new error();$err->add('creditTransferFailed','bank','err') ;
	}
}
public function update_bank_start($tscode,$refr,$res,$so,$sr,$id){ 
	 
 	$q = "update  `w3g_payment`  set  `paid`='1', `done`='1', `transaction_code`='$tscode', `RefId`='$ref', `ResCode`='$res', `SaleOrderId`='$so', `SaleReferenceId`='$sr'='$ref' where id='$id'";	
	$updated=$this->update($q);
	if($updated){
		return $updated;
	}else{
		$err=new error();$err->add('manipulation','bank','err') ;
	}
}
public function update_charge_start($id,$price,$user){ 
	$q="insert into w3g_user_funds (id,username,money,payment_id) values (null,'$user','-$price','$id');";
	$inserted=$this->insert($q);
	if($inserted){
		$q = "update  `w3g_payment`  set  `paid`='1', `done`='1' where id='$id'";	
		$updated=$this->update($q);
		if($updated){
			return $updated;
		}else{
			$err=new error();$err->add('creditTransferFailed','bank','err') ;
		}
	}
	else{
		$err=new error();$err->add('creditTransferFailed','bank','err') ;
	}
}
public function get_user($usr,$pass){ 
	$sec =$pass = sha1(strtoupper(trim($usr)) . ':' . strtoupper(trim($pass)));
	$q = "SELECT accounts.*,sum(w3g_user_funds.money) as credit FROM `accounts` inner join w3g_user_funds on w3g_user_funds.username=accounts.username
			WHERE accounts.`username` = '" . $usr . "'  AND accounts.`sha_pass_hash` = '" . $pass . "'";
	
	$tmp=mysql_query($q); 
	$tmp=mysql_fetch_assoc($tmp);
	if(!empty($tmp['id'])){
		return $tmp;
	}else{
		$err=new error();$err->login('wrongUPass') ;
	}
}

public function get_user_by_session($usr){
	 if(!empty($usr['id'])){
	$q = "SELECT accounts.*,sum(w3g_user_funds.money) as credit FROM `accounts` inner join w3g_user_funds on w3g_user_funds.username=accounts.username
			WHERE accounts.`username` = '" . $usr['username'] . "' AND accounts.`id` = '" .  $usr['id']  . "'";
	
	$tmp=mysql_query($q);
	$tmp=mysql_fetch_assoc($tmp);
	if(!empty($tmp['id'])){
		return $tmp;
	}else{
		$err=new error();$err->login('wrongUPass') ;
	}
	}
	$err=new error();$err->login('emptyUPass') ;
}
public function get_message_title($msg){
	 
	$q = "SELECT * from w3g_messages
			WHERE `key` = '" . $msg . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp= mysql_fetch_assoc($tmp);
		return $tmp['title'];
		}
	return false;
}
public function get_message($msg){
	 
	$q = "SELECT * from w3g_messages
			WHERE `key` = '" . $msg . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp))
		return mysql_fetch_assoc($tmp);
	return false;
}
public function get_service_name($tsk){
	 
	$q = "SELECT * from w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
 
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		 
		return $tmp['title'];
		
		}
	return false;
}
 
public function get_service_cost($tsk){
	 
	$q = "SELECT * from w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['price'];
		
		}
	return false;
}
public function get_service_id($sname){
	 
	$q = "SELECT * from w3g_payment_service_type
			WHERE `action_name` = '" . $sname . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['id'];
		
		}
	return false;
}

public function get_bank_orderid($id){
	 
	$q = "SELECT * from w3g_payment
			WHERE `id` = '" . $id . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['code'];
		
		}
	return false;
}

public function get_hero_list($user_name){

	$cnfg=new aConf();
	$this->host = $cnfg->cnf_chardb_host;
	$this->dbname =$cnfg->cnf_chardb_name;
	$this->user = $cnfg->cnf_chardb_uname;
	$this->pass =$cnfg->cnf_chardb_pass;
	 
	if(!mysql_connect($this->host,$this->user,$this->pass)){$err=new error();$err->add('db_conncet','db','err') ;}
 	mysql_query("set names utf8;");
	
	
	$q = "SELECT ashenachar.characters.* FROM ashenachar.characters inner join ashenaauth.account on ashenachar.characters.account = ashenaauth.account.id
	WHERE ashenaauth.account.username = '$user_name' ";
 $tmp=mysql_query($q);
 
 
	$cnfg=new aConf();
	$this->host = $cnfg->cnf_db_host;
	$this->dbname =$cnfg->cnf_db_name;
	$this->user = $cnfg->cnf_db_uname;
	$this->pass =$cnfg->cnf_db_pass;
	 
	if(!mysql_connect($this->host,$this->user,$this->pass)){$err=new error();$err->add('db_conncet','db','err') ;}
	if(!mysql_select_db($this->dbname)){$err=new error();$err->add('db_select_db','db','err') ;}
	mysql_query("set names utf8;");
	
	
	$vars='';
	if(($tmp)){
	while($row=mysql_fetch_array($tmp) )
		$vars[]=$row;
	return $vars;
	}
	return false;
}
public function service_need_sms($tsk){
	 
	$q = "SELECT * from w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['required_sms'];
		
		}
	return false;
}
public function service_need_hero($tsk){
	 
	$q = "SELECT * from w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['required_hero'];
		
		}
	return false;
}
function bank_save_payment($username, $character_id, $description, $service_type, $token) {
 
		
	$query = " INSERT INTO `w3g_payment` (
`id` ,
`username` ,
`character_id` ,
`service_type_id` ,
`code` ,
`time` ,
`price` ,
`description`,
`name` ,
`tel`
)
VALUES (
NULL , '$username', '$character_id', '$service_type_id', '$token', '$currentTime', '$price', '$description','$name', '$tel'
);";
 
	return $this->insert($query);
}
function bank_step1($token, $order_id, $RefId, $ResCode) {
 	$query = " UPDATE `w3g_payment` SET `SaleOrderId` = $order_id, `RefId` = '" . $RefId . "', `step` = 1, `ResCode` = '$ResCode' WHERE `code` = '" . $token . "'";
	return $this->update($query);
}
function bank_step2($RefId, $ResCode, $SaleReferenceId) {
	$query = " UPDATE `w3g_payment` SET `step` = 2, `ResCode` = '$ResCode', `SaleReferenceId` = '$SaleReferenceId' WHERE `RefId` = '" . $RefId . "'";
	return $this->update($query);
}
function bank_step3($RefId, $ResCode, $use_charge = 0) {
	$query = " UPDATE `w3g_payment` SET `step` = 3, `ResCode` = '$ResCode', `paid` = 1 , `use_charge` = $use_charge WHERE `RefId` = '" . $RefId . "'";
	return $this->update($query);
}
function bank_done($RefId) {
$query = " UPDATE `w3g_payment` SET `done` = 1 WHERE `RefId` = '" . $RefId . "'";
	return $this->update($query);
}
function __construct(){
	$cnfg=new aConf();
	$this->host = $cnfg->cnf_db_host;
	$this->dbname =$cnfg->cnf_db_name;
	$this->user = $cnfg->cnf_db_uname;
	$this->pass =$cnfg->cnf_db_pass;
	 
	if(!mysql_connect($this->host,$this->user,$this->pass)){$err=new error();$err->add('db_conncet','db','err') ;}
	if(!mysql_select_db($this->dbname)){$err=new error();$err->add('db_select_db','db','err') ;}
	mysql_query("set names utf8;");
	
}


}
$mydb=new db();
?>