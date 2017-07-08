<?php
include '../checklogin/check_login.php';
login_filter('M');

if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["add"])) {
    $bookid=$_POST["book_id"];
    $name=$_POST["book_name"];
    $author=$_POST["author"];
    $stock=$_POST["stock"];
    $conn=mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error.............');
    }
    mysql_select_db('library',$conn);

    $sql="insert into book(Id,BookName,Author,Stock)values('$bookid','$name','$author','$stock')";
    mysql_query($sql);
    if (mysql_affected_rows()==1) {
        echo "添加成功！！图书:$name";
    }else {
        echo "Error to add new book. affected_rows:".mysql_affected_rows();
    }

}else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["alter"])) {
    $id=$_POST["select_alter_book"];
    $name=$_POST["alter_name"];
    $aut=$_POST["alter_author"];
    $stk=$_POST["alter_stock"];
    $conn=mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error.............');
    }
    mysql_select_db('library',$conn);
    $sql="update book set BookName='$name' where Id='$id'";
    mysql_query($sql);
    $sql="update book set Author='$aut' where Id='$id'";
    mysql_query($sql);
    $sql="update book set Stock='$stk' where Id='$id'";
    mysql_query($sql);
    echo "修改成功！！Book:$name";

}else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["del"])) {
    $bookid_arr=$_POST["select_book"];
    $conn=mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error.............');
    }
    mysql_select_db('library',$conn);
    for($i=0;$i<count($bookid_arr);$i++){
        $sql="delete from book where Id='".$bookid_arr[$i]."'";
        mysql_query($sql);
        $num_del_u=mysql_affected_rows();
        $sql="delete from lend where BookId='".$bookid_arr[$i]."'";
        mysql_query($sql);

        if ($num_del_u==1) {
            echo "删除成功：$bookid_arr[$i]";
        }else {
            echo "error to delete:$bookid_arr[$i] affected_rows:".$num_del_u.":".$num_del_l."<br>";
        }
    }

    mysql_close($conn);
}


 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>图书管理</title>
        <script type="text/javascript">
            function check_input() {
                if (document.f_add.bookid.value == "" ) {
                    alert('请填写图书编号！！');
                    return false;
                }
                if (document.f_add.book_name.value=="" || document.f_add.author.value=="") {
                    alert('请完善图书信息！！');
                    return false;
                }
                return true;
            }

            function change_alter_select(str) {
                var str_arr=str.split(":");
                document.f_alter.alter_name.value=str_arr[3];
                document.f_alter.alter_author.value=str_arr[5];
                document.f_alter.alter_stock.value=Number(str_arr[7]);
            }
        </script>
        <style media="screen">
            body{
                color: yellow;
                background-color: gray;
                margin: 20px;
                font-family: 黑体;
                font-size: 20px;
            }
            input[type='submit']{
                font-size: 20px;
                font-family: 黑体;
            }
            div#title{
                font-size: 40px;
                font-family: 黑体;
            }
            button{
                font-family: 黑体;
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <button type="button" name="back" onclick="location.href='http://localhost/1/DBDesign/manager.php'">返回</button><br>
        <div id="title">
            修改/删除/添加图书信息
        </div>
        <form name='f_add' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" onsubmit="return check_input();">
            图书编号： <input type="text" name="book_id" value="">
            书名： <input type="text" name="book_name" value="">
            作者： <input type="text" name="author" value="">
            库存： <input type="number" name="stock" value="10">
            <input type="submit" name="add" value="确定添加">
        </form><br><br>
        <form name='f_alter' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <select name="select_alter_book"
            style="font-size:25px;width:600px;" onchange="change_alter_select(this.options[this.selectedIndex].text);">
                <?php
                    $conn = mysql_connect('localhost','root','');
                    if (!$conn) {
                        die('Connect MySql Error');
                    }
                    mysql_select_db('library',$conn);
                    $sql="select * from book";
                    $res=mysql_query($sql);
                    echo "所有图书：<br>";
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["Id"]."'>书号:".$row["Id"].":书名:".$row["BookName"].":作者:".$row["Author"].":库存:".$row["Stock"]."</option>";
                    }
                 ?>
            </select><br>
            书名：
            <input type="text" name="alter_name" value="">
            作者：
            <input type="text" name="alter_author" value="">
            库存：
            <input type="number" name="alter_stock" value="10">

            <input type="submit" name="alter" value="修所选图书">
        </form><br><br>
        <form name='f_del' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <select name="select_book[]" multiple="multiple" style="font-size:25px;height:150px;width:400px;">
                <?php
                    $conn = mysql_connect('localhost','root','');
                    if (!$conn) {
                        die('Connect MySql Error');
                    }
                    mysql_select_db('library',$conn);
                    $sql="select Id,BookName from book";
                    $res=mysql_query($sql);
                    echo "所有图书：<br>";
                    while ($row=mysql_fetch_array($res)) {
                        echo "<option value='".$row["Id"]."'>".$row["BookName"]."</option>";
                    }
                 ?>
            </select>

            <input type="submit" name="del" value="删除所选图书">
        </form>
    </body>
</html>
