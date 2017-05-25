<?
/*
*	连接数据库
*/
$servername = "localhost";
$username = "root";
$password = "admin@155";
 
// 创建连接
$conn = mysqli_connect($servername, $username, $password);
mysqli_select_db($conn,"userinfo");

// 检测连接
if (!$conn) {
    die("<script>console.log(\"Database connection failed:".mysqli_connect_error()."\")</script>");
}
?>