<?php 
session_start();
$pagetitle = "All Member";
include "init.php";
if(isset($_SESSION["admin"]))
{
    $stmt = $con->prepare("SELECT * FROM users WHERE approval = 1 ORDER BY ID DESC");
    $stmt->execute();
    $allinfo =$stmt->fetchAll();
    ?>
      <div class="container">
          <h1 class="head_mem text-center">Members</h1>
          <div class="row">
              <table class="main-table text-center table table-bordered">
                  <tr>
                      <td>ID</td>
                      <td>image</td>
                      <td>username</td>
                      <td>email</td>
                      <td>fullname</td>
                      <td>date</td>
                      <td>controls</td>
                  </tr>
                 
                      <?php
                      foreach($allinfo as $info)
                      {
                          ?>
                           <tr>
                          <td><?php echo $info["ID"] ?></td>
                          <td>
                            <div class="img">
                                <img src="<?php echo"../upload/".$info["image"]; ?>" alt="">
                            </div>     
                         </td>
                          <td><?php echo $info["username"] ?></td>
                          <td><?php echo $info["email"] ?></td>
                          <td><?php echo $info["fullname"] ?></td>
                          <td><?php echo $info["date"] ?></td>
                          <td>
                            <a class="confirm btn btn-danger" href="delemem.php?uid=<?php echo $info["ID"]; ?>">
                                <i class="fa fa-times"> Delete</i>
                            </a>    
                          </td>
                          </tr>
                          <?php
                      }
                    ?>

              </table>
          </div>
      </div>
    <?php

}
else
{
    header("location:admin.php");
}

include $footer ; 
