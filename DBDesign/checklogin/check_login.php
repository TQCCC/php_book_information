<?php
    function check_login($cls='')
    {
        if ($cls=='M') {
            check_manager();
        }else if ($cls=='R') {
            check_reader();
        }
    }

    function check_reader()
    {
        session_start();
        if (!$_SESSION["reader_user"]) {
            echo "<form action='http://localhost/1/DBDesign/login.php' method='post' style='font-size:20px;font-family:fantasy'>
                <h3 style='font-family:fantasy;font-size:30px;text-align: center;'>LOGIN</h3>
                Name:<input type='text' name='name' value='' style='float:right' size='23'><br><br>
                Password:<input type='password' name='password' value='' style='float:right' size='23'><br><br>
                <input type='radio' name='class' value='R' checked='true'>Reader
                <input type='radio' name='class' value='M'>Manager
                <br><br>
                <input type='submit' name='submit' value='LOGIN' style='font-family:fantasy;font-size:20px'>
            </form>";
        }else {
            echo "<span style='font-size:25px;font-family:fantasy;'>Reader:";
            echo $_SESSION["reader_user"]."</span><br>";
            echo "<span style='text-align:center; font-family:黑体;font-size:25px;'>已登录</span>";
            echo " <a style='font-family:黑体;font-size:25px;' href='logoff.php'>注销</a>";
            echo " <a style='font-family:黑体;font-size:25px;' href='newpwd/newpwd_reader.php'>修改密码</a>";

        }
    }

    function check_manager()
    {
        session_start();
        if (!$_SESSION["manager_user"]) {
            echo "<form action='http://localhost/1/DBDesign/login.php' method='post' style='font-size:20px;font-family:fantasy'>
                <h3 style='font-family:fantasy;font-size:30px;text-align: center;'>请登录</h3>
                Name:<input type='text' name='name' value='' style='float:right' size='23'><br><br>
                Password:<input type='password' name='password' value='' style='float:right' size='23'><br><br>
                <input type='radio' name='class' value='R' checked='true'>Reader
                <input type='radio' name='class' value='M'>Manager
                <br><br>
                <input type='submit' name='submit' value='LOGIN' style='font-family:fantasy;font-size:20px'>
            </form>";
        }else {
            echo "<span style='font-size:25px;font-family:fantasy;'>管理员：";
            echo $_SESSION["manager_user"]."</span><br>";
            echo "<span style='text-align:center; font-family:黑体;font-size:25px;'>已登录</span>";
            echo " <a style='font-family:黑体;font-size:25px;' href='logoff.php'>注销</a>";
            echo " <a style='font-family:黑体;font-size:25px;' href='newpwd/newpwd_man.php'>修改密码</a>";

        }
    }

    function login_filter($cls){
        switch ($cls) {
            case 'R':
                session_start();
                if (!$_SESSION["reader_user"]) {
                    $url="http://localhost/1/DBDesign/index.php";
                    echo "<h1>Turning.............</h1>";
                    echo "<SCRIPT LANGUAGE='JavaScript'>";
                    echo "location.href='$url'";
                    echo "</SCRIPT>";
                }
                break;
            case 'M':
                session_start();
                if (!$_SESSION["manager_user"]) {
                    $url="http://localhost/1/DBDesign/index.php";
                    echo "<h1>Turning.............</h1>";
                    echo "<SCRIPT LANGUAGE='JavaScript'>";
                    echo "location.href='$url'";
                    echo "</SCRIPT>";
                }
                break;
            default:
                break;
        }

    }
 ?>
