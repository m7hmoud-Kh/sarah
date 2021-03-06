<?php
session_start(); 
$pagetitle = "Login Admin";
include "init.php";
if($_SERVER["REQUEST_METHOD"] == 'POST')
{
    $formerr = array();
  $user = filter_var($_POST["user"],FILTER_SANITIZE_STRING);
  $pass = $_POST["pass"];

  if(empty($user))
  {
    $formerr[] = "Username is <b>Reqired</b>";
  }
  if(empty($pass))
  {
    $formerr[] = "Password is <b>Reqired</b>";
  }

  if(empty($formerr))
  {
      $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND `password` = ? AND groupid = 1");
      $stmt->execute(array($user,$pass));
      $row = $stmt->fetch();
      $count =$stmt->rowCount();
      if($count > 0)
      {
          $_SESSION["admin"] = $user; 
          $_SESSION["aid"]  = $row["ID"];
          header("location:dash.php");
      }
      else
      {
        $formerr[] = "you are not  <b>admin</b>";
      }
  }
  
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center log">Admin login</h4>
    <div class="form-group">
        <div>
          <i class="fa fa-user"></i>   
          <input class="form-control login" type="text" name="user" placeholder="type your name" required  >
        </div>
        <div>
          <i class="fa fa-lock"></i>
          <input class="form-control login" type="password" name="pass" placeholder="type your password"  autocomplete="new-password" required>
        </div>
           
        <input class="btn btn-success" type="submit" value="login">
        <?php
        if(! empty($formerr))
        {
            foreach($formerr as $err)
            {
                ?>
                <div class="alert alert-danger"><?php echo $err; ?></div>
                <?php
            }
        } 
        ?>
    </div>
</form>

<?php 
include $footer;