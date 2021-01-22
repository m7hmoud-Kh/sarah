<?php
session_start();
$pagetitle = "Edit Porfile";
include "init.php";
if (isset($_SESSION["user"])) {

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $filename = $_FILES["avatar"]["name"];
        $ftype    = $_FILES["avatar"]["type"];
        $ftmp     = $_FILES["avatar"]["tmp_name"];
        $fsize    = $_FILES["avatar"]["size"];

        $extionallowed = array("jpeg", "png", "gif", "jpg");

        $extion = explode(".", "$filename");
        $extion = end($extion);
        $extion = strtolower($extion);

        $formerr = array();

        $user    = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $pass    = $_POST["pass"];
        $email   = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $fname   = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);

        if (empty($user)) {
            $formerr[] = "Username Is <b>Reqried</b>";
        }
        if (strlen($user) > 12) {
            $formerr[] = "Username Must be Less than <b>12</b>";
        }
        if (!empty($user)) {
            if (strlen($user) < 3) {
                $formerr[] = "Username Must be Greater than <b>4</b>";
            }
        }
        if (empty($pass)) {
            $formerr[] = "Password Is <b>Reqried</b>";
        }
        if (empty($email)) {
            $formerr[] = "EMAIL is <b>Reqried</b>";
        }
        if (empty($fname)) {
            $formerr[] = "Full Name is <b>Reqried</b>";
        }
        if (empty($filename)) {
            $formerr[] = "Image Must Be <b>Reqried</b>";
        }
        if (!in_array($extion, $extionallowed)) {
            $formerr[] = "This Extion not <b>Allowed</b>";
        }
        if ($fsize > 4194304) {
            $formerr[] = "This Size of Image Greater than <b>4MB</b>";
        }

        if (empty($formerr)) {
            $avatar = rand(0, 10000) . "_" . $filename;
            $path = "C:\\xampp\\htdocs\\php_mah\\صراحه\\upload\\";
            move_uploaded_file($ftmp, $path . $avatar);

            $stmt2 = $con->prepare("SELECT * FROM users WHERE username = ? AND ID != ?");
            $stmt2->execute(array($_SESSION["user"], $_SESSION["uid"]));
            $count = $stmt2->rowCount();
            if ($count > 0) {
                $formerr[] = "This name is <b>Exist</b> try anthor name";
            } else {


                $stmt = $con->prepare("UPDATE users SET username = :u , `password` = :p , email = :e , fullname = :f , `date` = now() , `image` = :a WHERE ID = :i");
                $stmt->execute(array(
                    'u' => $user,
                    'p' => $pass,
                    'e' => $email,
                    'f' => $fname,
                    "a" => $avatar,
                    'i' => $_SESSION["uid"]
                ));
                $count = $stmt->rowCount();
                if ($count == 0) {
                    $formerr[] = "NO Date Was <b>Updated</b>";
                } else {
                    $success = "<div class='alert alert-success'>This date was Updated</div>";
                }
            }
        }
    }

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(array($_SESSION["user"]));
    $info = $stmt->fetch();
?>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <h4 class="text-center sing">Edit</h4>
        <div class="form-group">
            <div>
                <input class="form-control" name="username" type="text" value="<?php echo $info["username"] ?>" placeholder="type your name" required autocomplete="off"></input>
            </div>
            <div>
                <input class="form-control" name="pass" type="password" value="<?php echo $info["password"] ?>" placeholder="type complex password" required autocomplete="new-password"></input>
            </div>
            <div>
                <input class="form-control" name="email" type="email" value="<?php echo $info["email"] ?>" placeholder="type availd email" required></input>
            </div>
            <div>
                <input class="form-control" name="fname" type="text" value="<?php echo $info["fullname"] ?>" placeholder="type your Full Name" required></input>
            </div>
            <div>
                <input class="form-control" name="avatar" type="file" required></input>
            </div>
            <input class="btn btn-primary" type="submit" value="Save">
            <?php
            if (!empty($formerr)) {
                foreach ($formerr as $err) {
            ?>
                    <div class="alert alert-danger"><?php echo $err; ?></div>
            <?php
                }
            }
            if (isset($success)) {

                redirect($success, null, $sec = 3, null);
            }
            ?>
    </form>
<?php

} else {
    header("location:index.php");
}
include $footer;
