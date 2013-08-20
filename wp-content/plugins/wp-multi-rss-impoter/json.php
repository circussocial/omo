<?php
include('../../../wp-load.php');

/*$url="https://graph.facebook.com/search?q=rohit&type=post";
$urlcontent=file_get_contents($url);
$json=json_decode($urlcontent);
$maindata=$json->data;
foreach($maindata as $value)
{
	$title=$value->from->name;
	$desc=$value->message;
	$link=$value->link;
	$picture=$value->picture;
	echo $created_time=$value->created_time;
	echo "<Br/>";
	echo "----";
	echo "<Br/>";
	
}
*/
function text_encode($str)
{
	$str=ltrim(rtrim($str));
	$str=utf8_encode($str);
	$str=htmlentities($str);
	$str=addslashes($str);
	return $str;
}
$cattable=$wpdb->prefix."multi_rss_category";
$table1=  $wpdb->prefix . "multi_rss_feeds"; 
$table2=$wpdb->prefix."multi_rss_feeds_data";
$query="select * from $table1 where cat='facebook'";
$sql=$wpdb->get_results($query);
foreach($sql as $result)
{
	$catId=$result->catId;
	$maincatId=$result->mcatId;
	$mcat=$result->cat;
	$name=text_encode($result->name);
	$url=$result->url;
	$urlcontent=file_get_contents($url);
	$json=json_decode($urlcontent);
	$maindata=$json->data;
	
	foreach($maindata as $value)
		{
				$title=text_encode($value->from->name);
				$desc=text_encode($value->message);
				$link=urlencode($value->link);
				$picture=urlencode($value->picture);
				$created_time=$value->created_time;
	    	$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$desc' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";
			$checksql=$wpdb->get_results($checksql);
			if(sizeof($checksql)>0)
			{
				
			}
			else
			{
				$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";
				$insert_query.="values('$title','$link','$desc',$catId,'$picture','0','0','$mcat',$maincatId,'$created_time')";
				$insert_sql=$wpdb->query($insert_query);
				print_r($insert_sql);
			}
		}
	
}
?>
