<?
/*
*	注册新用户
*/

include_once("dbcon.php");
$name = $_POST['name'];
$user = $_POST['username'];
$pass = $_POST['password'];
$sex = 	$_POST['sex'];
if(isset($name,$user,$pass,$sex)){
	$sql = "INSERT INTO infomation (uid, name, password, sex)
VALUES ($user,'$name','$pass','$sex')";

if (mysqli_query($conn, $sql)) {
    echo "Register success.";
	session_start();
	$_SESSION['uid'] = $user;
	$_SESSION['name'] = $name;
	$_SESSION['sex'] = $sex;
	$_SESSION['conn'] = $conn;
	$last_login_ip = $_SERVER['REMOTE_ADDR'];
	$last_login_time = date("Y-m-d H:i:s");
	$update_user_sql = "UPDATE infomation SET last_login_ip = '".$last_login_ip
	."', last_login_time= '".$last_login_time."' WHERE uid = ".$_SESSION['uid'];
	mysqli_query($conn,$update_user_sql);
	header("location:../index.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}