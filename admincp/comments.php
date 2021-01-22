<?php
session_start();
$pagetitle = "All Member";
include "init.php";
if (isset($_SESSION["admin"])) {
    $stmt = $con->prepare("SELECT comments.* , users.username 
                          FROM 
                          comments 
                          INNER JOIN users ON comments.u_id = users.ID 
                          ORDER BY comments.ID DESC");
    $stmt->execute();
    $allcomm = $stmt->fetchAll();
    $count = $stmt->rowCount();
    if ($count > 0) {
   ?>
        <div class="container">
            <h1 class="head_mem text-center">Members</h1>
            <div class="row">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>Comments</td>
                        <td>username <br> <b>who sended</b></td>
                        <td>date</td>
                        <td>controls</td>
                    </tr>

                    <?php
                    foreach ($allcomm as $com) {
                    ?>
                        <tr>
                            <td><?php echo $com["ID"] ?></td>
                            <td><?php echo $com["comment"] ?></td>
                            <td><?php echo $com["username"] ?></td>
                            <td><?php echo $com["datecomm"] ?></td>
                            <td>
                                <a class="confirm btn btn-danger" href="delecom.php?uid=<?php echo $com["ID"]; ?>">
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
        
         echo '<h1 class="head_mem text-center">Comments</h1>';
         $themeg = '<div class="text-center alert alert-info">NO Comments to SHow</div>';
         redirect($themeg,'back', 3 , 'back');
        
    }
} else {
    header("location:admin.php");
}

include $footer;
