<?php
/*
* 	读取json
*/
$file=fopen("data.json","r") or exit("Unable to open file!");
$jsonData = fread($file,filesize("data.json"));
$data = json_decode($jsonData);
echo "截止".$data->date.",共有".$data->count."位访客";
$count = $data->count + 1; 
fclose($file);
/*
*	写文件
*/
$file=fopen("data.json","w") or exit("Unable to open file!");
$data = array('count'=>$count,
				'date'=>date("Y-m-d H:i:s"),
				);
$jsonData = json_encode($data);
fwrite($file, $jsonData);
fclose($file);
?>