<?
/*
*	实现分页功能
*/
session_start();
include_once("dbcon.php");
$tablename = 'message'; //表名

$primary_key = 'uid';

$item = 6; //每行显示的条数
if($_POST['select_func'] == 1){
	$query_item_sql = "select count($primary_key) from $tablename";
}else if($_POST['select_func'] == 3){
	$query_item_sql = "select count($primary_key) from $tablename where uid = ".$_SESSION['uid'];
}
$result = mysqli_query($conn,$query_item_sql);
$rownum = mysqli_fetch_array($result);
$page_num = floor( $rownum[0] / $item + 0.5); 
if(	$page_num == 0 ){
	$page_num = 1;
}
$select_page_num = $_POST['select_num']; //需前端传递参数
if($select_page_num > $page_num ){
	echo "";
	exit;
}
$start_num = $item * ($select_page_num - 1);
if($_POST['select_func'] == 1){
	$query_sql = "SELECT * FROM message LEFT OUTER JOIN comment ON message.mid = comment.comment_mid ORDER BY time DESC limit $start_num,$item";
}else if($_POST['select_func'] == 3){
	$query_sql = "SELECT * FROM message WHERE UID = ".$_SESSION['uid']." ORDER BY time DESC limit $start_num,$item";
	//echo $query_sql;
}
/*
$comment_sql = "SELECT * FROM comment";
$res = mysqli_query($conn,$comment_sql);
*/
$res = mysqli_query($conn,$query_sql);
$message[0] = array('page_num'=> $page_num);
$i = 1;
while(($row = mysqli_fetch_array($res)) > 0){
	if($message[$i - 1].mid == $row["mid"]){
		$temp = array('comment_id'=>$row['comment_id'],
							'comment_uid'=>$row['comment_uid'],
							'comment_name'=>$row['comment_name'],
							'comment_time'=>$row['comment_time'],
							'comment_content'=>$row['comment_content']
		); 
	}
	$message[$i] = array('subject'=>$row["subject"],
							'content'=>$row["content"],
							'name'=>$row["name"],
							'time'=>$row["time"],
							'uid'=>$row["uid"],
							'mid'=>$row["mid"]
							'comment'=>$
							);
	$i++;
}
$messToIndex = json_encode($message);
echo $messToIndex;



