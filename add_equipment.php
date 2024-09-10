<?php

if ($did==NULL)//decive id is missing
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing device id.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($mid==NULL)//missing manufacturer id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing manufacturer id.';
    $output[]='Action: query_manufacturer';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}
if ($sn==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing serial number.';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

$dblink = db_connect("devicelist");
$sql="Select `auto_id` from `serials` where `serial`='$sn'";
$rst=$dblink->query($sql) or
	 die("<p>Something went wrong with $sql<br>".$dblink->error);
if ($rst->num_rows<=0)//sn not previously found
{
	$sql="Select `name` from `deviceTypes` where `auto_id`='$did'";
	$result=$dblink->query($sql) or
		die("<p>Something went wrong with $sql<br>".$dblink->error);
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
			$device=$data['name'];
	if(is_null($device)) {
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: Invalid device id.';
		$output[]='Action: query_device';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}
	
	
	$sql="Select `name` from `manufacturer` where `auto_id`='$mid'";
	$result=$dblink->query($sql) or
		die("<p>Something went wrong with $sql<br>".$dblink->error);
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
			$manufacturer=$data['name'];
	if(is_null($manufacturer)) {
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: Invalid manufacturer id.';
		$output[]='Action: query_device';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	}

	$sql="Insert into `devices` (`device`,`manufacturer`,`serial_number`) values ('$device','$manufacturer','$sn')";
	$dblink->query($sql) or
		 die("<p>Something went wrong with $sql<br>".$dblink->error);
	$sql="Insert into `serials` (`serial`) values ('$sn')";
	$dblink->query($sql) or
		 die("<p>Something went wrong with $sql<br>".$dblink->error);
	
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: Success';
	$output[]='MSG: Successfully Added';
	$output[]='Action: None';
	$responseData=json_encode($output);
	echo $responseData;
	die();
	
} else {
	
	header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='Msg: Device already exists';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
	
}
?>