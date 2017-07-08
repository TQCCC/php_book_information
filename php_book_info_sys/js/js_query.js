
var xmlHttp;

function showResult(str) {
    if (str.length == 0) {
        document.getElementById('query_book_result').innerHTML="";
        document.getElementById('query_book_result').style.border="0px";
        return;
    }

    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        document.getElementById('query_book_result').innerHTML="Your Browser does not support HTTP request";
        return;
    }

    var mtd=document.query_book.query_method.value;
    var url="query/query_book.php";
    url=url+"?q="+str+"& m="+mtd;
    xmlHttp.onreadystatechange=stateChanged;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function GetXmlHttpObject() {
    var xmlHttp=null;
    try {
        xmlHttp=new XMLHttpRequest();
    } catch (e) {
        try {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlHttp;
}

function stateChanged() {
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
        document.getElementById("query_book_result").innerHTML=xmlHttp.responseText;
        document.getElementById("query_book_result").style.border="1px solid #A5ACB2";
    }
}
