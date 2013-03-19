<?php
if($_SESSION['other']['sms_wrong']==0 && $_SESSION['other']['sms_sended']==0)
	$sms->send($Logged_User['tell'],$Logged_User['service_name']."\n".$Logged_User['securitycode']);
 
?>
<div class="tbl">
<form method="post">
 
<table width="800px" align="center">
	<tr>
		<td style="direction:rtl" >رمز ارسال شده به موبایلتان با دو شماره آخر 
		 <?=substr($Logged_User['tell'],-2) ;?>
		 را وارد کنید : </td>
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