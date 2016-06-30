<?php
include '../checklogin/check_login.php';
login_filter('M');

if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["sub_add"])) {
    $readerid=$_POST["reader_id"];
    $pwd=$_POST["reader_pwd"];
    $conn=mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error.............');
    }
    mysql_select_db('library',$conn);

    $sql="insert into user(UserName,Password)values('$readerid','$pwd')";
    mysql_query($sql);
    if (mysql_affected_rows()==1) {
        echo "添加成功！！Reader:$readerid";
    }else {
        echo "Error to add new reader. affected_rows:".mysql_affected_rows();
    }

}else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["sub_del"])) {
    $readerid_arr=$_POST["select_reader"];
    $conn=mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error.............');
    }
    mysql_select_db('library',$conn);
    for($i=0;$i<count($readerid_arr);$i++){
        $sql="delete from user where UserName='".$readerid_arr[$i]."'";
        mysql_query($sql);
        $num_del_u=mysql_affected_rows();
        $sql="delete from lend where UserName='".$readerid_arr[$i]."'";
        mysql_query($sql);

        if ($num_del_u==1) {
            echo "删除成功：$readerid_arr[$i]";
        }else {
            echo "error to delete:$readerid_arr[$i] affected_rows:".$num_del_u.":".$num_del_l."<br>";
        }
    }

    mysql_close($conn);

}
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>读者管理</title>
        <script type="text/javascript">
            function check_sure() {
                if (document.f_add.reader_id.value=="" || document.f_add.sure_reader_pwd.value == "" || document.f_add.reader_pwd.value == "") {
                    alert('请完善读者信息！！');
                    return false;
                }
                if (document.f_add.reader_pwd.value != document.f_add.sure_reader_pwd.value) {
                    alert('密码不匹配！！');
                    return false;
                }
                return true;
            }
        </script>
        <style media="screen">
            input[type='submit']{
                font-size: 25px;
                font-family: 黑体;
            }

            body{
                font-size: 25px;
                font-family: 黑体;
                margin: 20px;
                background-color: gray;
                color: yellow;
            }
            div#title{
                font-size: 40px;
            }
            button{
                font-size: 20px;
                font-family: 黑体;
            }
        </style>
    </head>
    <body>
        <button type="button" name="back" onclick="location.href='http://localhost/1/DBDesign/manager.php'">返回</button><br>
        <div id="title">
            修改/删除读者
        </div>
        <form name='f_add' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" onsubmit="return check_sure();">
            读者编号： <input type="text" name="reader_id" value="">
            读者密码： <input type="password" name="reader_pwd" value="">
            确认读者密码： <input type="password" name="sure_reader_pwd" value="">
            <input type="submit" name="sub_add" value="添加该读者" ><br><br><br>
        </form>
        <form name='f_delete' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <select name="select_reader[]" multiple="multiple" style="font-size:25px;height:150px;width:400px;">
                <?php
                    $conn = mysql_connect('localhost','root','');
                    if (!$conn) {
                        die('Connect MySql Error');
                    }
                    mysql_select_db('library',$conn);
                    $sql="select UserName from user where UserClass='R' ";
                    $res=mysql_query($sql);
                    echo "所有读者：<br>";
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["UserName"]."'>".$row["UserName"]."</option>";
                    }
                 ?>
            </select>
            <input type="submit" name="sub_del" value="删除所选读者">
        </form>
    </body>
</html>
