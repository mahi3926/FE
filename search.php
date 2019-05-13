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
$username = $_SESSION["username"];

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");


if (isset($argv[1])){ $msg = $argv[1]; }
else { $msg = "You are on search result page"; }

if($_SESSION['search'] == false)
{ 
  $foodname = $_GET['item'];
  $_SESSION['item'] = $foodname;
}
else
{
  $foodname = $_SESSION['item'];
}

$request = array();
if($request['type'] = 'search'){
$request['item'] = $foodname;

$response = $client->send_request($request);
$space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

echo"<br><br>";
echo (" $space Food Name -");
//$item = $_GET['item'];
echo ucfirst($foodname);
echo "<br><br>";

$iteminfo = $response['fields'];

echo("$space Item Name - ");
echo ($iteminfo['item_name']) ;
$item = $iteminfo['item_name'];
echo"<br><br>";
echo ("$space $foodname Calories - ");
echo ($iteminfo['nf_calories']);
$calories = $iteminfo['nf_calories'];
echo"<br><br>";
echo ("$space $foodname Sodium - ");
echo ($iteminfo['nf_sodium']);
echo"<br><br>";
echo ("$space $foodname Sugar - ");
echo ($iteminfo['nf_sugars']);
echo"<br><br>";
echo ("$space $foodname Protein - ");
echo ($iteminfo['nf_protein']);
echo"<br><br>";
echo ("$space Serving Size Quantity - ");
echo ($iteminfo['nf_serving_size_qty']);
echo"<br><br>";
echo ("$space Serving Size Unit - ");
echo($iteminfo['nf_serving_size_unit']);
echo"<br><br>";
}

$_SESSION['username'] = $username;
$_SESSION['foodname'] = $foodname;
$_SESSION['calories'] = $calories;

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
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:0;
  margin-left:570px;
}
#b2
{
  line-height: 28px;
  width: 100px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:-340px;
  margin-left:1350px;
}

#b3
{
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:0;
  margin-left:415px;
}

#b4
{
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:0;
  margin-left:0px;
}
#b5
{
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:0;
  margin-left:0px;
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
  margin-left:450px;
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
  <button id="b1" type="button" onclick="location.href='success.php'">Search Again</button>
  <button id="b2" type="button" onclick="location.href='login.html'">Logout</button>
  <button id="b3" type="button" onclick="location.href='favorite.php'">Add to Favorite</button>
  <button id="b4" type="button" onclick="location.href='displayfav.php'">Show My saved food</button>
  <button id="b5" type="button" onclick="location.href='userProfile.php'">Show My Profile Page</button>
</form>

<form action="meal.php">
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
      <input type=submit value="Add to Meal Planner" style="font-size:14pt; color:red" >
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

