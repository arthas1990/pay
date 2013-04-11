<?php 
$bank_vars=json_decode($_SESSION['other']['vars_before_bank']);

if($bank_vars->price>0){
if($_SESSION['other']['pay_type']=='bank'){
 $resultStr=$_POST['ResCode'];
if($_POST['ResCode']=='0'){


$namespace = 'http://interfaces.core.sw.bps.com/';

 $soapclient = new nusoap_client('https://pgws.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl', 'wsdl');

	///////////////// PAY REQUEST
	 
		$terminalId = $config->cnf_bank_terminal_id;
		$userName = $config->cnf_bank_username;
		$userPassword = $config->cnf_bank_password;
		$bId =$mydb->insert_bank_start($bank_vars->username,$bank_vars->character_id ,$bank_vars->service_name ,$bank_vars->price ,$bank_vars->name ,$bank_vars->tel ,$bank_vars->description );
		$_SESSION['other']['bID']=$bId ;
		$orderId =$mydb->get_bank_orderid($bId);
		$amount = intval($bank_vars->price );
		$localDate =  date("Ymd"); 
		$localTime =  date("His");
		$additionalData = '';
		$callBackUrl = $config->cnf_bank_callback_url;
		$payerId = 0;

		// Check for an error
		$errbank = $soapclient->getError();
		if ($errbank) {
			echo '<h2>Constructor error</h2><pre>' . $errbank . '</pre>';
			die();
		}
	  
		$parameters = array(
			'terminalId' => $terminalId,
			'userName' => $userName,
			'userPassword' => $userPassword,
			'orderId' => $orderId,
			'saleOrderId' => $_POST['SaleOrderId'],
			'saleReferenceId' => $_POST['SaleReferenceId']);

 
		
		$result = $soapclient -> call('bpVerifyRequest', $parameters, $namespace);

		// Check for a fault
		if ($soapclient->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
			die();
		}else{
		

			$resultStr = $result;
			
			$errbank = $soapclient->getError();
			if ($errbank) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $errbank . '</pre>';
				die();
			} 
			else {
				$parameters = array(
			'terminalId' => $terminalId,
			'userName' => $userName,
			'userPassword' => $userPassword,
			'orderId' => $orderId,
			'saleOrderId' => $_POST['SaleOrderId'],
			'saleReferenceId' => $_POST['SaleReferenceId']);

 
		
		$result = $soapclient -> call('bpSettleRequest', $parameters, $namespace);

		// Check for a fault
		if ($soapclient->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
			die();
		}else{
		

			$resultStr = $result;
			
			$errbank = $soapclient->getError();
			if ($errbank) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $errbank . '</pre>';
				die();
			} 
			else {
			 
				 if($resultStr['return']=='0'){
				  $tmp=$mydb->update_bank_start($_POST['CardHolderInfo'],$_POST['RefId'],$_POST['ResCode'],$_POST['SaleOrderId'],$_POST['SaleReferenceId'],$_SESSION['other']['bID']);
				}else{
				?>
				<div class ="err" ><h2>
				<?php echo $err->get_bank_err($resultStr);?>
				</h2>
				<?php echo 'SaleReferenceId = '.$_POST['SaleReferenceId'];?>
				</div>
				<?php
				}
				
				 
			} 
		
		}
			}
		
		}
		




?>
<div class ="note" ><h2>پرداخت با موفقیت انجام شد</h2></div>
<?php }
else{ ?>
<div class ="err" ><h2>
<?php echo $err->get_bank_err($_POST['ResCode']);?>
</h2>
<?php echo 'SaleReferenceId = '.$_POST['SaleReferenceId'];?>
</div>
<?php }
}else{
$bank_vars=json_decode($_SESSION['other']['vars_before_bank']);


if($tmp=$mydb->update_charge_start($_SESSION['other']['bID'],$bank_vars->price,$_SESSION['user']['username']))
echo '<div class="note">تراکنش با موفقیت انجام شد</div>';
else
echo '<div class="err">خطا در کسر شارژ</div>';
}
}


if($bank_vars->price==0)
switch( $bank_vars->service_name ){
case 'password':
{
 $mydb->user_change_password($bank_vars->user_id,$bank_vars->username,$bank_vars->new_pass);

echo '<div class="note">رمز عبور با موفقیت تغییر کرد</div>';break;
}
case 'lockpass':
{
 $mydb->user_change_lockpassword($bank_vars->user_id,$bank_vars->username,$bank_vars->newlock,$bank_vars->chname);

echo '<div class="note">رمز عبور Lock  با موفقیت تغییر کرد</div>';break;
}
}
session_unset('user');
session_unset('other');
session_destroy();?>