<?php /* Template Name: RSS Test */ ?>


<?php 
			//$url='http://instagram.com/tags/jaipur/feed/recent.rss';
			//$url='http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=ashishwd';
			//$url='http://search.twitter.com/search.atom?q=jaipur';
			//$url='http://news.google.com/?output=rss';
			$url='http://newsrss.bbc.co.uk/rss/newsonline_world_edition/americas/rss.xml';
			
			
	$feed = fetch_feed($url);
	
	echo "<pre>";
	echo "aashish";
	echo "<br >";
	echo $maxfeed= $feed->get_item_quantity(0);
	echo "<br >";
	
	if ($feedAuthor = $feed->get_author())
	{
		$feedAuthor=$feed->get_author()->get_name();
	}
	if($maxfeed >= 10 )
	{$maxfeed=10;
	}
	
	for ($i=1;$i<=$maxfeed;$i++){
			echo $i;echo "<br>";
			 $item = $feed->get_item($i);
			 
			  if (empty($item))	continue;
			  
			
			echo $item->get_title();
		   echo "<br>";
			echo $item->get_link();
		
			echo "<br>";
			echo $item->get_content();
			
			echo "<br>";
			echo $item->get_enclosure()->get_thumbnail();
			
			echo "<br >";
			echo $mediaImage=$item->get_enclosure()->get_link();	
		echo "<br>";
		
					
					
			}
	//print_r($feed);

?>