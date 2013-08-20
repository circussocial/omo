<?php 

global $wpdb;

$siteurl= get_site_url();
$Images_url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/defaultfeed.jpg';	

 $tablename=$wpdb->prefix."multi_rss_feeds_data";
  
   $rss_publish_cat_str = get_option('rss_publish_cat');
  
    $rss_publish_cat_spotlight = get_option('rss_publish_cat_spotlight');
	
	$rss_publish_cat_arr = explode(",", $rss_publish_cat_str);
  
 $rss_cat_sticky_arr        = '';
 $rss_sportlight_sticky_arr = '';
 $rss_feed_cat_arr  ='';
 $cattablename = $wpdb->prefix."multi_rss_category";

if(!empty($rss_publish_cat_str) ){ 

		foreach($rss_publish_cat_arr as $row)
		{
                                       
    $cat_arr=$wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
		$as =1;
		foreach($cat_arr as $catrow)
		{
			
			$inc = trim($catrow->inc);
			$excl = trim($catrow->excl);
			$image = $catrow->image;
			
		 			
			if(!empty($inc) &&!empty($excl) )
			{
			}
			else
			{
				if(!empty($inc))
						{
							$inc_arr = explode(",", $inc);
								$ie =1;
							
							$feedwere = '';
							foreach($inc_arr as $word)
							{
									if($ie == 1)
									{
											$feedwere = "`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%'";	
									}
									else
									{
										$feedwere .= "and `feedtitle`  like '%$word%' and `feedDesc`  like '%$word%'";	
									}
									
									$ie++;									
							}
						  $incl ="SELECT * FROM $tablename WHERE $feedwere and (`isSticky` = '1' ) and  mcatId in ($catrow->MCID) ";
						  
						   $rss_cat_sticky_arr[$as]['image']  = $image; 
						   $rss_cat_sticky_arr[$as]['data']   = $wpdb->get_results($incl);
						}
					elseif(!empty($excl))
						{
							$excl_arr= explode(",", $excl);
							
									$ie =1;
									
									$feedwere = '';
									foreach($excl_arr as $exclword)
									{
											if($ie == 1)
											{
													$feedwere = "`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%'";	
											}
											else
											{
												$feedwere .= "and `feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%'";	
											}
											
											$ie++;									
									}
									
									$exclude ="SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` = '1' ) and mcatId in ($catrow->MCID) ";
									
									$rss_cat_sticky_arr[$as]['image']  = $image; 	
									$rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($exclude);
								
						}
					else{
						   $rss_cat_sticky = 'SELECT * FROM '.$tablename.' WHERE (`isSticky` = "1" ) and  mcatId in ('.$catrow->MCID.')';

							 $rss_cat_sticky_arr[$as]['image']  = $image; 
							 $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);						 
						}
				
				
			}
			$as++;
		}
	}
}

if(!empty($rss_publish_cat_spotlight) ){ 


                                       
    $cat_arr=$wpdb->get_results("SELECT * FROM $cattablename where MCID = $rss_publish_cat_spotlight ");
		$as =1;
		foreach($cat_arr as $catrow)
		{
			
			$inc = trim($catrow->inc);
			$excl = trim($catrow->excl);
			$image = $catrow->image;
			
		 	
			
			if(!empty($inc) &&!empty($excl) )
			{
			}
			else
			{
				if(!empty($inc))
						{
							$inc_arr = explode(",", $inc);
								$ie =1;
							
							$feedwere = '';
							foreach($inc_arr as $word)
							{
									if($ie == 1)
									{
											$feedwere = "(`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";	
									}
									else
									{
										$feedwere .= "OR (`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";	
									}
									
									$ie++;									
							}
						   $incl ="SELECT * FROM $tablename WHERE $feedwere and (`isSticky` = '1' ) and  mcatId in ($catrow->MCID) ";
						  
						$rss_sportlight_sticky_arr[$as]['image']= $image;
						$rss_sportlight_sticky_arr[$as]['data']=$wpdb->get_results($incl);
						}
					elseif(!empty($excl))
						{
							$excl_arr= explode(",", $excl);
							
									$ie =1;
									
									$feedwere = '';
									foreach($excl_arr as $exclword)
									{
											if($ie == 1)
											{
													$feedwere = "(`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";	
											}
											else
											{
												$feedwere .= "OR (`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";	
											}
											
											$ie++;									
									}
									
									 $exclude ="SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` = '1' ) and mcatId in ($catrow->MCID) ";	
									
									 $rss_sportlight_sticky_arr[$as]['image']= $image;
									 $rss_sportlight_sticky_arr[$as]['data']=$wpdb->get_results($exclude);
								
						}
					else{
						  
						    $rss_cat_sticky = 'SELECT * FROM '.$tablename.' WHERE (`isSticky` = "1" ) and  mcatId in ('.$catrow->MCID.')';
						   
							 $rss_sportlight_sticky_arr[$as]['image']= $image;
							 $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);						 
						}
				
				
			}
			$as++;
		}
	
 
 }

