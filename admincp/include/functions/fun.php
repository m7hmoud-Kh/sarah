<?php 

/**
 * function return the name page
 */
function gettilte()
{
    global $pagetitle ;
    
    if(isset($pagetitle))
    {
        echo $pagetitle;
    }
    else
    {
        echo "defalut";
    }
}
/***
 * redirect 
 */
 function redirect($themeg, $url = null, $sec = 3 , $name = null)
 {
    if($url === null)
    {
        $url = "index.php";
    }
    elseif ($url == 'back')
    {
        if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "" )
        {
            $url = $_SERVER["HTTP_REFERER"];
        }
    }
    elseif($url === 'login')
    {
        $url = "login.php";
    }
    if($name === null)
    {
        $name = "Homepage";
    }
    elseif ($name === "back")
    {
        $name = "backPage";
    }
    elseif($name === "login")
    {
        $name = "login";
    }

     echo $themeg ;
     echo "<div class='text-center alert alert-info'>You will Redirect in $name after $sec second</div>";
     header("refresh:$sec;url=$url");
     exit();
 }