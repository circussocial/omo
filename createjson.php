<?php
$limit=$_GET['limit'];
if(!$limit)
{
	$limit=0;
}
$upperlimit=$limit+10;
include('wp-load.php');
    $tablename = $wpdb->prefix . "multi_rss_feeds_data";
    $rss_publish_cat_str = get_option('rss_publish_cat');
    $rss_publish_cat_spotlight = get_option('rss_publish_cat_spotlight');
    $rss_publish_cat_arr = explode(",", $rss_publish_cat_str);
    $rss_cat_sticky_arr = '';
    $rss_sportlight_sticky_arr = '';
    $rss_feed_cat_arr = '';
    $cattablename = $wpdb->prefix . "multi_rss_category";
    if (!empty($rss_publish_cat_str)) {
  foreach ($rss_publish_cat_arr as $row) {
            $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
            $as = 1;
           foreach ($cat_arr as $catrow) {
                $inc = trim($catrow->inc);
                $excl = trim($catrow->excl);
                $image = $catrow->image;
                if (!empty($inc) && !empty($excl)) {
                   
                } else {
                    if (!empty($inc)) {
                        $inc_arr = explode(",", $inc);
                        $ie = 1;
                        $feedwere = '';
                        foreach ($inc_arr as $word) {
                            if ($ie == 1) {
                                $feedwere = "( feedDesc  like '%$word%')";
                            } else {
                                $feedwere .= "OR ( feedDesc  like '%$word%')";
                            }
                            $ie++;
                        }
                        $incl = "SELECT * FROM $tablename WHERE $feedwere and (isSticky = '1' ) and  mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit ";
                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($incl);
                    } elseif (!empty($excl)) {
                        $excl_arr = explode(",", $excl);
                        $ie = 1;
                        $feedwere = '';
                        foreach ($excl_arr as $exclword) {
                            if ($ie == 1) {
                                $feedwere = "( feedDesc Not like '%$exclword%')";
                            } else {
                                $feedwere .= "OR ( feedDesc Not like '%$exclword%') ";
                            }
                            $ie++;
                        }
                        $exclude = "SELECT * FROM  $tablename  WHERE $feedwere and (isSticky = '1' ) and mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit";
                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($exclude);
                    } else {
                        $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE (isSticky = "1" ) and  mcatId in (' . $catrow->MCID . ') order By createdon DESC limit '.$limit.','.$upperlimit;
                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                    }
                }
                $as++;
            }
        }
    }
    if (!empty($rss_publish_cat_spotlight)) {
        $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $rss_publish_cat_spotlight ");
        $as = 1;
        foreach ($cat_arr as $catrow) {
            $inc = trim($catrow->inc);
            $excl = trim($catrow->excl);
            $image = $catrow->image;
            if (!empty($inc) && !empty($excl)) {
               
            } else {
                if (!empty($inc)) {
                    $inc_arr = explode(",", $inc);
                    $ie = 1;
                    $feedwere = '';
                    foreach ($inc_arr as $word) {
                        if ($ie == 1) {
                            $feedwere = "( feedDesc  like '%$word%')";
                        } else {
                            $feedwere .= "OR ( feedDesc  like '%$word%')";
                        }
                        $ie++;
                    }
                    $incl = "SELECT * FROM $tablename WHERE $feedwere  and  mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit ";
                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($incl);
                } elseif (!empty($excl)) {
                    $excl_arr = explode(",", $excl);
                    $ie = 1;
                    $feedwere = '';
                    foreach ($excl_arr as $exclword) {
                        if ($ie == 1) {
                            $feedwere = "( feedDesc Not like '%$exclword%')";
                        } else {
                            $feedwere .= "OR ( feedDesc Not like '%$exclword%')";
                        }
                        $ie++;
                    }
                    $exclude = "SELECT * FROM  $tablename  WHERE $feedwere  and mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit";
                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($exclude);
                } else {
       $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE   mcatId in (' . $catrow->MCID . ') order By createdon DESC limit '.$limit.',.'.$upperlimit;
                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                }
            }
            $as++;
        }
    }
    if (!empty($rss_publish_cat_str)) {
        foreach ($rss_publish_cat_arr as $row) {
            $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
            $as = 1;
            foreach ($cat_arr as $catrow) {
                $inc = trim($catrow->inc);
                $excl = trim($catrow->excl);
                $image = $catrow->image;
                if (!empty($inc) && !empty($excl)) {
                   
                } else {
                    if (!empty($inc)) {
                        $inc_arr = explode(",", $inc);
                        $ie = 1;
                        $feedwere = '';
                        foreach ($inc_arr as $word) {
                            if ($ie == 1) {
                                $feedwere = "( feedDesc  like '%$word%')";
                            } else {
                                $feedwere .= "OR ( feedDesc  like '%$word%')";
                            }
                            $ie++;
                        }
                        $incl = "SELECT * FROM $tablename WHERE $feedwere and (isSticky != '1' ) and  mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit";
                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($incl);
                    } elseif (!empty($excl)) {
                        $excl_arr = explode(",", $excl);
                        $ie = 1;
                        $feedwere = '';
                        foreach ($excl_arr as $exclword) {
                            if ($ie == 1) {
                                $feedwere = "( feedDesc Not like '%$exclword%')";
                            } else {
                                $feedwere .= "OR (feedDesc Not like '%$exclword%')";
                            }
                            $ie++;
                        }
                        $exclude = "SELECT * FROM  $tablename  WHERE $feedwere and (isSticky != '1' ) and mcatId in ($catrow->MCID) order By createdon DESC limit $limit,$upperlimit";
                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($exclude);
                    } else {
                        $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE (isSticky != "1" ) and  mcatId in (' . $catrow->MCID . ') order By createdon DESC limit '.$limit.','.$upperlimit;
                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                    }
                }
                $as++;
            }

	    }
    }
	$mcnt=0;
  if ($rss_sportlight_sticky_arr) {
        foreach ($rss_sportlight_sticky_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }
                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }
                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }
                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }
					
					$timeage = nicetime($row->createdon);
								$feedtitletag = $row->feedtitle;			
									
                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '"  ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title">'.$feedtitletag.'</div>';
					$array1[$mcnt]['posts']['title']=$row->feedtitle;
					$array1[$mcnt]['posts']['post']=$row->post;
					$array1[$mcnt]['posts']['imageUrl']=rawurldecode($row->feedImgThumb);
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';
                $rsshtml .= '<div class="isSticky" ><img src="' . $isSticky . '"  ></div>';
                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
				
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
			
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
           $mcnt++;   }
   
	 }
    }
    if ($rss_cat_sticky_arr) {
        foreach ($rss_cat_sticky_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
                $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
                $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';
                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }
                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }
                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }
		 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
				
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }
				 $timeage = nicetime($row->createdon);
					$feedtitletag = $row->feedtitle;			
								if(!empty($row->feedLink))
								{
								$feedtitletag = '<a href="'.rawurldecode($row->feedLink).'" target="_blank">'.$row->feedtitle.'</a>';
								}	
                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '"  ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title">'.$feedtitletag.'</div>';				
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';
                $rsshtml .= '<div class="isSticky" ><img src="' . $isSticky . '"  ></div>';
                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
				$array1[$mcnt]['posts']['title']=$row->feedtitle;
					$array1[$mcnt]['posts']['post']=$row->post;
					$array1[$mcnt]['posts']['imageUrl']=rawurldecode($row->feedImgThumb);
      $mcnt++;       }
       }
    }
    if ($rss_feed_cat_arr) {
        foreach ($rss_feed_cat_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
                $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
                $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';
                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }
                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }
                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }
$icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
				
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }
				 $timeage = nicetime($row->createdon);
				$feedtitletag = $row->feedtitle;			
								if(!empty($row->feedLink))
								{
								$feedtitletag = '<a href="'.rawurldecode($row->feedLink).'" target="_blank">'.$row->feedtitle.'</a>';
								}	
                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '"  ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title">'.$feedtitletag.'</div>';
				
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';
                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
				$array1[$mcnt]['posts']['title']=$row->feedtitle;
					$array1[$mcnt]['posts']['post']=$row->post;
					$array1[$mcnt]['posts']['imageUrl']=rawurldecode($row->feedImgThumb);
           $mcnt++;   }
      }
    }
$mainarray['data']=$array1;
echo json_encode($mainarray);
?>