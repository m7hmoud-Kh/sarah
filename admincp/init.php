<?php 

$connection = "C:\\xampp\\htdocs\\php_mah\\صراحه\admincp\\connect.php";
include $connection;

$functions = 'C:\\xampp\\htdocs\\php_mah\\صراحه\admincp\include\functions\\';

include $functions."fun.php";

$stpl = "C:\\xampp\\htdocs\\php_mah\صراحه\\admincp\\include\\tempete\\";

$css = "include\\tempete\\layout\css";
$js  = "include\\tempete\\layout\\js";

include $stpl."header.php";


$footer = $stpl."footer.php";