<?
/*
*	用户管理
*/

include_once("dbcon.php");
$item = 35; //每页显示的条数
$item_sql = "SELECT count(uid) FROM infomation";
$res = mysqli_query($conn,$item_sql);
$row = mysqli_fetch_array($res);
$page_num = floor( $row[0] / $item + 0.5);
$userinfo[0] = array('page_num'=>$page_num);//总页数 
$select_page_num = $_POST['select_num']; //需前端传递参数
if($select_page_num > $page_num ){
	echo "";
	exit;
}
$start_num = $item * ($select_page_num - 1);
$show_user_sql = "SELECT uid,name,sex,authority,create_time FROM infomation limit $start_num,$item";
$res = mysqli_query($conn,$show_user_sql);

$i = 1;
while(($row = mysqli_fetch_array($res)) > 0){
	$userinfo[$i] = array(
							'uid'=>$row["uid"],
							'name'=>$row["name"],
							'sex'=>$row["sex"],
							'authority'=>$row["authority"],
							'create_time'=>$row["create_time"]
							);
	$i++;
}
$userinfo = json_encode($userinfo);
echo $userinfo;