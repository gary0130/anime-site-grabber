<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>php練習</title>
<style>
a{
	color:#963;
	
}
dir{
	float:left;
}

</style>
</head>

<body>
<p>動畫網站爬蟲</p>
  <?php
$url = "http://jac-animation-net.blogspot.tw/";//取得連結
$page_content = file_get_contents($url);
eregi("<h2>動漫列表</h2>(.*)</ul>[\n]<div",$page_content,$res);//最新版php不支援

//新版支援，但目前有bug，求大大修正
//用preg_match分析
//注意!!1.記得特殊符號要轉譯2.preg_match中"."不包括換行符，在/後面加s以解決此問題
//preg_match("/<h2>動漫列表<\/h2>(.*?)?l>$/s",$page_content,$res);

//echo $res[1];//印出第一層測試


$times=0;
preg_match_all("/href='(.*)'/",$res[1],$url2);
$howmuch=(count($url2, 1))/2-1;//計算目標數量
echo "列表總數=".$howmuch."</br>";
//print_r($url2);
while($times<$howmuch){
	//印出網址與名稱
	preg_match_all("/href='(.*)'/",$res[1],$url2);
	preg_match_all("/'>(.*)</",$res[1],$res2);
	design($url2[1][$times],$res2[1][$times]);
	//echo $url2[1][$times].">".$res2[1][$times]."</br>";
	$times=$times+1;
}

function design($a,$b){
	//樣式設計
	echo "<a href='".$a."'>".$b."</a></br>";
	$second_url = file_get_contents($a);
	preg_match("/href='(.*)' title='$b/",$second_url,$c);
	echo $c[1];
}



?>

<p>html end</p>
</body>
</html>