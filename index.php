<?php
session_start();
$pagetitle = "Homepage";
include "init.php";

if($_SERVER["REQUEST_METHOD"] == 'POST')
{ 

    $formerr = array();

    $mesg = $_POST["mesg"];
    $uid  =$_POST["him"];

     if(empty($mesg))
     {
      $formerr[] = "this message is <b>Reqired</b>";
     }
     if(!empty($mesg)){
        if(strlen($mesg) < 3)
        {
            $formerr[] = "this message must be greater than <b>3</b>";
        }
     }
     if($uid == 0)
     {
        $formerr[] = "you must be select <b>person</b>";
     }
     if(empty($formerr))
     {
         $stmt2 = $con->prepare("INSERT INTO comments (comment , datecomm , u_id ) VALUES (:c , now() , :u)");
         $stmt2->execute(array(
             'c' =>  $mesg ,
             'u' =>   $uid
         ));
         $count = $stmt2->rowCount();
         if($count > 0)
         {
            $success = "<div class='alert alert-success'>Your message Is Sended<div>";
         }
     }

}
if(isset($_SESSION["user"]))
{
    $stmt = $con->prepare("SELECT * FROM users WHERE username  != ? AND approval = 1  ORDER BY username ");
    $stmt->execute(array($_SESSION["user"]));
    $users = $stmt->fetchAll();
    ?>
    <div class="image">
        <div class="layout">
            <div class="container withouts">
                <form class="form-group" action="<?php echo $_SERVER["PHP_SELF"] ; ?>" method="POST">
                  <textarea class="form-control" name="mesg" placeholder="type your message and select the person"></textarea>
                  <select class="form-control" name="him">
                      <option value="0">---</option>
                      <?php 
                        foreach($users as $use)
                        {
                            ?>
                              <option value="<?php echo $use["ID"] ; ?>"><?php echo $use["username"] ?></option>
                            <?php
                        }
                      ?>
                  </select>
                  <input class="btn btn-primary"  type="submit" value="Add">
                  <?php
                  if(!empty($formerr))
                  {
                      foreach($formerr as $err)
                      {
                          ?>
                              <div class="alert alert-danger"><?php echo $err;  ?></div>
                          <?php
                      }
                  } 

                  if(isset($success))
                  {
                      echo $success;
                  }
                  ?>
                </form>
            </div>
        </div>
    </div>
    <?php
}
else
{
    $stmt = $con->prepare("SELECT * FROM users WHERE approval = 1 ORDER BY username");
    $stmt->execute();
    $users = $stmt->fetchAll();
    ?>
    <div class="container withouts">
    <form class="form-group" action="<?php echo $_SERVER["PHP_SELF"] ; ?>" method="POST">
      <textarea class="form-control" name="mesg" placeholder="type your message and select the person"></textarea>
      <select class="form-control" name="him">
          <option value="0">---</option>
          <?php 
            foreach($users as $use)
            {
                ?>
                  <option value="<?php echo $use["ID"] ; ?>"><?php echo $use["username"] ?></option>
                <?php
            }
          ?>
      </select>
      <input class="btn btn-primary"  type="submit" value="Add">
      <?php
      if(!empty($formerr))
      {
          foreach($formerr as $err)
          {
              ?>
                  <div class="alert alert-danger"><?php echo $err;  ?></div>
              <?php
          }
      } 

      if(isset($success))
      {
          echo $success;
      }
      ?>
    </form>
</div>
<?php
}

include $footer  ;