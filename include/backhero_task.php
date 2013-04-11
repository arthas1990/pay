<?php

?>
<div class="tbl">
<form method="post">
<table width="800px" align="center">
	<tr>
		<td  > نـــام اکانت </td>
		<td><input id="w3g_el_username" name="username" class="note" readonly="" value="<?=$Logged_User['username'];?>" type="text">
        <label></label></td>
	</tr>
	<tr   style="">
								<td >نام هیرو </td>
								<td>
								<input placeholder="" name="heroname"   type="text">
								<label></label></td>
							</tr>
	<tr   style="">
								<td style="vertical-align:bottom;">تاریخ بک دادن </td>
								<td>
								<div style="width: 350px;">
									<div class="warn">
										توجه : هیرو شما به تاریخ بک دادن برگشت میکند ، اگر بعد از این تاریخ آیتمی گرفته باشید بدیهی است آن آیتم را نخواهید داشت.
									</div>
								</div>
								
								<input placeholder="" name="backdate"  id="backdate"   type="text" readonly="readonly">
								
  
 
 
 
          <script type="text/javascript">
              
					 Calendar.setup({
                        inputField     :    "backdate",   // id of the input field
                        button         :    "backdate",   // trigger for the calendar (button ID)
                        ifFormat       :    "%Y-%m-%d",       // format of the input field
                        dateType       :    'jalali',
                        weekNumbers    : false
                    }); 
					
           </script>
								
								<label></label></td>
							</tr>
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
								<td > هزینه</td>
								<td>
								<?=number_format($Logged_User['service_cost']);?>
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
								<td> 
								<select name="pay_type" id="pay_type">
								
								<option value="bank">پرداخت از طریق درگاه بانکی</option>
								<?php if(intval($Logged_User['service_cost'])<=intval($Logged_User['credit'])){?>
								<option value="charge">کسر از شارژ فعلی اکانت</option>
							<?php }?>
								</select>
								
								</td>
							</tr>
							<tr>
								<td >
								 <input  name="step"   type="hidden" value="<?php if($Logged_User['service_need_sms'])echo "sms"; else echo "process";?>">
								 
								 <input  name="verify"   type="hidden" value="backhero">
								 
								</td>
								<td >
								<input value="مـــرحله بعـد" type="submit" class="btn">
								</td>
							</tr>
						
							

</table>
</form>
</div>