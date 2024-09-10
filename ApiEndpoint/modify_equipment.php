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
if ($id==NULL)
{
	header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing identification number.';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

$dblink = db_connect("devicelist");
$sql = "UPDATE `devices` SET `device`='$did', `manufacturer`='$mid', `serial_number`='$sn' WHERE `auto_id`='$id'";
$rst=$dblink->query($sql) or
	 die("<p>Something went wrong with $sql<br>".$dblink->error);

$sql = "select * from `manufacturer` where `name`='$mid'";
$rst=$dblink->query($sql) or 
	die("<p>Something went wrong with $sql<br>".$dblink->error);
if($rst->num_rows<=0) {
	$sql="insert into `manufacturer` (`name`, `status`) values ('$mid', 'active')";
	$dblink->query($sql) or 
		die("<p>Something went wrong with $sql<br>".$dblink->error);
}

$sql = "select * from `deviceTypes` where `name`='$did'";
$rst=$dblink->query($sql) or 
	die("<p>Something went wrong with $sql<br>".$dblink->error);
if($rst->num_rows<=0) {
	$sql="insert into `deviceTypes` (`name`, `status`) values ('$did', 'active')";
	$dblink->query($sql) or 
		die("<p>Something went wrong with $sql<br>".$dblink->error);
}

header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: Success';
$output[]='MSG: Successfully Updated';
$output[]='Action: None';
$responseData=json_encode($output);
echo $responseData;
die();
?>