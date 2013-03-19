<?php

?>
<div class="tbl">
<form method="post">
<table width="800px" align="center">
	<tr>
		<td  > نـــام اکانت </td>
		<td><input id="w3g_el_username" name="username" class="note" readonly="" value="<?=$Logged_User['username'];?>" type="text">
        <label></label></td>
	</tr><?php if($Logged_User['service_need_hero']):?>
	<tr id="w3gj_herosWarpper">
								<td > نام هیــــرو </td>
								<td>
								<select name="character_id"   style="width: 350px;" rev="1">
									<option value="-1"> لطفا  هیرو خود را انتخاب نمایید </option>
									<?php foreach($Logged_User['heros'] as $row):?>
                               <option value="<?=$row['guid'];?>"><?=$row['name'];?></option>
                                <?php endforeach;?>
    </td>
	</tr><?php  endif;?>

							                            
						 

							<tr   style="">
								<td > نام و نام خانوادگی </td>
								<td>
								<input placeholder="" name="name"   type="text">
								<label></label></td>
							</tr>

							<tr   style="">
								<td  style="padding-top: 74px !important;"> شماره تلفن </td>
								<td>
								<div style="width: 350px;">
									<div class="warn">
										این شماره تلفن جهت پیگیری مشکلات احتمالی می باشد.
									</div>
								</div>
								<input placeholder="" name="tel"  type="text">
								<label></label></td>
							</tr>

							<tr   style="">
								<td > مبلغ موردنظر </td>
								<td>
								<input placeholder="" name="price" id="price"  onchange="chk(this.value)";  type="text">
								ریــال <label></label></td>
							</tr>

							<tr   style="">
								<td  style="padding-top: 100px ! important;"> توضیـــحات </td>
								<td>
								<div style="width: 350px;">
									<div  class="warn">
										توجه! تکمیل توضیحات پرداخت جهت انجام درخواست شما ضروری می باشد. لطفا این بخش را بطور صریح و دقیق تکمیل نمایید									</div>
								</div>								
                                <textarea name="description"  style="width: 350px; height: 110px;"></textarea><label></label></td>
							</tr>
							<tr   style="">
								<td > روش پرداخت </td>
								<td> <script>
								function chk(vr){
								if(vr<=<?php echo $Logged_User['credit'];?>){
									$('#pay_type').html('<option value="bank">پرداخت از طریق درگاه بانکی</option>	<option value="charge">کسر از شارژ فعلی اکانت</option>'); 
								}else{
									$('#pay_type').html('<option value="bank">پرداخت از طریق درگاه بانکی</option>'); 
								}
								}</script>
								<select name="pay_type" id="pay_type">
								
								<option value="bank">پرداخت از طریق درگاه بانکی</option>
								<option value="charge">کسر از شارژ فعلی اکانت</option>
							
								</select>
								
								</td>
							</tr>
							<tr>
								<td >
								 <input  name="step"   type="hidden" value="<?php if($Logged_User['service_need_sms'])echo "sms"; else echo "process";?>">
								 
								 <input  name="verify"   type="hidden" value="misc">
								 
								</td>
								<td   >
								<input value="مـــرحله بعـد" type="submit" class="btn">
								</td>
							</tr>
						
							

</table>
</form>
</div>