<?php
if ($mid==NULL)//missing serial number
{
    header('Content-Type: application/json');
    header('HTTP/1.1 200 OK');
    $output[]='Status: ERROR';
    $output[]='MSG: missing manufacturer name';
    $output[]='Action: none';
    $responseData=json_encode($output);
    echo $responseData;
    die();
}

$dblink = db_connect("devicelist");
$sql="Select * from `devices` where `manufacturer`='$mid' limit 1000";
$rst=$dblink->query($sql) or
	 die("<p>Something went wrong with $sql<br>".$dblink->error);
if ($rst->num_rows<=0)//device not previously found
{
	header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]='Status: ERROR';
		$output[]='MSG: Equipment with manufacturer does not exist';
		$output[]='Action: none';
		$responseData=json_encode($output);
		echo $responseData;
		die();
	
} else {
	
	$equipment = array();
	while ($data=$rst->fetch_array(MYSQLI_ASSOC))
		$equipment[$data['auto_id']]=$data['device'].','.$data['manufacturer'].','.$data['serial_number'];
	
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]='Status: Success';
	$jsonDevices=json_encode($equipment);
	$output[]='MSG: '.$jsonDevices;
	$output[]='Action: None';
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
?>