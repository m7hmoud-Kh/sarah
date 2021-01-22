<?php 
session_start();
$pagetitle = "All Member";
include "init.php";
if(isset($_SESSION["admin"]))
{
    $stmt = $con->prepare("SELECT * FROM users WHERE approval = 0");
    $stmt->execute();
    $allinfo =$stmt->fetchAll();
    $count = $stmt->rowCount();
    if($count > 0){
    ?>
      <div class="container">
          <h1 class="head_mem text-center">Pending Members</h1>
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
                            <a class="confirm btn btn-success" href="pend.php?uid=<?php echo $info["ID"]; ?>">
                                <i class="fa fa-check"> Accept</i>
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
        
         echo '<h1 class="head_mem text-center">Pending Members</h1>';
         $themeg = '<div class="text-center alert alert-info">NO Pending Member TO show</div>';
         redirect($themeg,'back', 3 , 'back');
        
    }

}
else
{
    header("location:admin.php");
}

include $footer ; 
