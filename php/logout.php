<?
/*
*	销毁SESSION 
*/
include_once("dbcon.php");
session_start();
if(isset($_SESSION['name'])){
	session_unset();//free all session variable
    session_destroy();
	mysqli_close($conn);
    header('location:../index.php');
}else{
	echo "注销失败稍后重试";
}