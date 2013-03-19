<?php if($_SESSION['other']['pay_type']=='bank'){?>
<form method="post" action="?send">
<div>
 در حال انتقال به درگاه بانک ...
  </div>
</form>
<?php
		
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	//$page = curl_exec ($ch);
	
	

 
$namespace = 'http://interfaces.core.sw.bps.com/';

 $soapclient = new nusoap_client('https://pgws.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl', 'wsdl');

	///////////////// PAY REQUEST
		$bank_vars=json_decode($_SESSION['other']['vars_before_bank']);
	 
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
		$err = $soapclient->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
			die();
		}
	  
		$parameters = array(
			'terminalId' => $terminalId,
			'userName' => $userName,
			'userPassword' => $userPassword,
			'orderId' => $orderId,
			'amount' => $amount,
			'localDate' => $localDate,
			'localTime' => $localTime,
			'additionalData' => $additionalData,
			'callBackUrl' => $callBackUrl,
			'payerId' => $payerId); 
		// Call the SOAP method
 
		$result = $soapclient -> call('bpPayRequest', $parameters, $namespace);

		// Check for a fault
		if ($soapclient->fault) {
			echo '<h2>Fault</h2><pre>';
			print_r($result);
			echo '</pre>';
			die();
		} 
		else {
			// Check for errors
			
			$resultStr  = $result;

			$err = $soapclient->getError();
			if ($err) {
				// Display the error
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
				die();
			} 
			else {
				// Display the result
				 
				$resultStr = explode(',', $resultStr['return']);
				 $ResCode = $resultStr[0];
				$RefId = $resultStr[1];

				 

				
				
				if ($ResCode == "0") {
				 
					 ?>
					 <script language="javascript" type="text/javascript">
        function postRefId (refIdValue) {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", "https://pgw.bpm.bankmellat.ir/pgwchannel/startpay.mellat");
            form.setAttribute("target", "_self");
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "RefId");
            hiddenField.setAttribute("value", refIdValue);
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
//          document.body.removeChild(form);
        }
        postRefId('<?php echo $RefId; ?>');
    </script>
					 <?php
					 
				} 
				else{ 
				echo '<dev class="err">'.$err->get_bank_err($ResCode).'</div>' ;
				
				}
				 
		} 
	}
 }else{
 		$bId =$mydb->insert_charge_start($bank_vars->username,$bank_vars->character_id ,$bank_vars->service_name ,$bank_vars->price ,$bank_vars->name ,$bank_vars->tel ,$bank_vars->description );
		$_SESSION['other']['bID']=$bId ;
		echo 'انتقال برای کسر از شارژ... <meta http-equiv="refresh" content="0;URL='.$conf->cnf_base_url.'index.php?step=done" />';
 
 }
	?>
	
	