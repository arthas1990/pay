<?php
function discount(){
$all=json_decode($_SESSION['other']['vars_before_bank']);

$mydb=new db();
$discount=$all->price-$mydb->get_discount_prc($all->price);
$all->price=$discount;
$_SESSION['other']['vars_before_bank']=json_encode($all);	
}

?>