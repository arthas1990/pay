<?php

?>
<div class="tbl">
<form method="post" action="index.php?task=<?=$Logged_User['maintask'];?>">
<table width="800px" align="center">
	<tr>
		<td  > نـــام اکانت </td>
		<td><input id="w3g_el_username" name="username" class="note" readonly="" value="<?=$Logged_User['username'];?>" type="text">
        <label></label></td>
	</tr> 

							                            
						 

							<tr   style="">
								<td > رمز جدید </td>
								<td>
								<input placeholder="" name="new_pass"   type="password">
								<label></label></td>
							</tr>
 

							<tr   style="">
								<td > هزینه سرویس </td>
								<td>
								رایگان</td>
							</tr>
 
							 
							<tr>
								<td >
								 <input  name="step"   type="hidden" value="<?php if($Logged_User['service_need_sms'])echo "sms"; else echo "process";?>">
								 
								 <input  name="verify"   type="hidden" value="password">
								 
								</td>
								<td   >
								<input value="مـــرحله بعـد" type="submit" class="btn">
								</td>
							</tr>
						
							

</table>
</form>
</div>