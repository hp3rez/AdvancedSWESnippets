<?php
if ($device==NULL)//missing manufacturer id
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing device name.';
    $output[]='Action: query_device';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

$dblink = db_connect("devicelist");
$sql="Select `auto_id` from `deviceTypes` where `name`='$device'";
$rst=$dblink->query($sql) or
	 die("<p>Something went wrong with $sql<br>".$dblink->error);
if ($rst->num_rows<=0)//manufacturer not previously found
{
	$sql="Insert into `deviceTypes` (`name`, `status`) values ('$device', 'active')";
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
	
} else { //trying to put existing manufacturer
	
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