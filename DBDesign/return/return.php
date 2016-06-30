<?php
include '../checklogin/check_login.php';
login_filter('M');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $bookid_arr=$_POST["select_lend_book"];
        $reader=$_POST["select_lend_reader"];

        $conn = mysql_connect('localhost','root','');
        if (!$conn) {
            die('Connect Mysql error..............');
        }
        mysql_select_db('library',$conn);
        if (count($bookid_arr)>0) {
            //要还多本书

            for($i=0;$i<count($bookid_arr);$i++){

                $sql="select * from lend where UserName='".$reader."' and BookId='".$bookid_arr[$i]."'";
                $res=mysql_query($sql);
                if (mysql_num_rows($res)>0) {
                    //如果有借书记录
                    $sql="delete from lend where UserName='".$reader."' and BookId='".$bookid_arr[$i]."'";
                    mysql_query($sql);
                    $num_del=mysql_affected_rows();

                    $sql="update book set Stock=Stock+1 where Id='$bookid_arr[$i]'";
                    mysql_query($sql);
                    $num_upd=mysql_affected_rows();

                    if ($num_del == 1 && $num_upd == 1) {
                        echo "还书成功！！图书代号：$bookid_arr[$i] <br>";
                    }else {
                        echo "Error........";
                    }


                }else {
                    echo "该读者并没有借这本书，代号：$bookid_arr[$i] <br>";
                }

            }

        }else {
            $sql="select * from lend where UserName='".$reader."' and BookId='".$bookid_arr[0]."'";
            $res=mysql_query($sql);
            if (mysql_num_rows($res)>0) {
                //如果有借书记录
                $sql="delete from lend where UserName='".$reader."' and BookId='".$bookid_arr[0]."'";
                mysql_query($sql);
                $num_del=mysql_affected_rows();

                $sql="update book set Stock=Stock+1 where Id='$bookid_arr[0]'";
                mysql_query($sql);
                $num_upd=mysql_affected_rows();

                if ($num_del == 1 && $num_upd == 1) {
                    echo "还书成功！！图书代号：$bookid_arr[0]";
                }else {
                    echo "Error........";
                }


            }else {
                echo "该读者并没有借这本书，代号：$bookid_arr[0] <br>";
            }

        }
    }


 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>还书</title>
        <style media="screen">
            button{
                margin-bottom: 10px;
                font-size: 25px;
                font-family: 黑体;
            }
            input[type='date']{
                font-family: 黑体;
                font-size: 20px;
            }
            input[type='submit']{
                font-size: 20px;
                font-family: 黑体;
            }
            div.title{
                position: absolute;
                font-size: 70px;
                font-family: 幼圆;
                left: 50%;
                top: 15%;
                font-weight: bolder;
            }
            body{
                background-repeat: no-repeat;
                background-size: 100%;
                background-image: url("../img/back.jpg");
                margin: 20px;
                color: yellow;
            }
        </style>
    </head>
    <body>
        <div class="title">
            还书
        </div>
        <button type="button" name="button" onclick="location.href='http://localhost/1/DBDesign/manager.php';">返回</button>
        <form name='f' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <select name="select_lend_book[]" multiple="multiple" style="font-size:25px;height:200px;width:400px;">
                <?php
                    $conn = mysql_connect('localhost','root','');
                    if (!$conn) {
                        die('Connect MySql Error');
                    }
                    mysql_select_db('library',$conn);
                    $sql="select Id,BookName from book";
                    $res=mysql_query($sql);
                    echo "所还图书：<br>";
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["Id"]."'>".$row["BookName"]."</option>";
                    }
                 ?>
            </select>
            <h3 style="font-family:黑体">还书者：</h3>
            <select name="select_lend_reader" style="font-size:25px;width:400px;">
                <?php
                    $sql="select distinct UserName from lend";
                    $res=mysql_query($sql);
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["UserName"]."'>".$row["UserName"]."</option>";
                    }

                 ?>
            </select>
            <strong>归还日期</strong>
            <input type="date" name="return_date" value="<?php echo date("Y-m-d",time()); ?>">
            <input type="submit" name="submit" value="确定">
        </form>
    </body>
</html>
