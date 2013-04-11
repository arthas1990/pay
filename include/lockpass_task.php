<?php  $cnfg=new aConf();  $mydb=new db(); 
/*$cnt=$mydb->get_count("select * from $cnfg->cnf_chardb_name.characters inner join $cnfg->cnf_authdb_name.account on $cnfg->cnf_chardb_name.characters.account= $cnfg->cnf_authdb_name.account.id
 inner join $cnfg->cnf_chardb_name.itemlock on 
$cnfg->cnf_chardb_name.itemlock.name=$cnfg->cnf_chardb_name.characters.name
 where  $cnfg->cnf_authdb_name.account.`id` = '" . $Logged_User['id']. "' ");*/
 
// if( $cnt!=0){
if( 1){
?>  
<div class="tbl">
<form method="post" action="index.php?task=<?=$Logged_User['maintask'];?>">
<table width="800px" align="center">
	<tr>
		<td  > نـــام اکانت </td>
		<td><input id="w3g_el_username" name="username" class="note" readonly="" value="<?=$Logged_User['username'];?>" type="text">
        <label></label></td>
	</tr> 
                            
						 	<tr id="w3gj_herosWarpper">
								<td > نام هیــــرو </td> 
								<td>
								<select name="chname"   style="width: 350px;" rev="1">
									<option value="-1"> لطفا  هیرو خود را انتخاب نمایید </option>
									<?php foreach($Logged_User['heros'] as $row):?>
                               <option value="<?=$row['name'];?>"><?=$row['name'];?></option>
                                <?php endforeach;?></select>
    </td>

							<tr   style="">
								<td > رمز جدید </td>
								<td>
								<div class="warn">حداقل 3 کاراکتر</div>
								<input placeholder="" name="newlock"   type="password">
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
								 
								 <input  name="verify"   type="hidden" value="lockpass">
								 
								</td>
								<td   >
								<input value="مـــرحله بعـد" type="submit" class="btn">
								</td>
							</tr>
						
							

</table>
</form>
</div><?php
}else{
echo('<div class="err">
هیرو شما Item Lock نمی باشد.
</div>');
session_unset('user');
session_unset('other');
session_destroy();exit;}?>