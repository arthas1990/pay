<?php
if(isset($_SESSION['other']['step']) && $_SESSION['other']['step']=='sms' && isset($_POST['request_sms'])){
if($_POST['request_sms']!=$_SESSION['other']['securitycode'])
if($_SESSION['other']['sms_wrong']==$sms->sms_total_resend)
$err->login('wrongSecurityCode') ;
else {
$_SESSION['other']['sms_wrong']++;
$_REQUEST['step']=$_SESSION['other']['step'];
$err->add('wrongSecurityCode','site','warn') ;
$_SESSION['other']['sms_confirmed']='0';
}
}
$_SESSION['other']['sms_confirmed']='1';
?>