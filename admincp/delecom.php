<?php 
session_start();
$pagetitle = "Delete comments";
include "init.php";
if(isset($_SESSION["admin"]))
{
  if(isset($_GET["uid"]) && is_numeric($_GET["uid"]))
  {
     $uid = $_GET["uid"];

     $stmt = $con->prepare("SELECT ID FROM comments WHERE ID = ?");
     $stmt->execute(array($uid));
     $count = $stmt->rowCount();
     if($count > 0)
     {
          $stmt2 =$con->prepare("DELETE FROM comments WHERE ID = ?");
          $stmt2->execute(array($uid));
          $count2 = $stmt2->rowCount();
          if($count2 > 0)
          {
            echo "<div class='container'>";
            $themeg = "<div class='alert alert-success'>This comment Was <b>Deleted</b></div>";
            redirect($themeg,'back', 2 , 'back');
            echo "</div>";
          }
     }
     else
     {
         echo "<div class='container'>";
         echo "<div class='alert alert-danger'>There Is No Such <b>ID</b></div>";
         echo "</div>";
     }
  }
  else
  {
    header("location:admin.php");
  }
}
else
{
    header("location:admin.php");
}

include $footer ;