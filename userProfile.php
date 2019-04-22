<?php
session_start();
if(!isset($_SESSION['logged'] ) ) 
{
   echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
   header("refresh: 3; url=login.html");
   exit();
}
$_SESSION['userLogin'] = true;
$_SESSION['display'] = true;
$username = $_SESSION['username'];

require_once('/home/pankil/git/rabbitmqphp_example/path.inc');
require_once('/home/pankil/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/pankil/git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/pankil/git/rabbitmqphp_example/testRabbitMQ.ini","testServer");

if (isset($argv[1])) { $msg = $argv[1]; }
else { $msg = "You are on user profile page"; }

  $request = array();
  $request['type'] = "userProfile";
  $request['username']  = $username;
  $request['message']   = $msg;

  $response = $client->send_request($request);

  $welcome = '<font size = "10" color = "coloring"> Your Saved Informations:';
  echo "<div align='center'><br><br>$welcome $response</div>";	

?>

<!DOCTYPE html>
<html lang="en">
<style>

#header{ min-height: 20px;}

#body
{
   min-height: 130px;
   margin-top: -2%;
}

#b1
{
   position:fixed;
   right:670px;
   top:500px;
   background-color: blue;
   color:white;
   font-size: 15pt;
}
#b2
{
  position:fixed;
  right:660px;
  top:540px;
  background-color: blue;
  color:white;
  font-size: 15pt;
}
#b3
{
  position:fixed;
  right:720px;
  top:580px;
  background-color: blue;
  color:white;
  font-size: 15pt;
}
#option
{
  line-height: 30px;
  width: 150px;
  background-color: gray;
  color:black;
  font-size: 15pt;
  color: white;
  margin-top:0;
  margin-left:0px;
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
  <button id="b1" type="button" onclick="location.href='success.php'">Go to Search Page</button>
</div>

<button id="b2" type="button" onclick="location.href='displayfav.php'">Show My saved food</button>

<div>
  <button id="b3" type="button" onclick="location.href='login.html'">Logout</button>
</div>
</form>

<form action="mealDay.php">
      <select name = "day" id = "option">
      <option value = '' > Choose a Day </option>
      <option value = 'Monday' > Monday    </option>
      <option value = 'Tuesday' > Tuesday   </option> 
      <option value = 'Wednesday' > Wednesday   </option>
      <option value = 'Thursday' > Thursday   </option>
      <option value = 'Friday' > Friday   </option>
      <option value = 'Saturday' > Saturday   </option>
      <option value = 'Sunday' > Sunday   </option>
      </select>
      <input type=submit value="Show my Daily Meal Plan" style="font-size:14pt; color:red">
</form>
</body>
