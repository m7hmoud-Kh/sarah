<?php 

$pagetitle = "SingUp";
include "init.php";

if($_SERVER["REQUEST_METHOD"] == 'POST')
{
   
    $filename = $_FILES["avatar"]["name"];
    $ftype    = $_FILES["avatar"]["type"];
    $ftmp     = $_FILES["avatar"]["tmp_name"];
    $fsize    = $_FILES["avatar"]["size"];

    $extionallowed = array("jpeg","png","gif","jpg");

    $extion = explode("." , "$filename");
    $extion = end($extion);
    $extion = strtolower($extion);

    $formerr = array();

   $user    = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
   $pass    = $_POST["pass"];
   $pass2   = $_POST["pass2"];
   $email   = filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
   $fname   = filter_var($_POST["fname"],FILTER_SANITIZE_STRING);

    if(empty($user))
    {
        $formerr []= "Username Is <b>Reqried</b>";
    }
    if(strlen($user) > 12)
    {
        $formerr []= "Username Must be Less than <b>12</b>";
    }
    if(! empty($user)){
        if(strlen($user) < 3)
        {
            $formerr []= "Username Must be Greater than <b>4</b>";
        }
    }
    if(empty($pass))
    {
        $formerr []= "Password Is <b>Reqried</b>";
    }
    if($pass !== $pass2)
    {
        $formerr []= "Password not <b>identical</b>";
    }
    if(empty($email))
    {
        $formerr []= "EMAIL is <b>Reqried</b>";
    }
    if(empty($fname))
    {
        $formerr []= "Full Name is <b>Reqried</b>";
    }
    if(empty($filename))
    {
        $formerr []= "Image Must Be <b>Reqried</b>";
    }
    if(! in_array($extion , $extionallowed ))
    {
        $formerr []= "This Extion not <b>Allowed</b>";
    }
    if($fsize > 4194304 )
    {
        $formerr []= "This Size of Image Greater than <b>4MB</b>";
    }
    
    if(empty($formerr))
    { 
        $avatar = rand(0,10000)."_".$filename;
        $path = "C:\\xampp\\htdocs\\php_mah\\صراحه\\upload\\";
        move_uploaded_file($ftmp,$path.$avatar);

        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? ");
        $stmt->execute(array($user));
        $count = $stmt->rowCount();
        if($count > 0)
        {
            $formerr[] = "This is Name is exist sir try anthor name";
        }
        else
        {
            $stmt = $con->prepare("INSERT INTO users (username , `password` ,email, fullname ,`date` , `image`) 
                                VALUES(:u ,:p , :e ,:f, now(), :i )");
            $stmt->execute(array(
               'u' =>  $user,
               'p' => $pass,
               'e' => $email,
               'f' => $fname,
               'i' => $avatar
            ));
            $count = $stmt->rowCount();
            if($count == 0)
            {
                $formerr[] = "there is error please try anthor time";
            }
            else
            {    
                $themeg = "<div class='alert alert-success'>you are login Sir</div>";
                
            }
        }

    }

}
?>
<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
     <h4 class="text-center sing">SingUp</h4>
 <div class="form-group">
     <div>
         <input class="form-control" name="username" type="text" placeholder="type your name" required   autocomplete="off"></input>
     </div>
     <div>
         <input class="form-control" name="pass"  type="password" placeholder="type complex password" required  autocomplete="new-password"></input>
     </div>
     <div>
          <input class="form-control" name="pass2"  type="password" placeholder="type password again" required ></input>
     </div>
     <div>
          <input class="form-control" name="email"  type="email"   placeholder="type availd email" required ></input>
     </div>
     <div>
         <input class="form-control" name="fname"  type="text"  placeholder="type your Full Name" required ></input>
     </div>
     <div>
        <input class="form-control" name="avatar"  type="file"  required ></input>
    </div>
     <input class="btn btn-primary" type="submit" value="SingUP">


    <?php
    if(! empty($formerr)){
     foreach($formerr as $err)
    { 
    ?>
    <div class="alert alert-danger"><?php echo $err ; ?></div>
    <?php
    } 
    }
    if(isset($themeg))
    {
        redirect($themeg , 'login', $sec = 3 , 'login');
    }
    ?>
 </div>
</form>
<?php
include $footer;
?>