if(!empty($rss_publish_cat_str) ){ 



foreach($rss_publish_cat_arr as $row)
		{
                                       
    $cat_arr=$wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
		$as =1;
		foreach($cat_arr as $catrow)
		{
			
			$inc = trim($catrow->inc);
			$excl = trim($catrow->excl);
			$image = $catrow->image;
			
		 	
			
			if(!empty($inc) &&!empty($excl) )
			{
			}
			else
			{
				if(!empty($inc))
						{
							$inc_arr = explode(",", $inc);
								$ie =1;
							
							$feedwere = '';
							foreach($inc_arr as $word)
							{
									if($ie == 1)
									{
											$feedwere = "`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%'";	
									}
									else
									{
										$feedwere .= "and `feedtitle`  like '%$word%' and `feedDesc`  like '%$word%'";	
									}
									
									$ie++;									
							}
						  $incl ="SELECT * FROM $tablename WHERE $feedwere and (`isSticky` != '1' ) and  mcatId in ($catrow->MCID) ";
						
						$rss_feed_cat_arr[$as]['image']=$image;  
						$rss_feed_cat_arr[$as]['data']=$wpdb->get_results($incl);
						}
					elseif(!empty($excl))
						{
							$excl_arr= explode(",", $excl);
							
									$ie =1;
									
									$feedwere = '';
									foreach($excl_arr as $exclword)
									{
											if($ie == 1)
											{
													$feedwere = "`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%'";	
											}
											else
											{
												$feedwere .= "and `feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%'";	
											}
											
											$ie++;									
									}
									
									$exclude ="SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` != '1' ) and mcatId in ($catrow->MCID) ";	
									
									$rss_feed_cat_arr[$as]['image']=$image; 
									$rss_feed_cat_arr[$as]['data']=$wpdb->get_results($exclude);
								
						}
					else{
						   $rss_cat_sticky = 'SELECT * FROM '.$tablename.' WHERE (`isSticky` != "1" ) and  mcatId in ('.$catrow->MCID.')';

							 $rss_feed_cat_arr[$as]['image']=$image; 
							 $rss_feed_cat_arr[$as]['data']=$wpdb->get_results($rss_cat_sticky);						 
						}
				
				
			}
			$as++;
		}
	}
 }





?>

<?php 
if(!empty($rss_sportlight_sticky_arr)){?>
<h2> Sticky On Spotlight</h2>
<table class="wp-list-table widefat fixed users" cellspacing="0">

                             <thead>

                            <tr>

                                 

                                        <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                            </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                   <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                                </tr>

                            </tfoot>
                             
                             <tbody id="the-list" class='list:user'>
<?php

foreach($rss_sportlight_sticky_arr as $rowcat)
{
	foreach ($rowcat['data'] as $row )
			{
				echo ' <tr id="user-15" class="alternate">';
				
				//echo rawurldecode($row->feedImgThumb); 
						if(empty($row->feedImgThumb))
											{
												 if(!empty($rowcat['image']))
												 {
													 $row->feedImgThumb = $rowcat['image'] ;
												 }else
												 {
													  $row->feedImgThumb = $Images_url ;
												 }
												
											}
						
						echo '<td class="view_plan_name column-view_plan_name"><img src="'.rawurldecode($row->feedImgThumb).'" width="75px" height="75px" ></td>';
						echo '<td class="view_plan_name column-view_plan_name"><a href="'.$row->feedLink.'" target="_blank">'.$row->feedtitle.'</a></td>';
						echo '<td class="view_plan_name column-view_plan_name">'.$row->feedDesc.'</td>';
						echo "</tr>";
			}
}
			

?>
</tbody>
</table>
<?php }

if(!empty($rss_cat_sticky_arr)){?>
<h2> Sticky On Category Feed</h2>
<table class="wp-list-table widefat fixed users" cellspacing="0">

                             <thead>

                            <tr>

                                 

                                        <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                            </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                   <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                                </tr>

                            </tfoot>
                             
                             <tbody id="the-list" class='list:user'>
<?php

foreach($rss_cat_sticky_arr as $rowcat)
{
	foreach ($rowcat['data'] as $row )
			{
				echo ' <tr id="user-15" class="alternate">';
						if(empty($row->feedImgThumb))
											{
												 if(!empty($rowcat['image']))
												 {
													 $row->feedImgThumb = $rowcat['image'] ;
												 }else
												 {
													  $row->feedImgThumb = $Images_url ;
												 }
												
											}
						
						echo '<td class="view_plan_name column-view_plan_name"><img src="'.rawurldecode($row->feedImgThumb).'" width="75px" height="75px" ></td>';
						echo '<td class="view_plan_name column-view_plan_name"><a href="'.$row->feedLink.'" target="_blank">'.$row->feedtitle.'</a></td>';
						echo '<td class="view_plan_name column-view_plan_name">'.$row->feedDesc.'</td>';
						echo "</tr>";
			}
}
			

?>
</tbody>
</table>
<?php }

if(!empty($rss_feed_cat_arr)){?>
<h2> Category Feed</h2>
<table class="wp-list-table widefat fixed users" cellspacing="0">

                             <thead>

                            <tr>

                                 

                                        <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                            </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                   <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Image</span></a></th>

                                 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

                                      

                                 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Description</span></th>

                                </tr>

                            </tfoot>
                             
                             <tbody id="the-list" class='list:user'>
<?php

foreach($rss_feed_cat_arr as $rowcat)
{
	foreach ($rowcat['data'] as $row )
			{
				echo ' <tr id="user-15" class="alternate">';
						if(empty($row->feedImgThumb))
											{
												 if(!empty($rowcat['image']))
												 {
													 $row->feedImgThumb = $rowcat['image'] ;
												 }else
												 {
													  $row->feedImgThumb = $Images_url ;
												 }
												
											}
						
						echo '<td class="view_plan_name column-view_plan_name"><img src="'.rawurldecode($row->feedImgThumb).'" width="75px" height="75px" ></td>';
						echo '<td class="view_plan_name column-view_plan_name"><a href="'.$row->feedLink.'" target="_blank">'.$row->feedtitle.'</a></td>';
						echo '<td class="view_plan_name column-view_plan_name">'.$row->feedDesc.'</td>';
						echo "</tr>";
			}
}
			

?>
</tbody>
</table>
<?php }

?>

