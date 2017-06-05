<?
$ip = $_SERVER["REMOTE_ADDR"];
echo $ip.'<br/>';
$last_login_time = date("Y-m-d H:i:s");
echo $last_login_time."<br/>";
echo $_SERVER['REQUEST_URI']."<br/>";
echo $_SERVER['HTTP_HOST']."<br/>";
echo "当前请求URL为: http://".$_SERVER['HTTP_HOST']."/".$_SERVER['REQUEST_URI']."<br/>";
$url =  "http://".$_SERVER['HTTP_HOST']."/".$_SERVER['REQUEST_URI'];
print_r(pathinfo($url));
function is_local(){
	if( $_SERVER['HTTP_HOST'] == '127.0.0.1'){
		echo "yes";
	}else{
		echo "no";
	}
}