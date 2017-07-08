<?php
    $conn = mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error');
    }
    mysql_select_db('library',$conn);
    $sql="select UserName,BookName,LendDate,ReturnDate,Output from lend,book where book.Id=lend.BookId";
    $res=mysql_query($sql);
    $num=mysql_num_rows($res);
    if ($num!=0) {
        echo "<h1 style='font-family:黑体;font-size:20px;'>";
        while ($row=mysql_fetch_array($res)) {
            echo "书名：".$row["BookName"];
            echo "借阅者：".$row["UserName"];
            echo "借出数量：".$row["Output"];
            echo "借出日期：".date("Y-m-d",strtotime($row["LendDate"]));
            if (strtotime($row["ReturnDate"])<=strtotime(date('Y-m-d',time()))) {
                echo "<strong style='color:red'>";
                echo "应还日期：".date("Y-m-d",strtotime($row["ReturnDate"]));
                echo "</strong>";
            }else {
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


 ?>
