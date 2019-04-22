<?php
   session_start();
   if(!isset($_SESSION['logged'] ) ) 
   {
      echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
      header("refresh: 3; url=login.html");
      exit();
   }
   
   //Getting Data
   $_SESSION['userLogin'] = true;
   $username = $_SESSION['username'];
   //$itemdeleted = $_SESSION['itemdeleted'];

   //Calling Required Files
   require_once('/home/pankil/git/rabbitmqphp_example/path.inc');
   require_once('/home/pankil/git/rabbitmqphp_example/get_host_info.inc');
   require_once('/home/pankil/git/rabbitmqphp_example/rabbitMQLib.inc');

   if (isset($argv[1])) { $msg = $argv[1]; }
   else { $msg = "You are on suggest page"; }

   //Sending data to server
   $request = array();
   $request['type'] = "suggest";
   $request['username'] = $_SESSION['username'];
   $request['day'] = $_SESSION['day'];
   $request['message']   = $msg;
   
   //Geting responce from server
   $client = new rabbitMQClient("/home/pankil/git/rabbitmqphp_example/testRabbitMQ.ini","testServer");
   $response = $client->send_request($request);

   //Display message to user   
   $welcome = '<font size = "10" color = "coloring"> Here is some suggestion for you:';
   echo "<div align='center'><br><br>$welcome $response</div>";
   $deletMessage = '<font size = "4" color = "blue">';
   echo"$deletMessage $itemdeleted</font>";
   //$_SESSION['username'] = $username;
?>


<!DOCTYPE html>
<html lang="en">
<style>

#b1
{
   position:fixed;
   right:670px;
   top:440px;
   background-color: blue;
   color:white;
   font-size: 15pt;
}
#b2
{
  position:fixed;
  right:655px;
  top:480px;
  background-color: blue;
  color:white;
  font-size: 15pt;
}
#b3
{
  position:fixed;
  right:725px;
  top:520px;
  background-color: blue;
  color:white;
  font-size: 15pt;
}

#b4
{
  position:fixed;
  right:725px;
  top:560px;
  background-color: blue;
  color:white;
  font-size: 15pt;
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
    <button id="b1" type="button" onclick="location.href='success.php'">Go to Search Page</button>
    <button id="b2" type="button" onclick="location.href='userProfile.php'">Show My Profile Page</button>
    <button id="b3" type="button" onclick="location.href='suggest.php'">Surprise Me</button>
    <button id="b4" type="button" onclick="location.href='login.html'">Logout</button>
  </form>
</body>
