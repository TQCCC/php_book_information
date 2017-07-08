<?php
    echo "<h1>注销中.................</h1>";
    session_start();
    $cls=$_SESSION["class"];
    $url="";
    switch ($cls) {
        case 'M':
            $url="http://localhost/1/DBDesign/manager.php";
            break;
        case 'R':
            $url="http://localhost/1/DBDesign/index.php";
            break;
        default:
            # code...
            break;
    }
    $_SESSION=array();
    session_destroy();
    echo "<SCRIPT LANGUAGE='JavaScript'>";
    echo "location.href='$url'";
    echo "</SCRIPT>";
 ?>
