<?php
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $name=$_POST["name"];
        $password=$_POST["password"];
        $class=$_POST["class"];
        $conn=mysql_connect('localhost','root','');
        if (!$conn) {
            die('Connect MySql Error');
        }
        mysql_select_db('library',$conn);
        $sql="select * from user where UserName='".$name."' and Password='".$password."' and UserClass ='".$class."'";
        $res=mysql_query($sql);
        $num=mysql_num_rows($res);
        if ($num) {
            switch ($class) {
                case 'M':
                    session_start();
                    $_SESSION["manager_user"]=$name;
                    $_SESSION["class"]=$class;
                    $url="http://localhost/1/DBDesign/manager.php";
                    echo "<h1>LOGIN.............</h1>";
                    echo "<SCRIPT LANGUAGE='JavaScript'>";
                    echo "location.href='$url'";
                    echo "</SCRIPT>";
                    break;

                case 'R':
                    session_start();
                    $_SESSION["reader_user"]=$name;
                    $_SESSION["class"]=$class;
                    $url="http://localhost/1/DBDesign/index.php";
                    echo "<h1>LOGIN.............</h1>";
                    echo "<SCRIPT LANGUAGE='JavaScript'>";
                    echo "location.href='$url'";
                    echo "</SCRIPT>";
                    break;

                default:
                    break;
            }


        }else {
            echo "<SCRIPT LANGUAGE='JavaScript'>";
            echo "alert('Wrong Name or Wrong Password!!!!');";
            echo "history.go(-1);";
            echo "</SCRIPT>";
            exit;
        }

        mysql_close($conn);

    }
 ?>
