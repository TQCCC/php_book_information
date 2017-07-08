<?php
    include '../checklogin/check_login.php';
    login_filter('R');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $new_pwd=$_POST["new_pwd"];
        $pre_pwd=$_POST["pre_pwd"];
        session_start();
        $name=$_SESSION["reader_user"];

        $conn=mysql_connect('localhost','root','');
        if (!$conn) {
            die('Connect MySql Error');
        }
        mysql_select_db('library',$conn);

        $sql="select * from user where UserName='$name' and Password='$pre_pwd'";
        $res=mysql_query($sql);
        $num=mysql_num_rows($res);
        if($num){
            $sql="update user set Password='$new_pwd' where UserName='$name'";
            mysql_query($sql);
            echo "修改成功！！";
        }else{
            echo "原密码有误！！";
        }
        mysql_close($conn);

    }

 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>修改密码</title>
        <script type="text/javascript">
            function check_input() {
                if (document.f.pre_pwd.value==""
                || document.f.new_pwd.value=="" || document.f.sure_new_pwd.value=="") {
                    alert('请完善信息！！');
                    return false;
                }
                if (document.f.new_pwd.value != document.f.sure_new_pwd.value) {
                    alert('密码不匹配！！');
                    return false;
                }
                return true;
            }
        </script>
        <style media="screen">
            body{
                color: yellow;
                margin: 20px;
                background-color: gray;
                font-size: 25px;
                font-family: 黑体;
            }
            div.title,button{
                font-size: 40px;
                font-family: 黑体;
            }

        </style>
    </head>
    <body>
        <button type="button" name="back" onclick="location.href='http://localhost/1/DBDesign/'">返回</button>
        <div class="title">
            读者修改密码
        </div>
        <form name='f' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>"
            method="post" onsubmit="return check_input();">
            原密码： <input type="password" name="pre_pwd" value="">
            新密码： <input type="password" name="new_pwd" value="">
            确认密码： <input type="password" name="sure_new_pwd" value="">
            <input type="submit" name="name" value="确认修改">
        </form>
    </body>
</html>
