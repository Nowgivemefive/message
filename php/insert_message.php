<?
/*
*	插入留言
*/

session_start();
$mess = $_POST['message'];
if(isset($mess)){
	$subject = $mess['subject_mess'];
	$content = $mess['content_mess'];
	include_once("dbcon.php");
}else{
	echo "failed";
}

if(isset($_SESSION['name'])){
	//如果已经登录
	$name = $_SESSION['name'];
	$uid = $_SESSION['uid'];
	$sql = "INSERT INTO message (subject, content, name, uid, public) VALUES ('$subject','$content','$name','$uid','T')";
	if (mysqli_query($conn, $sql)) {
		echo "新记录插入成功";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}else{
	//未登录
	$sql = "INSERT INTO message (subject, content, name, uid, public) VALUES ('$subject','$content','匿名','888888','T')";
	if (mysqli_query($conn, $sql)) {
		echo "新记录插入成功";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	mysqli_close($conn);
}

