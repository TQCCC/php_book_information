<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
        <title>Library Page</title>
        <link rel="stylesheet" href="css/css_index.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body style="height:700px">

        <div class="header">
            <h1> Library Manager Page </h1>
        </div>

        <div class="middle">
            <div class="middle_left">
                <?php
                    include 'checklogin/check_login.php';
                    session_start();
                    if ($_SESSION["reader_user"]) {    //若读者已经登陆
                        $url="http://localhost/1/DBDesign/index.php";
                        echo "<h1>LOGIN.............</h1>";
                        echo "<SCRIPT LANGUAGE='JavaScript'>";
                        echo "location.href='$url'";
                        echo "</SCRIPT>";
                    }
                    //检查管理员是否登录
                    check_login('M');
                 ?>
            </div>
            <div class="middle_right">
                <div class="search_book">
                    <form style="font-family:黑体;font-size:25px;" name="query_book">
                        书目查询：
                        <select name="query_method"
                        style="font-size:20px;font-family:黑体" onchange="showResult(document.getElementById('query_book').value)">
                            <option value="title" selected="true">题名</option>
                            <option value="author" >作者</option>
                            <option value="id">书号</option>
                        </select>
                        <input type="text" id="query_book" value="" size="30" onkeyup="showResult(this.value)" style="font-size:20px;"><br>
                        查询结果：<br>
                        <div id="query_book_result" style="float:left"></div>
                        <br><br>
                    </form>
                </div><br><br>

                <?php
                    session_start();
                    if ($_SESSION["manager_user"]) {

                        echo "<div class='manager_function' style='margin-left:100px;''>
                            <h1>
                                <div style='background-color:gray;opacity:0.7'>
                                <a href='lend/lend.php'>读者借书</a>
                                <a href='return/return.php'>读者还书</a>
                                <a href='alter/alter_book.php'>图书管理</a>
                                <a href='alter/alter_reader.php'>读者管理</a><br><br>
                                </div>
                                <a>读者借阅情况：</a><br>
                                <div style='overflow-y:scroll;height:150px; background-color:gray;opacity:0.9'>";
                                include 'lend/query_lend.php';
                                echo "</div></h1></div>";
                    }else {
                        echo "<h2 style='font-family:黑体'>";
                        echo "管理员请登录";
                        echo "</h2>";
                    }

                 ?>

            </div>
        </div>

        <div class="bottom">
            <h1 style="font-size:30px;font-family:fantasy;text-align:center">@Copyright: Designer: Tqc and Liu Xuan</h1>
        </div>

    </body>
    <script src="js/js_query.js" charset="utf-8"></script>
</html>
