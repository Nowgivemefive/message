<?
$comment_uid = $_POST['comment_uid'];
$comment_mid = $_POST['comment_mid'];
$comment_name = $_POST['comment_name'];
$comment_content = $_POST['comment_content'];

if(isset($_POST['comment_parent_cid'])){
	$insert_comm_sql = "INSERT INTO comment (comment_mid,comment_name,comment_uid,comment_content,comment_parent_cid) 
					VALUES (".$comment_mid.",'".$comment_name."',".$comment_uid.",'".$comment_content."',".$comment_parent_cid.")";
	echo $insert_comm_sql;
}else{
	$insert_comm_sql = "INSERT INTO comment (comment_mid,comment_name,comment_uid,comment_content) 
					VALUES (".$comment_mid.",'".$comment_name."',".$comment_uid.",'".$comment_content."')";
}
include_once("dbcon.php");
if(mysqli_query($conn,$insert_comm_sql)){
	echo 'true';
}else{
	echo 'false';
}


