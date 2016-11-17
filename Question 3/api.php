<?php
$conn = mysql_connect("localhost", "OMADMIN", "test");
mysql_select_db('OMDB', $conn);

//POST START
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$OrderRef = isset($_POST['OrderRef']) ? mysql_real_escape_string($_POST['OrderRef']) : "";
	$CustomerCode = isset($_POST['CustomerCode']) ? mysql_real_escape_string($_POST['CustomerCode']) : "";
	$OrderDate = mysql_real_escape_string(date('Y-m-d G:i:s'));
	$OrderType = isset($_POST['OrderType']) ? mysql_real_escape_string($_POST['OrderType']) : "";
	$sql = "INSERT INTO `tborders` (`ID`, `OrderRef`, `CustomerCode`, `OrderDate`, `OrderType`) VALUES (NULL, '$OrderRef', '$CustomerCode', '$OrderDate', '$OrderType')";
	$qur = mysql_query($sql);
	if ($qur)
	{
	$sql = "SELECT `id`, `OrderRef`, `CustomerCode`, `OrderDate`, `OrderType` FROM `tborders` ORDER BY `id` DESC LIMIT 1";
	$qur = mysql_query($sql);
	$result = array();
	while ($r = mysql_fetch_array($qur))
	{
		extract($r);
		$result[] = array(
			"id" => $id,
			"OrderRef" => $OrderRef,
			"CustomerCode" => $CustomerCode,
			'OrderDate' => $OrderDate,
			'OrderType' => $OrderType
		);
	}
	$json = array(
		"info" => $result[0]
	);
	}
	else
	{
		$json = array(
			"msg" => "Error"
		);
	}
}
else
{
	$json = array(
		"msg" => "Method not Found"
	);
}
//POST END

//GET Start
$id = isset($_GET['orders']) ? mysql_real_escape_string($_GET['orders']) : "";

if (!empty($id))
{
	$sql = "SELECT `id`, `OrderRef`, `CustomerCode`, `OrderDate`, `OrderType` FROM `tborders` WHERE `id` = '$id'";
	$qur = mysql_query($sql);
	$result = array();
	while ($r = mysql_fetch_array($qur))
	{
		extract($r);
		$result[] = array(
			"id" => $id,
			"OrderRef" => $OrderRef,
			"CustomerCode" => $CustomerCode,
			'OrderDate' => $OrderDate,
			'OrderType' => $OrderType
		);
	}

	$json = array(
		"info" => $result[0]
	);
}
elseif ($_SERVER['REQUEST_URI'] == "/api/orders/") {
	$sql = "SELECT `id`, `OrderRef`, `CustomerCode`, `OrderDate`, `OrderType` FROM `tborders`";
	$qur = mysql_query($sql);
	$result = array();
	$i = 0;
	while ($r = mysql_fetch_array($qur))
	{
		extract($r);
		$result[$i] = array(
			"id" => $id,
			"OrderRef" => $OrderRef,
			"CustomerCode" => $CustomerCode,
			'OrderDate' => $OrderDate,
			'OrderType' => $OrderType
		);
		$i++;
	}

	$json = array(
		"info" => (object)$result
	);

}

//GET END

//PUT START
if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
	
	$id = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
	$OrderRef = isset($_SERVER['HTTP_ORDERREF']) ? mysql_real_escape_string($_SERVER['HTTP_ORDERREF']) : "";
	$CustomerCode = isset($_SERVER['HTTP_CUSTOMERCODE']) ? mysql_real_escape_string($_SERVER['HTTP_CUSTOMERCODE']) : "";
	$OrderDate = mysql_real_escape_string(date('Y-m-d G:i:s'));
	$OrderType = isset($_SERVER['HTTP_ORDERTYPE']) ? mysql_real_escape_string($_SERVER['HTTP_ORDERTYPE']) : "";
	if (!empty($id))
	{
		$sql = "UPDATE `tborders` SET `OrderRef`='$OrderRef',`CustomerCode`='$CustomerCode',`OrderDate`='$OrderDate',`OrderType`='$OrderType' WHERE `id` = '$id'";
		$qur = mysql_query($sql);
		if ($qur)
		{
		$sql = "SELECT `id`, `OrderRef`, `CustomerCode`, `OrderDate`, `OrderType` FROM `tborders` ORDER BY `OrderDate` DESC LIMIT 1";
	$qur = mysql_query($sql);
	$result = array();
	while ($r = mysql_fetch_array($qur))
	{
		extract($r);
		$result[] = array(
			"id" => $id,
			"OrderRef" => $OrderRef,
			"CustomerCode" => $CustomerCode,
			'OrderDate' => $OrderDate,
			'OrderType' => $OrderType,
			'msg' => 'Info Updated.'
		);
	}
	$json = array(
		"info" => $result[0]
	);
		}
	}
}
//PUT END

@mysql_close($conn);
header('Content-type: application/json');
echo json_encode($json, JSON_PRETTY_PRINT);
?>























