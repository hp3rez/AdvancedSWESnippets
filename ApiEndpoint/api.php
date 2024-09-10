<?php
include("../web/functions.php");
/*$url=$_SERVER['REQUEST_URI'];
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]='Status: ERROR';
$output[]='MSG: System Disabled';
$output[]='Action: None';
//log_error($_SERVER['REMOTE_ADDR'],"SYSTEM DISABLED","SYSTEM DISABLED: $endPoint",$url,"api.php");*/
$url=$_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathComponents = explode("/", trim($path, "/"));
$endPoint=$pathComponents[1];
switch($endPoint)
{
    case "add_equipment":
        $did=$_REQUEST['did'];
        $mid=$_REQUEST['mid'];
        $sn=$_REQUEST['sn'];
        include("add_equipment.php");
        break;
	case "add_manufacturer":
		$manufacturer=$_REQUEST['manufacturer'];
		include("add_manufacturer.php");
		break;
	case "add_device":
		$device=$_REQUEST['device'];
		include("add_device.php");
		break;
	 case "query_equipment":
        $sn=$_REQUEST['sn'];
        include("query_equipment.php");
        break;
	case "query_device":
		$did=$_REQUEST['did'];
		include("query_device.php");
		break;
	case "query_manufacturer":
		$mid=$_REQUEST['mid'];
		include("query_manufacturer.php");
		break;
	case "list_devices":
		include("list_devices.php");
		break;
	case "list_manufacturers":
		include("list_manufacturers.php");
		break;
	case "modify_equipment":
		$mid=$_REQUEST['mid'];
		$did=$_REQUEST['did'];
		$id=$_REQUEST['id'];
		$sn=$_REQUEST['sn'];
		include("modify_equipment.php");
		break;
    default:
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        $output[]='Status: ERROR';
        $output[]='MSG: Invalid or missing endpoint';
        $output[]='Action: None';
        $responseData=json_encode($output);
        echo $responseData;
        break;
}
die();
?>