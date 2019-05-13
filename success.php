<?php
  session_start();
  if(!isset($_SESSION['logged'] ) ) 
  {
     echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
     header("refresh: 3; url=login.html");
     exit();
  }
  $username = $_SESSION['username'];
  $_SESSION['display'] = true;
  $_SESSION['search'] = false; 

  //Calling Required Files
  require_once('path.inc');
  require_once('get_host_info.inc');
  require_once('rabbitMQLib.inc');

  if (isset($argv[1])) { $msg = $argv[1]; }
  else { $msg = "You are on user profile page"; }
  
  //Calculating BMI
  $gender = $_POST['gender'];
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $calculation=(($weight/2.20462)/pow(($height/39.3700787),2));
  $BMI = (round($calculation*100)/100);

  $request = array();

  //User Welcome Message
  if($_SESSION['userLogin'] == true)
  {
    if($request['type'] = "success1")
    {
      $request['username']  = $username;
      $request['message']   = $msg; 
    
      $client1 = new rabbitMQClient("testRabbitMQ.ini","testServer");
      $response1 = $client1->send_request($request);
      $_SESSION['userFullname'] = $response1;
      
      //Display User's Full Name
      $welcome = '<font size = "6" color = "coloring"> Welcome';
      echo "<div align='center'>$welcome $response1</div>";
    }
    $_SESSION['userLogin'] = false;
  }
  
  //Saving BMI for user
  $userFullname = $_SESSION['userFullname'];
  if($_POST['calBMI'])
  {
    $client2 = new rabbitMQClient("/home/pankil/git/rabbitmqphp_example/testRabbitMQ.ini","testServer");
    if($request['type'] = "success2")
    {
      $request['username']  = $username;
      $request['BMI'] = $BMI;
      $request['gender']  = $gender;
      $request['height']  = $height;
      $request['weight']  = $weight;
      $request['message']   = $msg;
 
      $response2 = $client2->send_request($request);

      $welcome = '<font size = "6" color = "coloring"> Welcome';
      echo "<div align='center'>$welcome $userFullname</div>";
      echo "<div align='center'> Your new BMI is $BMI</div>";
    }
  }

?>

<!DOCTYPE html>
<meta charset="UTF-8">
<style>

#form1
{ 	
   width:35%;
   position:center;
   background: gray;
   margin: fixed ;
   border: 1px solid blue ;  
   border-radius: 30px; 
   box-sizing: border-box; 
   padding: 10px; 
   overflow:auto;
}

#b1
{
  line-height: 30px;
  width: 100px;
  border-radius: 50%;
  text-align: center;
  position:absolute;
  right:20%;
  top:50%;
  background-color: green;
  color:white;
  font-size: 15pt;
}

#b2
{
  line-height: 30px;
  width: 100px;
  border-radius: 50%;
  text-align: center;
  position:absolute;
  right:75%;
  top:50%;
  background-color: green;
  color:white;
  font-size: 15pt;
}

#b3
{
  line-height: 30px;
  width: 80px;
  border-radius: 25%;
  cursor: pointer;
  text-align: center;
  position:absolute;
  right:25px;
  top:25px;
  background-color: blue;
  color:white;
  font-size: 15pt;
}

#b4
{
  line-height: 30px;
  width: 150px;
  background-color: blue;
  color:white;
  font-size: 15pt;
  margin-top:-150px;
  margin-left:-50px;
}

body 
{
  background-image: url("https://images.pexels.com/photos/616404/pexels-photo-616404.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

#height, #weight { width: 50%; }

</style>

<div align = "center">
<body> 

  <div id = "form1">
  <form action = "success.php" method="POST" >
    <font size="4" color="white">Provide the following info to calculate your BMI</font>
    <table>
      <tr><td>Gender:</td>
      <td><select name = "gender" id = "gender">
      <option value = ''  > Choose one </option>
      <option value = 'Male' > Male    </option>
      <option value = 'Female' > Female   </option>
      </select></td>
      
      <tr><td>Height: &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</td>
      <td><input type=text placeholder="height in inches" name="height" id="height" autocomplete = "off"></td>
      </tr>

      <tr><td>weight :</td>
      <td><input type=text placeholder="weight in pounds" name="weight" id="weight" autocomplete = "off"></td>
      </tr>
    </table>
    <input type="submit" name="calBMI" value="Compute And Save BMI">
  </form>
  </div>

  <center>
     <img hspace="10" src="search.png" width="20%" height="auto">
  </center>

  <form action ="search.php">
    <font size = "6">Please enter the food name below:&ensp;</font>
    <table>
      <tr>
      <td><input type=text placeholder="Food Name" name="item" id = "item" autocomplete = "off" required></td>
      <td><input type="submit" value="Click here to search for an item" style="font-size:14pt"></td>
      <td><p style = "color:white;" span id = "warning1" ></p></span></td>
      </tr>
    </table>
  </form>
  
  <br><button id="b1" type="button" onclick="location.href='userProfile.php'">Show My Profile Page</button>
  
  <br><button id="b2" type="button" onclick="location.href='displayfav.php'">Show My saved food</button>

  <br><button id="b3" type="button" onclick="location.href='login.html'">Logout</button>

</body>
</div>


