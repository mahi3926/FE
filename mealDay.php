<?php
session_start();
   if(!isset($_SESSION['logged'] ) ) 
   {
      echo "<br>To access this page you need to login first<br><br>You will redirect to login page in 3 seconds<br>";
      header("refresh: 3; url=login.html");
      exit();
   }

$day = $_GET['day'];
$_SESSION['day'] = $day;
header("location:dietPlan.php");
?>
