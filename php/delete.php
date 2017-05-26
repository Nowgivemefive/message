<?
/*
*	删除,验证
*/

session_start();
include_once("dbcon.php");
$mid = $_POST['mid'];
if($_SESSION['authority'] != 1){
	$sel_sql = "SELECT uid FROM message WHERE mid = $mid";
	$res = mysqli_query($conn,$sel_sql);
	$row = mysqli_fetch_array($res);
	$uid = $row["uid"];
	if($_SESSION['uid'] != $uid){
		echo "非法操作";
		exit;
	}
}

$del_sql = "DELETE FROM message WHERE mid = $mid";
mysqli_query($conn,$del_sql);
echo "删除成功";
