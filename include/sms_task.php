<?php
if(isset($_REQUEST['type'])){
if($_SESSION['other']['sms_wrong']==0 && $_SESSION['other']['sms_sended']==0)
	if($_REQUEST['type']=='sms'){
		$sms->send($Logged_User['tell'],$Logged_User['service_name']."\n".$Logged_User['securitycode']);
	}else{
		$mail->send_sec_code($Logged_User['email'],$Logged_User['service_name']."\n".$Logged_User['securitycode']);}
 
?>
<div class="tbl">
<form method="post" action="index.php?task=<?php echo $Logged_User['maintask'];?>">
 
<table width="800px" align="center">
	<tr>
		<td style="direction:rtl" >
		<?php if($_REQUEST['type']=='sms'){?>
			رمز ارسال شده به موبایلتان با شماره  
			 <?=substr($Logged_User['tell'],-2).'*****'.substr($Logged_User['tell'],0,4) ;?>
			 را وارد کنید : 
		 <?php }else {?>
			 رمز ارسال شده به ایمیل 
			 <?php
			 $tmp=explode('@',$Logged_User['email']);
			 if($tmp[0]<5)	$tmp[0]=substr($tmp[0],0,3);else $tmp[0]=substr($tmp[0],0,2);
			 echo $tmp[0] . '...@' . $tmp[1] ;?>
			 را وارد کنید : 
		 <?php } ?>
		 </td>
		<td><input id="w3g_el_username" name="request_sms"  type="text">
        <label></label></td>
	</tr>
							<tr>
								<td >
								 <input  name="step"   type="hidden" value="process">
								 <input  name="verify"   type="hidden" value="sms">
								</td>
								<td   >
								<input value="انجـــام عملیات" type="submit" class="btn">
								</td>
							</tr>
						
							

</table>
</form>
</div>
<?php } 
else{?>
<div class="tbl">
<form action="index.php" method="post">
<input type="radio" name="type" value="sms" checked> ارسال کد امنیتی به موبایل<br>
<input type="radio" name="type" value="mail" >  ارسال کد امنیتی به ایمیل<br>
 <input  name="step"   type="hidden" value="sms">
 <input value="ارســال کـــد امنیتی" type="submit" class="btn">
</form>
</div>
<?php } ?>