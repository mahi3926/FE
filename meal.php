<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}
$_SESSION['userLogin'] = true;
$_SESSION['addMeal'] = true;
$_SESSION['search'] = true;
$day = $_GET['day'];
$username = $_SESSION["username"];
$foodname = $_SESSION['foodname'];
$calories = $_SESSION['calories'];
$item = $_SESSION['item'];

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on add to meal page"; }

$request = array();
if($request['type'] = 'meal')
{
  $request['username'] = $username;
  $request['foodname'] = $foodname;
  $request['day'] = $day;
  $request['calories'] = $calories;
  $request['message'] = $msg;
  $responce = $client->send_request($request);

  echo "<script type='text/javascript'>alert('$foodname $responce');</script>";
  header("refresh: 0; url = search.php");
}

?>

