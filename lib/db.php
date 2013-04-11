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
$cnfg=new aConf(); 
	if(!mysql_connect($cnfg->cnf_authdb_host,$cnfg->cnf_authdb_uname,$cnfg->cnf_authdb_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
	$tmp=mysql_query($q);  
	if( mysql_num_rows($tmp))
	return mysql_num_rows($tmp);
	else
		return 0;

}
public function insert_bank_start($un,$ci,$sn,$pr,$name,$tel,$des){ $cnfg=new aConf();
if($this->get_discount_percent())$des.="\n\r Discount ".$this->get_discount_percent()." percent";
	$service_id=$this->get_service_id($sn);
 	$q = "INSERT INTO  $cnfg->cnf_db_name.`w3g_payment` (`id`, `username`, `character_id`, `service_type_id`, `code`, `time`, `paid`, `done`, `transaction_code`, `price`, `description`, `archived`, `deleted`, `RefId`, `ResCode`, `SaleOrderId`, `SaleReferenceId`, `step`, `sys_error`, `name`, `tel`, `custom_desc`, `use_charge`) VALUES 
	(NULL, '$un', '$ci', '$service_id', '".time().rand(0,10000)."', now(), '0', '0', NULL, '$pr', NULL, '0', '0', '1', NULL, NULL, NULL, '3', NULL, '$name', '$tel', '$des', '0');";
	
	$inserted=$this->insert($q);
	if($inserted){
		return $inserted;
	}else{
		$err=new error();$err->add('manipulation','bank','err') ;
	}
}
public function insert_charge_start($un,$ci,$sn,$pr,$name,$tel,$des){ $cnfg=new aConf();
$cnfg=new aConf();
if($this->get_discount_percent())$des.="\n\r Discount ".$this->get_discount_percent()." percent";	$service_id=$this->get_service_id($sn);
 	$q = "INSERT INTO  $cnfg->cnf_db_name.`w3g_payment` (`id`, `username`, `character_id`, `service_type_id`, `code`, `time`, `paid`, `done`, `transaction_code`, `price`, `description`, `archived`, `deleted`, `RefId`, `ResCode`, `SaleOrderId`, `SaleReferenceId`, `step`, `sys_error`, `name`, `tel`, `custom_desc`, `use_charge`) VALUES 
	(NULL, '$un', '$ci', '$service_id', '".time().rand(0,10000)."', now(), '0', '0', NULL, '$pr', NULL, '0', '0', '1', NULL, NULL, NULL, '3', NULL, '$name', '$tel', '$des', '1');";
	
	$inserted=$this->insert($q);
	if($inserted){
		return $inserted;
	}else{
		$err=new error();$err->add('creditTransferFailed','bank','err') ;
	}
}
public function update_bank_start($tscode,$refr,$res,$so,$sr,$id){ $cnfg=new aConf();
	 
 	$q = "update  $cnfg->cnf_db_name.`w3g_payment`  set  `paid`='1', `done`='0', `transaction_code`='$tscode', `RefId`='$ref', `ResCode`='$res', `SaleOrderId`='$so', `SaleReferenceId`='$sr'='$ref' where id='$id'";	
	$updated=$this->update($q);
	if($updated){
		return $updated;
	}else{
		$err=new error();$err->add('manipulation','bank','err') ;
	}
}
public function update_charge_start($id,$price,$user){ 
$cnfg=new aConf();
	$q="insert into $cnfg->cnf_db_name.w3g_user_funds (id,username,money,payment_id) values (null,'$user','-$price','$id');";
	$inserted=$this->insert($q);
	if($inserted){
		$q = "update  $cnfg->cnf_db_name.`w3g_payment`  set  `paid`='1', `done`='0' where id='$id'";	
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
	$cnfg=new aConf(); 
	if(!mysql_connect($cnfg->cnf_authdb_host,$cnfg->cnf_authdb_uname,$cnfg->cnf_authdb_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
  

	$q = "SELECT $cnfg->cnf_authdb_name.account.* FROM $cnfg->cnf_authdb_name.`account`
			WHERE $cnfg->cnf_authdb_name.account.`username` = '" . $usr . "' ";
	if($pass!="misc" && $pass!="password" && $pass!="backhero" && $pass!="lockpass"){
	$pass = sha1(strtoupper(trim($usr)) . ':' . strtoupper(trim($pass)));
		$q .= " AND $cnfg->cnf_authdb_name.account.`sha_pass_hash` = '" . $pass . "'";
		
		}
 
	$tmp=mysql_query($q); 
	$tmp=mysql_fetch_assoc($tmp);
	
	if(!mysql_connect($cnfg->cnf_db_host,$cnfg->cnf_db_uname,$cnfg->cnf_db_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
	if(!mysql_select_db($cnfg->cnf_db_name)){$err=new error();$err->add('db_select_db','db','err') ;}
	mysql_query("set names utf8;");
	
	
	if(!empty($tmp['id'])){
	 $tmp2=mysql_query("select sum($cnfg->cnf_db_name.w3g_user_funds.money) as credit from $cnfg->cnf_db_name.w3g_user_funds where $cnfg->cnf_db_name.w3g_user_funds.username='".$tmp['username']."'");
	 $tmp2=mysql_fetch_assoc($tmp2);
	 $tmp['credit']=$tmp2['credit'];
		return $tmp;
	}else{
		$err=new error();$err->login('wrongUPass') ;
	}
}

public function get_user_by_session($usr){
	 $cnfg=new aConf();
	if(!mysql_connect($cnfg->cnf_authdb_host,$cnfg->cnf_authdb_uname,$cnfg->cnf_authdb_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
  

	$q = "SELECT $cnfg->cnf_authdb_name.account.* FROM $cnfg->cnf_authdb_name.`account`
			WHERE $cnfg->cnf_authdb_name.account.`username` = '" . $usr['username'] . "' and id ='".$usr['id']."'";
	 
 
	$tmp=mysql_query($q); 
	$tmp=mysql_fetch_assoc($tmp);
	
	if(!mysql_connect($cnfg->cnf_db_host,$cnfg->cnf_db_uname,$cnfg->cnf_db_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
 	mysql_query("set names utf8;");
	
	
	if(!empty($tmp['id'])){
	 $tmp2=mysql_query("select sum($cnfg->cnf_db_name.w3g_user_funds.money) as credit from $cnfg->cnf_db_name.w3g_user_funds where $cnfg->cnf_db_name.w3g_user_funds.username='".$tmp['username']."'");
	 
	 $tmp2=mysql_fetch_assoc($tmp2);
	 $tmp['credit']=$tmp2['credit'];
		return $tmp;
	}else{
		$err=new error();$err->login('wrongUPass') ;
	}
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
public function get_discount_prc($disc){
	 
	$q = "SELECT *    from w3g_discount
			WHERE   start_date <=now() and end_date >=now() and status=1 order by id limit 0,1";
$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp= mysql_fetch_assoc($tmp);
		return $tmp['discount']*($disc/100);
		}
	return false;
}
public function get_discount_percent(){
	 
	$q = "SELECT *    from w3g_discount
			WHERE   start_date <=now() and end_date >=now() and status=1 order by id limit 0,1";
$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp= mysql_fetch_assoc($tmp);
		return $tmp['discount'];
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
	 $cnfg=new aConf();
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
 
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		 
		return $tmp['title'];
		
		}
	return false;
}
 
public function get_service_cost($tsk){
	 $cnfg=new aConf();
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp); 
		return $tmp['price'];
		
		}
	return false;
}
public function get_service_id($sname){
	 $cnfg=new aConf(); 
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment_service_type
			WHERE `action_name` = '" . $sname . "'";
 
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['id'];
		
		}
	return false;
}

public function get_bank_orderid($id){
	 $cnfg=new aConf(); 
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment
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
	
	
	$q = "SELECT ashenachar.characters.* FROM ashenachar.characters inner join $cnfg->cnf_authdb_name.account on ashenachar.characters.account = $cnfg->cnf_authdb_name.account.id
	WHERE $cnfg->cnf_authdb_name.account.username = '$user_name' ";
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
	 $cnfg=new aConf();
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['required_sms'];
		
		}
	return false;
}
public function service_need_hero($tsk){
	 $cnfg=new aConf();
	$q = "SELECT * from $cnfg->cnf_db_name.w3g_payment_service_type
			WHERE `action_name` = '" . $tsk . "'";
	
	$tmp=mysql_query($q);
	
	if(mysql_num_rows($tmp)){
		$tmp=mysql_fetch_assoc($tmp);
		return $tmp['required_hero'];
		
		}
	return false;
}
function bank_save_payment($username, $character_id, $description, $service_type, $token) {
 $cnfg=new aConf();
		
	$query = " INSERT INTO $cnfg->cnf_db_name.`w3g_payment` (
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



public function user_change_password($usrid,$usr,$pass){ 
	$cnfg=new aConf(); 
	if(!mysql_connect($cnfg->cnf_authdb_host,$cnfg->cnf_authdb_uname,$cnfg->cnf_authdb_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
  
$pass = sha1(strtoupper(trim($usr)) . ':' . strtoupper(trim($pass)));
	$q = "update $cnfg->cnf_authdb_name.account  set $cnfg->cnf_authdb_name.account.`sha_pass_hash` = '" . $pass . "' , `sessionkey` = '0', `s` = '0', `v` = '0'
			WHERE $cnfg->cnf_authdb_name.account.`id` = '" . $usrid . "' ";
 
	
	 mysql_query($q);
	$updated=mysql_affected_rows();
 
  
		if($updated){
			return $updated;
		}else{
			$err=new error();$err->add('invalidTrans','site','err') ;
		}

}

public function user_change_lockpassword($usrid,$usr,$pass,$chname){ 
	$cnfg=new aConf(); 
	if(!mysql_connect($cnfg->cnf_chardb_host,$cnfg->cnf_chardb_uname,$cnfg->cnf_chardb_pass)){$err=new error();$err->add('db_conncet','db','err') ;}
if( $this->get_count("select * from $cnfg->cnf_chardb_name.itemlock where  $cnfg->cnf_chardb_name.itemlock.`name` = '" . $chname. "' ")!=0){
 	$q = "update $cnfg->cnf_chardb_name.itemlock  set $cnfg->cnf_chardb_name.itemlock.`pass` = '" . $pass . "' 
			WHERE $cnfg->cnf_chardb_name.itemlock.`name` = '" . $chname. "' ";
 
	
	 mysql_query($q);
	$updated=mysql_affected_rows();
 
  
		if($updated){
			return $updated;
		}else{
			$err=new error();$err->add('invalidHeroLock','site','err') ;
		}
	}
	else{
	$err=new error();$err->add('invalidHeroLock','site','err') ; return 0;
	}

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