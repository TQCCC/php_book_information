<?php
    $q = $_GET["q"];
    $query_method = $_GET["m"];
    $response = "";
    $conn = mysql_connect('localhost','root','');
    if (!$conn) {
        die('Connect MySql Error...');
    }
    mysql_select_db('library',$conn);
    $sql="select * from book";
    $res=mysql_query($sql);

    $num=mysql_num_rows($res);
    $hint="";

    switch ($query_method) {
        case 'title':
            while ($row=mysql_fetch_array($res)) {

                if (strtolower($q)==strtolower(substr($row["BookName"],0,strlen($q)))){

                    if ($hint==""){
                        $hint=$row["BookName"];
                    }else {
                        $hint=$hint.":".$row["BookName"];
                    }
                }

            }
            break;
        case 'author':
            $temp="";
            while ($row=mysql_fetch_array($res)) {

                if (strtolower($q)==strtolower(substr($row["Author"],0,strlen($q)))){
                    if ($hint==""){
                        $hint=$row["Author"];
                        $temp=$hint;
                    }else {
                        if($temp!=$row["Author"]){
                            $hint=$hint.":".$row["Author"];
                            $temp=$row["Author"];
                        }

                    }
                }

            }
            break;
        case 'id':
            while ($row=mysql_fetch_array($res)) {

                if (strtolower($q)==strtolower(substr($row["Id"],0,strlen($q)))){

                    if ($hint==""){
                        $hint=$row["Id"];
                    }else {
                        $hint=$hint.":".$row["Id"];
                    }
                }

            }
            break;
        default:
            break;
    }



    if ($hint=="") {
        $response="No suggestion";
    }else {
        $arr_res = explode(":",$hint);
        for ($i=0; $i < count($arr_res); $i++) {

            switch ($query_method) {
                case 'title':
                    $fin_res=mysql_query("select * from book where BookName='".$arr_res[$i]."'");
                    break;
                case 'author':
                    $fin_res=mysql_query("select * from book where Author='".$arr_res[$i]."'");
                    break;
                case 'id':
                    $fin_res=mysql_query("select * from book where Id='".$arr_res[$i]."'");
                default:
                    break;
            }
            while ($fin_row=mysql_fetch_array($fin_res)) {
                $response.="书名：".$fin_row["BookName"]."  作者：".$fin_row["Author"]." 库存：".$fin_row["Stock"]."<br>";
            }

        }

    }

    mysql_close($conn);
    echo $response;
 ?>
