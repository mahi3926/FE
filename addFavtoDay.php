<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on add fav to daily plan page"; }

$username = $_SESSION['username'];
$day = $_GET['day'];
$_SESSION['day'] = $day;
$foodname = $_GET['food'];
$calories = $_GET['calories'];

$request = array();
$request['type'] = 'meal';
$request['username'] = $username;
$request['foodname'] = $foodname;
$request['calories'] = $calories;
$request['day'] = $day;
$request['message'] = $msg;

$response = $client->send_request($request);
echo "<script type='text/javascript'>alert('$foodname $response');</script>";
header("refresh: 0; url = dietPlan.php");

/*
$username = $_SESSION['username'];
$foodname = $_GET['id'];
if($_POST['Add']){$day = $_GET['day']; $_SESSION['day']=$day;}
else{$day = $_SESSION['day'];}

$request = array();
$request['type'] = 'addSuggest';
$request['username'] = $username;
$request['foodname'] = $foodname;
$request['day'] = $day;
$request['message'] = $msg;

$response = $client->send_request($request);
echo "<script type='text/javascript'>alert('$foodname $response');</script>";
header("refresh: 0; url = dietPlan.php"); */
?>
