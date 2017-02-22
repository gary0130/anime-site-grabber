<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1"/>
<title>php練習</title>
<style>
a {
	color: #963;
}
</style>
</head>

<body>
<?php
/*-----------------
核心版本
能夠連到真實連結
20170222
by gary ctsh
-----------------*/

//使用者設定
//設定來源(僅限固定格式)
$url = "http://jac-animation-net.blogspot.tw/";//取得連結
//設定最大搜尋時間
$search_time = 180;
//搜尋等級
//0:表層(沒啥用，耗時短)
//1:第二層(直接連結到動畫列表，耗時長)
//2:列表層(直接抓取列表，耗時超長)
//
$lv = 1;





ini_set("max_execution_time", $search_time);//設定搜尋時間限制。注意:搜尋需要大量時間

$page_content = file_get_contents($url);
eregi("<h2>動漫列表</h2>(.*)</ul>[\n]<div",$page_content,$res);//最新版php不支援

//新版支援用preg_match分析，但目前有bug，求大大修正
//注意!!1.記得特殊符號要轉譯2.preg_match中"."不包括換行符，在/後面加s以解決此問題
//preg_match("/<h2>動漫列表<\/h2>(.*?)?l>$/s",$page_content,$res);

//echo $res[1];//印出第一層測試


$times=0;$url2;$res2;
preg_match_all("/href='(.*)'/",$res[1],$url2);//網址
preg_match_all("/'>(.*)</",$res[1],$res2);//動畫名
$howmuch=(count($url2, 1))/2-1;//計算目標數量
echo "更新時間:".date("Y-m-d")."</br> \n";
echo "列表總數=".$howmuch."</br>";
echo "\n";


//print_r($url2);


//dev($url2[1][5]);

while($times<$howmuch){
	//印出網址與名稱
	if($lv ==0){
			//表層
			echo "<a href='".$url2[1][$times]."'>".($times+1).".".$res2[1][$times]."</a></br>";
		}elseif($lv == 1){
			//第二層
			nextlv($url2[1][$times],$res2[1][$times],$times);
			
		}else{
			echo "搜尋層級錯誤";
			break;
	}
	//echo $url2[1][$times].">".$res2[1][$times]."</br>";//舊版
	$times=$times+1;
}

function nextlv($a,$b,$t){
	//搜尋第二層
	//樣式設計
	global $lv;
	$second_url = file_get_contents($a);
	preg_match_all("/href='(.*)' title='.*閱讀更多/",$second_url,$url3);//抓取真實連結
	if($lv == 1){
			echo "<li><a href='".$url3[1][0]."'>".($t+1).".".$b."</a><ul>"."</ul></li></br>";//輸出格式
			echo "\n";
			//echo "<a href='".$url3[1][0]."'>".($t+1).".".$b."</a></br>";//舊的
		}elseif($lv == 2){
	}
}

function dev($d){
	//開發測試區
	//<h3 class='post-title entry-title' itemprop='name'>
	
}



?>
<p align="center">網頁爬蟲by gary</p>
</body>
</html>