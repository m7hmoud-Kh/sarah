<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css ; ?>/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $css ; ?>/fontawes/font1/css/all.css">
    <link rel="stylesheet" href="<?php echo $css ; ?>/sraha.css">
    <title><?php gettilte(); ?></title>
</head>
<body>
<nav>
   <div class="container">
     <div class="row">
     <div class="col-lg-3">
       <span><a href="index.php">Sarahah</a></span>
     </div>
     <?php
     if(isset($_SESSION["user"]))
     {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($_SESSION["user"]));
        $info = $stmt->fetch();
        $path = "../../upload/9107_mood.jpg";  
         ?>
         <div class="col-lg-2 link text-right">
              <i class='fa fa-user-circle'></i>
             <a href="porfile.php"> <?php echo  $_SESSION["user"];?> </a>
         </div>
         <div class="col-lg-2 link text-right">
         <i class="fas fa-users-cog"></i>
             <a href="../../../../php_mah/صراحه/admincp/admin.php">Admin</a>
         </div>
         <div class="col-lg-2 link text-right">
           <i class="fas fa-door-open"></i>
             <a href="logout.php">LogOut</a>
         </div>
        <?php
     }else{
     ?>
            <div class="col-lg-9 text-right link">
            <a href="login.php">login</a> <a href="singup.php">singUp</a>
            </div>
     <?php 
     }
     ?>
     </div>
   </div>
</nav>