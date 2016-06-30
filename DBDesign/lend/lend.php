<?php
include '../checklogin/check_login.php';
login_filter('M');

    if ($_SERVER["REQUEST_METHOD"]=="POST") {

        $bookid_arr=$_POST["select_lend_book"];
        $reader=$_POST["select_lend_reader"];
        $lend_date=$_POST["lend_date"];
        $return_date=$_POST["return_date"];

        $conn = mysql_connect('localhost','root','');
        if (!$conn) {
            die('Connect Mysql error..............');
        }
        mysql_select_db('library',$conn);

        if (count($bookid_arr)>1) {
            //读者借了多本书
            for($i=0;$i<count($bookid_arr);$i++){
                $sql="select * from lend where UserName='".$reader."' and BookId='".$bookid_arr[$i]."'";
                $res=mysql_query($sql);
                if (mysql_num_rows($res)>0) {
                    echo "该读者已借该书，图书代号：$bookid_arr[$i]，借出失败！！！<br>";
                }else {
                    $sql="insert into lend(BookId,UserName,Output,LendDate,ReturnDate)values('$bookid_arr[$i]','$reader','1','$lend_date','$return_date')";
                    mysql_query($sql);
                    $num_insert=mysql_affected_rows();

                    $sql="update book set Stock=Stock-1 where Id='$bookid_arr[$i]'";
                    mysql_query($sql);
                    $num_upt=mysql_affected_rows();

                    if($num_insert==1 && $num_upt == 1){
                        echo "借出$bookid_arr[$i]成功！！<br>";
                    }else {
                        echo "Error........";
                    }
                }

            }

        }else {
            $sql="select * from lend where UserName='".$reader."' and BookId='".$bookid_arr[0]."'";
            $res=mysql_query($sql);
            if (mysql_num_rows($res)>0) {
                echo "该读者已借该书，图书代号：$bookid_arr[0]，借出失败！！！<br>";
            }else {
                $sql="insert into lend(BookId,UserName,Output,LendDate,ReturnDate)values('$bookid_arr[0]','$reader','1','$lend_date','$return_date')";
                mysql_query($sql);
                $num_insert=mysql_affected_rows();

                $sql="update book set Stock=Stock-1 where Id='$bookid_arr[0]'";
                mysql_query($sql);
                $num_upt=mysql_affected_rows();

                if($num_insert==1 && $num_upt == 1){
                    echo "借出$bookid_arr[0]成功！！";
                }
            }


        }

    }

 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>借书</title>
        </head>
        <style media="screen">
            input[type='date']{
                font-size: 20px;
                font-family: 黑体;
            }
            button{
                font-size: 25px;
                font-family: 黑体;
                margin-bottom: 10px;
            }
            body{
                background-image: url("../img/11.jpg");
                margin: 20px;
                color: yellow;
            }
            input[type='submit']{
                font-size: 20px;
                font-family: 黑体;
            }
            div.title{
                position: absolute;
                left: 40%;
                top: 15%;
                width: 30;
                font-size: 70px;
                font-family: 幼圆;
                font-weight: bolder;
                opacity: 1.5;
            }
        </style>
    <body>
        <div class="title">
            借书
        </div>
        <button type="button" name="button" onclick="location.href='http://localhost/1/DBDesign/manager.php';">返回</button><br>
        <form name='f' class="lend" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

            <select name="select_lend_book[]" multiple="multiple" style="font-size:25px;height:200px;width:400px;">
                <?php
                    $conn = mysql_connect('localhost','root','');
                    if (!$conn) {
                        die('Connect MySql Error');
                    }
                    mysql_select_db('library',$conn);
                    $sql="select Id,BookName from book where Stock>0 ";
                    $res=mysql_query($sql);
                    echo "可借图书：<br>";
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["Id"]."'>".$row["BookName"]."</option>";
                    }
                 ?>
            </select>

            <h3 style="font-family:黑体">选择读者：</h3>
            <select name="select_lend_reader" style="font-size:25px;width:400px;">
                <?php
                    $sql="select distinct UserName from user where UserClass='R'";
                    $res=mysql_query($sql);
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["UserName"]."'>".$row["UserName"]."</option>";
                    }

                 ?>
            </select>
            <strong>借阅日期：</strong>
            <input type="date" name="lend_date" value="<?php echo date("Y-m-d",time());?>">


            <strong>应还日期(30天后)：</strong>
            <input type="date" name="return_date" value="<?php echo date("Y-m-d",strtotime('+30 day')); ?>">

            <?php
                mysql_close($conn);
             ?>
             <input type="submit" name="submit" value="确定">
        </form>

    </body>

</html>
