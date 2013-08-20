<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @@version@@ @@author@@ 
 */

/* get the path to the wp-config.php */


/* get db connection */



require '../../../wp-config.php';


/* check db connection and give a success message */

/* write a small select query */



?>
<?php 
ob_start();
	
	$host=DB_HOST;
	$user=DB_USER;
	$pass=DB_PASSWORD;
	
	$db=DB_NAME;
	

	$con=mysql_connect($host,$user,$pass) or die("Error :-".mysql_error());

	mysql_select_db($db,$con) or die("Error :-".mysql_error());
	
header('Content-Type: text/html; charset=utf-8');
	$cattable	=	"wp_multi_rss_category";
	$table1		=	"wp_multi_rss_feeds"; 
	$table2		=	"wp_multi_rss_feeds_data";
	//$table2		=	"wp_multi_rss_feeds_data_2";
	$query1		=	"select * from $cattable order by name";
	
	
	
	//$sql=$wpdb->get_results($query1);
	$sql1=mysql_query($query1);	
	$i=0;
        while ($row = mysql_fetch_object($sql1)) {
			
			$sql[$i] = $row;
			   $i++;  
			}
			
		echo "<pre>";	
require_once('twitter.php');	
	
function text_encode($str)
{
	$str=ltrim(rtrim($str));
	$str= mysql_real_escape_string($str);

	return $str;
}	
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
				
				if($inc){ echo '';}
				elseif($exclude){echo '';}
				else{
					
				    $query2="select * from $table1 where mcatId=$maincatId order by catId";
					$resultQuery=mysql_query($query2);	
					$a=0;
					while ($row = mysql_fetch_object($resultQuery)) {
						
						$sql2[$a] = $row;
						   $a++;  
						}
						 print_r($sql2); 	
						if(sizeof($sql2)>0)		
							{
								foreach($sql2 as $feedname)
									{
			
										$feedItemName = $feedname->name;
										$feedurl=$feedname->url;
			
										$mcat=$feedname->cat; 
			
										$catId=$feedname->catId;
										
											switch($mcat)
											{
												case 'twitter_search':
												
												          echo '<br>'.$feedItemName;
														 
														  											
															$bearer_token = get_bearer_token(); // get the bearer token
															
															$data = search_for_a_term($bearer_token, $feedItemName); //  search for the work 'test'										
															
															$xdata = json_decode($data,true);
														
															$i=1;
															if(!empty($xdata)){
																
														    foreach($xdata['statuses'] as $x){
															
																															
																$title=text_encode($x['user']['name']);
																$content=text_encode($x['text']);										
																$link=urlencode($x['user']['entities']['url']['urls'][0]['url']);
																$picture=urlencode($x['user']['profile_image_url']);
																$created_time=$x['user']['created_at'];
																
																$checkquery="select * from $table2 where feedDesc='$content' and feedCat=$catId and cat='$mcat' and mcatId=$maincatId";
																
																$resultcheckquery=mysql_query($checkquery);	
																	$b=0;$checksql='';
																	while ($row = mysql_fetch_object($resultcheckquery)) {
																		
																		$checksql[$b] = $row;
																		   $b++;  
																		}
																		
																		if(!empty($checksql))
																		{	echo '<br>Feed Already exist';}
																		else
																			{
																					$insert_query="insert into $table2(feedtitle,feedLink,feedDesc,feedCat,feedImgThumb,isSticky,isHighlight,cat,mcatId,createdon)";

											$insert_query.="values('$title','$link','$content',$catId,'$picture','0','0','$mcat',$maincatId,now())";				

																			$twiterResulr = mysql_query($insert_query);
																				if($twiterResulr){
																					echo '<br>Successful Insert ';
																				}else
																				{
																					echo '<br>Date Not Insert';
																				}
																			}

												
																}
															}
													break;
													
													
												
											}										
											
										}
							}
					
					}
				
		    }
			
			
		}
	}
			
?>
