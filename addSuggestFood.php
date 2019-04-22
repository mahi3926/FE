<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}

require_once('/home/pankil/git/rabbitmqphp_example/path.inc');
require_once('/home/pankil/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/pankil/git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/pankil/git/rabbitmqphp_example/testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on add suggest page"; }

$username = $_SESSION['username'];
$foodname = $_GET['id'];
$day = $_SESSION['day'];

$request = array();
$request['type'] = 'addSuggest';
$request['username'] = $username;
$request['foodname'] = $foodname;
$request['day'] = $day;
$request['message'] = $msg;

$response = $client->send_request($request);
echo "<script type='text/javascript'>alert('$foodname $response');</script>";
header("refresh: 0; url = dietPlan.php"); 
?>
