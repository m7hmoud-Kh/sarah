<?php 
session_start();
include "init.php";
if(isset($_SESSION["user"]))
{
    if(isset($_GET["commid"]) && is_numeric($_GET["commid"]))
    {
        $comid = $_GET["commid"];

        $stmt=$con->prepare("SELECT * FROM comments WHERE u_id = ? AND  ID = ? ");
        $stmt->execute(array(($_SESSION["uid"]),$comid));
        $count = $stmt->rowCount();
        if($count > 0)
        {
          $stmt2 = $con->prepare("DELETE FROM comments WHERE ID = ?");
          $stmt2->execute(array($comid));
          $count2 = $stmt2->rowCount();
          if($count2 > 0)
          {
              ?>
                <div class="container">
                <?php 
                    $themeg  ="<div class='alert alert-success'>This Comment Was DEleted</div>";
                  redirect($themeg,'back', $sec = 3 , 'back');
                ?>
                </div>
              <?php

          }
        }
    }
}
else
{
  header("location:index.php");
}
include $footer ; 