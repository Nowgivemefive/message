<?
/*
*	登录验证
*/
include_once("dbcon.php");
$user = $_POST['username'];
$pass = $_POST['password'];

if(!isset($user,$pass)){
	echo "用户名或密码不允许为空";
	sleep(3000);
	header("location:../login.php");
}else{
	$sql = "SELECT uid FROM infomation where uid =".$user." AND password = ".$pass;
	$res = mysqli_query($conn,$sql);
	if(mysqli_fetch_array($res)){
		session_start();
		$_SESSION['uid'] = $user;
		$sql = "SELECT name,sex,authority from infomation where uid = $user";
		$res = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($res);
		$_SESSION['name'] = $row["name"];
		$_SESSION['sex'] = $row["sex"];
		$_SESSION['authority'] = $row["authority"];
		echo "<script>console.log(\"Login success\")</script>";
		header("location:../index.php");
	}else{
		echo "<script>console.log(\"Login failed\")</script>";
	}
}