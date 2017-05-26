<?
/*
*	实现分页功能
*/

include_once("dbcon.php");
$tablename = 'message'; //表名

$primary_key = 'uid';

$item = 6; //每行显示的条数
$query_item_sql = "select count($primary_key) from $tablename";
$result = mysqli_query($conn,$query_item_sql);
$rownum = mysqli_fetch_array($result);
$page_num = floor( $rownum[0] / $item + 0.5); 
$select_page_num = $_POST['select_num']; //需前端传递参数
if($select_page_num > $page_num ){
	echo "";
	exit;
}
$start_num = $item * ($select_page_num - 1);
$query_sql = "SELECT uid,mid,subject,name,content,time FROM message ORDER BY time DESC limit $start_num,$item";
$res = mysqli_query($conn,$query_sql);
$message[0] = array('page_num'=> $page_num);
$i = 1;
while(($row = mysqli_fetch_array($res)) > 0){
	$message[$i] = array('subject'=>$row["subject"],
							'content'=>$row["content"],
							'name'=>$row["name"],
							'time'=>$row["time"],
							'uid'=>$row["uid"],
							'mid'=>$row["mid"]
							);
	$i++;
}
$messToIndex = json_encode($message);
echo $messToIndex;



