<?php

$dblink=db_connect("devicelist");
$sql="Select * from `deviceTypes` where `status` = 'active'";
$result=$dblink->query($sql) or
	die("<p>Something went wrong with $sql<br>".$dblink->error);
$devices=array();
while ($data=$result->fetch_array(MYSQLI_ASSOC))
	$devices[$data['auto_id']]=$data['name'];

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$jsonDevices=json_encode($devices, true);
$output[]='MSG: '.$jsonDevices;
$output[]='Action: None';
$responseData=json_encode($output);
echo $responseData;
die();

?>