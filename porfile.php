<?php
session_start();
$pagetitle = "Porfile";
include "init.php";
if (isset($_SESSION["user"])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(array($_SESSION["user"]));
    $info = $stmt->fetch();
    $path = "../صراحه/upload/";

    $stmt2 = $con->prepare("SELECT * FROM comments WHERE u_id = ? ORDER BY datecomm DESC");
    $stmt2->execute(array($info["ID"]));
    $allcom = $stmt2->fetchAll();
    $count = $stmt2->rowCount();
?>
    <h1 class="text-center headpor"><?php echo strtoupper($_SESSION["user"]); ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="imageporfile">
                    <img src="<?php echo $path . $info["image"] ?>" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <h4 class='text-center headinfo'>MY Information</h4>
                <ul class="list-unstyled info">
                    <div class="list_info">
                        <i class="fas fa-envelope-open"></i>
                        <li><?php echo $info["email"] ?></li>
                    </div>
                    <div class="list_info">
                        <i class="fa fa-user"></i>
                        <li><?php echo $info["fullname"] ?></li>
                    </div>
                    <div class="list_info">
                        <i class="far fa-calendar-alt"></i>
                        <li><?php echo $info["date"] ?></li>
                    </div>
                </ul>
                <a class='btn btn-primary' href="edit.php">
                <i class='fa fa-edit'></i> Edit
               </a>
            </div>
        </div>
        <h1 class="text-center headpor">MY Comments</h1>
        <div class="row">
            <?php
            foreach ($allcom as $com) { 
            ?>
            <div class="col-lg-3">
                <span class="datecomm"><?php echo $com["datecomm"]; ?></span>
                <a class='delcomm btn btn-danger confirm' href="delcom.php?commid=<?php echo $com["ID"] ?>">
                    <i class='fa fa-times'> Delete</i>
                </a>
            </div>
                <div class="col-lg-9">
                    <div class="comm">
                        <p><?php echo $com["comment"]; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php 
              if ($count == 0)
              {
                 echo "<div class='nocom alert alert-info'>No Comment To Show</div>";
              }
            ?>
        </div>
    </div>
<?php
} 
else {
    header("location:index.php");
}
include $footer;
