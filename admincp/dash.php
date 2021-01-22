<?php
session_start();
$pagetitle = "dashbord";
include "init.php";
if(isset($_SESSION["admin"])){

    $stmt = $con->prepare("SELECT COUNT(username) FROM users WHERE approval = 1");
    $stmt->execute();
    $count = $stmt->fetchColumn();


    $stmt2 = $con->prepare("SELECT COUNT(username) FROM users WHERE approval = 0");
    $stmt2->execute();
    $count2 = $stmt2->fetchColumn();

    $stmt3 = $con->prepare("SELECT COUNT(comment) FROM comments");
    $stmt3->execute();
    $count3 = $stmt3->fetchColumn();
?>
  <div class="container">
      <div class="row">
          <div class="col-lg-4">
             <div class="tmember">
                 <i class="fa fa-users"></i>
                 <span><a href="member.php"><?php echo $count ; ?></a></span>
             </div>
          </div>
          <div class="col-lg-4">
              <div class="tmember">
                 <i class="fa fa-user-plus"></i>
                 <span><a href="pending.php"><?php echo $count2 ; ?></a></span>
             </div>
          </div>
          <div class="col-lg-4">
              <div class="tmember">
                 <i class="fa fa-comments"></i>
                 <span><a href="comments.php"><?php echo $count3 ; ?></a></span>
              </div>
          </div>
      </div>
  </div>
<?php
}
else
{
    header("location:admin.php");
}
include $footer ;