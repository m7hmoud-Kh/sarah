<?php 

$host = "mysql:host=localhost;dbname=sharah";
$user= "root";
$password = "";

try 
{
  $con = new PDO($host,$user,$password);
}
catch(PDOException $e)
{
   echo "not connected sir".$e->getMessage();
}