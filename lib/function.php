<?php
function generateId() {
	$alphanum = "abcdefghijklmnopqrstuvwxyz0123456789";
	return substr(str_shuffle($alphanum), 0, 10);
}

 


function updateBankStep_1($token, $order_id, $RefId, $ResCode) {
	$dbConnection = getPayDbConnection();

	$query = " UPDATE `w3g_payment` SET `SaleOrderId` = $order_id, `RefId` = '" . $RefId . "', `step` = 1, `ResCode` = '$ResCode' WHERE `code` = '" . $token . "'";

	$dbConnection -> query($query);

	if ($dbConnection -> affectedRow())
		return true;
	else
		killApp("databaseError");
}

function updateBankStep_2($RefId, $ResCode, $SaleReferenceId) {
	$dbConnection = getPayDbConnection();

	$SaleReferenceId = intval($SaleReferenceId);

	$query = " UPDATE `w3g_payment` SET `step` = 2, `ResCode` = '$ResCode', `SaleReferenceId` = '$SaleReferenceId' WHERE `RefId` = '" . $RefId . "'";

	$dbConnection -> query($query);

	if ($dbConnection -> affectedRow())
		return true;
	else
		killApp("databaseError");
}

function updateBankStep_3($RefId, $ResCode, $use_charge = 0) {
	$dbConnection = getPayDbConnection();

	$query = " UPDATE `w3g_payment` SET `step` = 3, `ResCode` = '$ResCode', `paid` = 1 , `use_charge` = $use_charge WHERE `RefId` = '" . $RefId . "'";

	$dbConnection -> query($query);

	if ($dbConnection -> affectedRow())
		return true;
	else if ($ResCode == 0) {
		$_SESSION[$RefId]['settleDbError'] = true;
	} else {
		killApp("databaseError");
	}
}

function actionDone($RefId) {
	$dbConnection = getPayDbConnection();

	$query = " UPDATE `w3g_payment` SET `done` = 1 WHERE `RefId` = '" . $RefId . "'";

	$dbConnection -> query($query);

	if ($dbConnection -> affectedRow())
		return true;
	else
		killApp("notDone");
}

function actionFailed($RefId, $message) {
	$dbConnection = getPayDbConnection();

	$query = " UPDATE `w3g_payment` SET `sys_error` = '$message' WHERE `RefId` = '$RefId'";
	$dbConnection -> query($query);
}





?>