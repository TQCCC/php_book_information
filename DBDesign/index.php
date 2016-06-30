<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
        <title>Library Page</title>
        <link rel="stylesheet" href="css/css_index.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body style="height:700px">
        <div class="adv" id="adv">
            <a href="#" onclick="closeadv();" style="font-family:fantasy; float:right;">CLOSE</a>
            <h2 style="font-family:fantasy; font-size:40px;text-align: center;">
                <a href="#" target="_blank"> 广告位<br>招租</a>
            </h2>
        </div>

        <div class="header">
            <h1> Library HomePage </h1>
        </div>

        <div class="middle">
            <div class="middle_left">
                <?php
                    include 'checklogin/check_login.php';
                    session_start();
                    if ($_SESSION["manager_user"]) {    //若管理员已经登陆
                        $url="http://localhost/1/DBDesign/manager.php";
                        echo "<h1>LOGIN.............</h1>";
                        echo "<SCRIPT LANGUAGE='JavaScript'>";
                        echo "location.href='$url'";
                        echo "</SCRIPT>";
                    }
                    check_login('R');
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
                        <div id="query_book_result" style="float:left">

                        </div>
                        <br><br>
                    </form><br>

                    <h2 style="font-family:黑体;font-size:25px">借阅信息:</h2>
                    <?php
                        include 'query/query_reader_lend.php';
                     ?>

                </div>

            </div>
        </div>

        <div class="bottom">
            <h1 style="font-size:30px;font-family:fantasy;text-align:center">@Copyright: Designer: Tqc and Liu Xuan</h1>
        </div>

    </body>
    <script src="js/js_index.js" charset="utf-8"></script>
    <script src="js/js_query.js" charset="utf-8"></script>
</html>
