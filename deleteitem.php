<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}

//Getting required data
$_SESSION['display'] = true;
$_SESSION['userLogin'] = true;
$foodname = $_GET['id'];
$username = $_SESSION['username'];

//Calling required files
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on delete item page"; }

//sending data to server
$request = array();
$request['type'] = 'delete';
$request['foodname'] = $foodname;
$request['username'] = $username;
$request['message'] = $msg;

//Getting responce from server
$response = $client->send_request($request);

//display message to user
$itemdeleted = "$foodname deleted successfully from your favorite list.";
$_SESSION['itemdeleted'] = $itemdeleted ;
header("location:displayfav.php");
?>
