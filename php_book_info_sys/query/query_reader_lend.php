<?php
if ($_SESSION["reader_user"]) {
    $conn = mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error');
    }
    mysql_select_db('library',$conn);
    $sql="select BookName,LendDate,ReturnDate from lend,book where book.Id=lend.BookId and UserName='".$_SESSION["reader_user"]."'";
    $res=mysql_query($sql);
    $num=mysql_num_rows($res);
    if ($num!=0) {
        echo "<h1 style='font-family:黑体;font-size:20px;'>";
        while ($row=mysql_fetch_array($res)) {
            echo "书名：".$row["BookName"];
            echo "借出日期：".date("Y-m-d",strtotime($row["LendDate"]));
            if (strtotime($row["ReturnDate"])<=strtotime(date("y-m-d",time()))) {
                //若超过应还日期
                echo "<strong style='color:red'>";
                echo "应还日期：".date("Y-m-d",strtotime($row["ReturnDate"]));
                echo "</strong>";
            }else{
                echo "应还日期：".date("Y-m-d",strtotime($row["ReturnDate"]));
            }
            echo "<br>";
        }
        echo "</h1>";
    }else {
        echo "<h1>";
        echo "查无记录";
        echo "</h1>";
    }

}else {
    echo "<h3>";
    echo "（请登录）";
    echo "</h3>";
}

 ?>
