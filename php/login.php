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
		$_SESSION['name'] = $row["name"]; //用户姓名
		$_SESSION['sex'] = $row["sex"]; //性别
		$_SESSION['authority'] = $row["authority"]; //权限
		$last_login_ip = $_SERVER['REMOTE_ADDR'];
		$last_login_time = date("Y-m-d H:i:s");
		$update_user_sql = "UPDATE infomation SET last_login_ip = '".$last_login_ip
		."', last_login_time= '".$last_login_time."' WHERE uid = ".$_SESSION['uid'];
		mysqli_query($conn,$update_user_sql);
		header("location:../userinfo.php");
	}else{
		echo "<script>console.log(\"Login failed\")</script>";
	}
}