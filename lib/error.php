<?php

class error{
 
public $warn_list = "";
public $err_list = "";
public $note_list = "";

function add($msg,$pos="site",$type="warn",$done=0){
	switch($type){
		case 'err':
			$this->err_list[]=$this->get_err_msg($msg,'err');
		 
				require ("include/error_page.php");
				session_unset('user');
				session_unset('other');
				session_destroy();
			exit;
		case 'warn':
			$this->warn_list[]=$this->get_err_msg($msg,'warn');
	}

}
function login($msg){
	$this->err_list[]=$this->get_err_msg($msg,'err');
	require ("error_login.php");
	exit;
}
function get_bank_err($errid){

switch($errid){
case '11':{
	$msg= 'شماره كارت نامعتبر است';break;}

case '12':{
	$msg= 'موجودي كافي نيست';break;}

case '13':{
	$msg= 'رمز نادرست است';break;}

case '14':{
	$msg= 'تعداد دفعات وارد كردن رمز بيش از حد مجاز است';break;}

case '15':{
	$msg= 'كارت نامعتبر است';break;}

case '17':{
	$msg= 'كاربر از انجام تراكنش منصرف شده است';break;}

case '18':{
	$msg= 'تاريخ انقضاي كارت گذشته است';break;}

case '111':{
	$msg= 'صادر كننده كارت نامعتبر است';break;}

case '112':{
	$msg= 'خطاي سوييچ صادر كننده كارت';break;}
case '113':{
	$msg= 'پاسخي از صادر كننده كارت دريافت نشد';break;}
case '114':{
	$msg= 'دارنده كارت مجاز به انجام اين تراكنش نيست';break;}
case '21':{
	$msg= 'پذيرنده نامعتبر است';break;}
case '22':{
	$msg= 'ترمينال مجوز ارايه سرويس درخواستي را ندارد.';break;}
case '23':{
	$msg= 'خطاي امنيتي رخ داده است';break;}
case '24':{
	$msg= 'اطلاعات كاربري پذيرنده نامعتبر است';break;}
case '25':{
	$msg= 'مبلغ نامعتبر است';break;}
case '31':{
	$msg= 'پاسخ نامعتبر است';break;}
case '32':{
	$msg= 'فرمت اطلاعات وارد شده صحيح نمي باشد';break;}
case '33':{
	$msg= 'حساب نامعتبر است';break;}
case '34':{
	$msg= 'خطاي سيستمي';break;}
case '35':{
	$msg= 'تاريخ نامعتبر است';break;}
case '41':{
	$msg= 'شماره درخواست تكراري است';break;}
default:{
	$msg= 'خطای بانکی';break;} 
 }
 
$this->err_list[]= ' پیام شماره '.$errid.' - '.$msg;
return ' پیام شماره '.$errid.' - '.$msg;
}
function get_err_msg($msg,$type='warn'){
	$mydbtmp=new db();
	$tmp=$mydbtmp->get_message($msg);
	$type=$type.'_list';
	$this->{$type}[]=' پیام شماره '.$tmp['id'].' - '.$tmp['value'];
}


}
$err=new error();
?>