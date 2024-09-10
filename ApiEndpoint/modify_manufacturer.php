<?php
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

$dblink = db_connect("devicelist");

$sql = "update `manufacturer` where `name`='$mid'";
$rst=$dblink->query($sql) or 
	die("<p>Something went wrong with $sql<br>".$dblink->error);
if($rst->num_rows<=0) {
	$sql="insert into `manufacturer` (`name`, `status`) values ('$mid', 'active')";
	$dblink->query($sql) or 
		die("<p>Something went wrong with $sql<br>".$dblink->error);

	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: Success';
	$output[]='MSG: Successfully Updated';
	$output[]='Action: None';
	$responseData=json_encode($output);
	echo $responseData;
	die();
} else {
	header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: Manufacturer already exists.';
    $output[]='Action: query_manufacturer';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}


?>