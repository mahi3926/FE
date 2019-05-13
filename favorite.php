<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}

//Getting required data
$_SESSION['userLogin'] = true;
$username = $_SESSION["username"];
$foodname = $_SESSION['foodname'];
$calories = $_SESSION['calories'];

//calling required files 
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on add to favorite page"; }

//Sending data to server
$request = array();
if($request['type'] = 'favorite')
{
  $request['username'] = $username;
  $request['foodname'] = $foodname;
  $request['calories'] = $calories;
  $request['message'] = $msg;

  //Getting Responce from server
  $response = $client->send_request($request);

  //Displaying message to user
  echo "<br><br><br><br><br><br><br><br><font size = 6><div style=text-align:center;><div style=color:red;>Food Name: $foodname<br>$response</div></div><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<style>
  #b1
  {
    line-height: 30px;
    width: 150px;
    background-color: blue;
    color:white;
    font-size: 15pt;
    margin-top:30;
    margin-left:680px;
  }

  body 
  {
    background-image: url("https://images.pexels.com/photos/616404/pexels-photo-616404.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>

<body>
  <form>
  <div>
    <button id="b1" type="button" onclick="location.href='success.php'">Search Again</button>
    <button id="b1" type="button" onclick="location.href='displayfav.php'">Show My saved food</button>
    <button id="b1" type="button" onclick="location.href='userProfile.php'">Show My Profile Page</button>
    <button id="b1" type="button" onclick="location.href='login.html'">Logout</button>
  </div>
  </form>
</body>
