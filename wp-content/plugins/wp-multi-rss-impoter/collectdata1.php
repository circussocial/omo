<?php 
ini_set('display_errors',0);

	 //include('../../../wp-load.php');
	//require_once('/public_html/puneet/OMO/wp-includes/feed.php'); 
	require ( ABSPATH . 'wp-includes/feed.php');
	


  
	
function text_encode($str)
{
	$str=ltrim(rtrim($str));
	$str= mysql_real_escape_string($str);

	return $str;
}

function wp_cron_feeds(){
	
	global $wpdb;
	 $cattable= $wpdb->prefix."wp_multi_rss_category";
	$table1=  $wpdb->prefix."multi_rss_feeds"; 
	$table2=$wpdb->prefix."multi_rss_feeds_data";
	$query1="select * from $cattable order by name";
	
	if(sizeof($sql)>0)
	{
		foreach($sql as $maincat)
		{

			$maincatId=$maincat->MCID;
			$inc=trim($maincat->inc);
			$exclude=trim($maincat->excl);
			if($inc && $exclude)
			{
				
			}
			else
			{
				if($inc)
				{
					$query2="select * from $table1 where mcatId=$maincatId order by catId";

					$sql2=$wpdb->get_results($query2);

					if(sizeof($sql2)>0)

					{

						foreach($sql2 as $feedname)

						{



							$feedurl=$feedname->url;

							$catId=$feedname->catId;	

							$mcat=$feedname->cat;

							if($mcat != "facebook")

							{

							$feed = fetch_feed($feedurl);

							

								

								$maxfeed=10000;

								

								for ($i=1;$i<=$maxfeed;$i++)

									{

										

										 $item = $feed->get_item($i);

										 if (empty($item))	continue;

										  $title=htmlentities($item->get_title());

										 $link=addslashes(htmlentities($item->get_link()));

										 $content=addslashes(htmlentities($item->get_content()));

										 $image=addslashes(urlencode($item->get_enclosure()->get_thumbnail()));

										 $mediaImage=addslashes(urlencode($item->get_enclosure()->get_link()));	

										$incarray=explode(",",$inc);

										

										foreach($incarray as $minc)

										{

										$substr=strchr(strtolower($content),strtolower($minc));

										 if(strlen($substr))

											{

									$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);

									if(sizeof($checksql))

									{

									}

									else

									{

												

												$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";

											$insert_query.="values('$title','$link','$content',$catId,'$image','0','0','$mcat',$maincatId,now())";				

											$insert_sql=$wpdb->query($insert_query);

									}

											}

											else

											{

											

											}

										}

									}

							}

							else

							{
								if($feedurl)
								{
								$urlcontent=file_get_contents($feedurl);

								$json=json_decode($urlcontent);

								$maindata=$json->data;

								if(sizeof($maindata)>0)

								{

								foreach($maindata as $value)

									{

										$title=text_encode($value->from->name);

										$content=text_encode($value->message);
										$link=urlencode($value->link);
										$picture=urlencode($value->picture);

										$created_time=$value->created_time;

										$incarray=explode(",",$inc);

										foreach($incarray as $minc)

										{

										$substr=strchr(strtolower($content),strtolower($minc));

										if(strlen($substr))

											{

									$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);

									if(sizeof($checksql)>0)

									{

									}

									else

									{

												

												$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";
											$insert_query.="values('$title','$link','$content',$catId,'$picture','0','0','$mcat',$maincatId,now())";				
											$insert_sql=$wpdb->query($insert_query);
									}
											}

											else

											{

											

											}

										}

									}

								}

							}
							}
						}

					}

				

				}

				elseif($exclude)

				{

					 $query2="select * from $table1 where mcatId=$maincatId order by catId";

					

					

					$sql2=$wpdb->get_results($query2);
					
					if(sizeof($sql2)>0)

					{

							

						foreach($sql2 as $feedname)

						{

							$catId=$feedname->catId;						

							$feedurl=$feedname->url;

							$mcat=$feedname->cat;

							if($mcat != "facebook")

							{

							

							$feed = fetch_feed($feedurl);
							$maxfeed=10000;
							for ($i=1;$i<=$maxfeed;$i++)
									{
										 $item = $feed->get_item($i);
										 if (empty($item))	continue;
										 $title=htmlentities($item->get_title());
										 $link=addslashes(htmlentities($item->get_link()));
										 $content=addslashes(htmlentities($item->get_content()));
										 $image=addslashes(urlencode($item->get_enclosure()->get_thumbnail()));
										 $mediaImage=addslashes(urlencode($item->get_enclosure()->get_link()));	
    									 $excludearray=explode(",",$exclude);

											

											foreach($excludearray as $exc)

											{

										 $substr=strchr(strtolower($content),strtolower($exc));

										 

										 if(strlen($substr))

											{

												

											}

											else

											{

												$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);

									

									if(sizeof($checksql)>0)

									{

									}

									else

									{

											$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";

											$insert_query.="values('$title','$link','$content',$catId,'$image','0','0','$mcat',$maincatId,now())";				

											$insert_sql=$wpdb->query($insert_query);

									}

											}

											}

									}

							}

							else

							{
								if($feedurl)
								{
								$urlcontent=file_get_contents($feedurl);
								$json=json_decode($urlcontent);
								$maindata=$json->data;

								if(sizeof($maindata)>0)

								{

								foreach($maindata as $value)

									{

										$title=text_encode($value->from->name);
										$content=text_encode($value->message);
										$link=urlencode($value->link);
										$picture=urlencode($value->picture);
										$created_time=$value->created_time;
										
										$incarray=explode(",",$exclude);
										foreach($incarray as $minc)
										{
											
										$substr=strchr(strtolower($content),strtolower($minc));
										
										if(strlen($substr))
											{}
											else
											{
									$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);
									if(sizeof($checksql)>0)

									{

									}

									else

									{

											$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";
											$insert_query.="values('$title','$link','$content',$catId,'$picture','0','0','$mcat',$maincatId,now())";				
											$insert_sql=$wpdb->query($insert_query);

									}
								}

										
										}
									}

								}

							}
							}
						}

					}

				}

				else

				{

					

					

					$query2="select * from $table1 where mcatId=$maincatId order by catId";

					$sql2=$wpdb->get_results($query2);

					if(sizeof($sql2)>0)

					{

						foreach($sql2 as $feedname)

						{

							$feedurl=$feedname->url;

							$mcat=$feedname->cat;

							$catId=$feedname->catId;	

							if($mcat!="facebook")

							{

							  $feed = fetch_feed($feedurl);

							

							if (!is_wp_error( $feed ) ){

								$maxfeed=10000;

							

								for ($i=1;$i<=$maxfeed;$i++)

									{

										 $item = $feed->get_item($i);

										 

										 if (empty($item))	continue;

										 

										 $title=htmlentities($item->get_title());

										 $link=addslashes(htmlentities($item->get_link()));

										 $content=addslashes(htmlentities($item->get_content()));

										 $image=addslashes(urlencode($item->get_enclosure()->get_thumbnail()));

										 $mediaImage=addslashes(urlencode($item->get_enclosure()->get_link()));	

										$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);

									if(sizeof($checksql)>0)

									{

									}

									else

									{

												$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";

											$insert_query.="values('$title','$link','$content',$catId,'$image','0','0','$mcat',$maincatId,now())";				

											$insert_sql=$wpdb->query($insert_query);

											

									}

									}

							}

							}else

							{

							
							if($feedurl)
							{
																

								$urlcontent=file_get_contents($feedurl);

								$json=json_decode($urlcontent);

								$maindata=$json->data;

								

								

								

								if(sizeof($maindata)>0)

								{

								foreach($maindata as $value)

									{

										

										$title=text_encode($value->from->name);
										$content=text_encode($value->message);										
									    $link=urlencode($value->link);
										$picture=urlencode($value->picture);
										$created_time=$value->created_time;
		$checkquery="select * from $table2 where feedtitle='$title' and feedLink='$link' and feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";

									$checksql=$wpdb->get_results($checksql);

									if(sizeof($checksql)>0)

									{

									}

									else

									{

												

												$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";

											$insert_query.="values('$title','$link','$content',$catId,'$picture','0','0','$mcat',$maincatId,now())";				

											$insert_sql=$wpdb->query($insert_query);

									}
							}
					}
				}
							}
			}
		}
	}
}

		}

	}


}
wp_cron_feeds();

function wp_cron_feeds_delete()
{
	global $wpdb;
		$table2=$wpdb->prefix."multi_rss_feeds_data"; 
	
	
			 $delquery1="select feedId from $table2 order by createdon DESC limit 0,500";
			$delsql1=$wpdb->get_results($delquery1);
			$count=0;
			foreach($delsql1 as $msql)
			{
				$delidarray[$count]=$msql->feedId;
				$count++;
			}
		
			if($count>=500)
			{
			$implodearray=implode(",",$delidarray);
			 $delquery2="delete from $table2 where feedId not in ($implodearray)"; 
			$delsql2=$wpdb->query($delquery2);
			}
}

?>

<p>Data Retrieved Successfully.</p>