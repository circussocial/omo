<style type="text/css">
td.myshortImg img{
	width:50% !important; height:auto !important;
	
	}
</style><?php
include('../../../wp-load.php');
global $wpdb;
$qType=trim($_GET['catName']);

function text_decode($str)
{
		$str=stripslashes($str);
		$str=html_entity_decode($str);
		$str=strip_tags($str,"img");
		
	return $str;
}
function url_encode($str)
{
	if($str)
	{
		$str=urldecode($str);
		$str=str_replace("http://",'',$str);
		$str=str_replace("www.","",$str);
		$str="http://".$str;
		return $str;
	}
	else
	{
		return "#";
	}
}
$table_name=$wpdb->prefix."multi_rss_feeds_data";
$cattable=$wpdb->prefix."multi_rss_category";
$cattablequery="select * from $cattable where MCID=$qType";
$cattablesql=$wpdb->get_results($cattablequery);

echo "Keywords to Include : ".$includekeyword=$cattablesql[0]->inc;
echo "<Br/>";
echo "Keywords to Exclude : ".$exludekeyword=$cattablesql[0]->excl;
echo "<Br/>";
$query="select * from $table_name where mcatId='$qType' order by feedId";

$sql=$wpdb->get_results($query);
if(sizeof($sql)>0)
{
	?>

<br/>
<table cellpadding="0" cellspacing="0" width="98%" align="center">
  <tr style="background-color:#00284e;color:white;">
    <td style="height:35px;width:40px;text-align:center;"> # </td>
    <td  style="height:35px;"><strong> Title</strong></td>
    <td  style="height:35px;"><strong> Description</strong></td>
    <td width="100" align="center"  style="height:35px;"><strong>Is Sticky</strong></td>
    <td width="100" align="center"  style="height:35px;"><strong> Is Highlighted</strong></td>
    <td style="height:35px;">&nbsp;</td>
  </tr>
  <?php
		$cnt=1;
		$mcnt=0;
			$include_array=explode(",",$includekeyword);
			$exclude_array=explode(",",$exludekeyword);
			foreach($sql as $record)
			{

				if($exludekeyword && $includekeyword)
				{
					if(strtolower($exludekeyword) != strtolower($includekeyword))
					{
					foreach($include_array as $minc)
					{
						$chk=strchr(strtolower(text_decode($record->feedDesc)),strtolower($minc));
						if(strlen($chk)>0)
						{
							foreach($exclude_array as $xinc)
							{
								$chk1=strchr(strtolower(text_decode($record->feedDesc)),strtolower($xinc));								
								if(strlen($chk1))
								{
									
								}
								else
								{
									?>
  <tr <?php if($cnt%2==0){ ?> style="background-color:#efefef;" <?php }?>>
    <td  style="height:35px;text-align:center;"><?=$cnt++;?></td>
    <td  style="height:35px;"><?php
					if(url_encode(html_entity_decode($record->feedLink))=="#")
					{
						?>
      <?=text_decode($record->feedtitle);?>
      <?
					}
					else
					{
						?>
      <a href="<?=url_encode(html_entity_decode($record->feedLink));?> " style="text-decoration:none;"target="_blank">
      <?=text_decode($record->feedtitle);?>
      </a>
      <? 
					}
				   ?></td>
    <td  style="height:35px;"><?php
	if($record->cat=="instagram" )
	{
	echo $record->feedDesc;
	}
	else
	{
		echo text_decode($record->feedDesc);
	}
	?></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isSticky" id="isSticky"  onchange="update_sticky('<?=$record->feedId;?>',this.checked)" <?php if($record->isSticky=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isHighLight" id="isHighLight" onchange="update_highlighted('<?=$record->feedId;?>',this.checked)"  <?php if($record->isHighlight=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;text-align:right;"><a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/DelData.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/delete.png" /></a></td>
  </tr>
  <?php
								}
								
							}
						}
					}
					}
					
				
				}
				elseif(!$exludekeyword && !$includekeyword)
				{
					?>
  <tr <?php if($cnt%2==0){ ?> style="background-color:#efefef;" <?php }?>>
    <td  style="height:35px;text-align:center;"><?=$cnt++;?></td>
    <td  style="height:35px;"><?php
					if(url_encode(html_entity_decode($record->feedLink))=="#")
					{
						?>
      <?=text_decode($record->feedtitle);?>
      <?
					}
					else
					{
						?>
      <a href="<?=url_encode(html_entity_decode($record->feedLink));?> " style="text-decoration:none;"target="_blank">
      <?=text_decode($record->feedtitle);?>
      </a>
      <? 
					}
				   ?></td>
    <td  style="height:35px;" class="myshortImg"><?php
	if($record->cat=="instagram" )
	{
	echo html_entity_decode($record->feedDesc);
	}
	else
	{
		echo text_decode($record->feedDesc);
	}
	?></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isSticky" id="isSticky"  onchange="update_sticky('<?=$record->feedId;?>',this.checked)" <?php if($record->isSticky=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isHighLight" id="isHighLight" onchange="update_highlighted('<?=$record->feedId;?>',this.checked)"  <?php if($record->isHighlight=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;text-align:right;"><a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/DelData.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/delete.png" /></a></td>
  </tr>
  <?php
				}
				elseif($includekeyword)
				{
					$includearray=explode(",",$includekeyword);
					$cmd=0;
					foreach($includearray as $minc)
					{
						$chk=strchr(strtolower(text_decode($record->feedDesc)),strtolower($minc));
						if(strlen($chk)>0)
						{
							$cmd++;
						}
					}
					if($cmd>0)
					{
					?>
  <tr <?php if($cnt%2==0){ ?> style="background-color:#efefef;"<?php }?>>
    <td  style="height:35px;text-align:center;"><?=$cnt++;?></td>
    <td  style="height:35px;"><?php
					if(url_encode(html_entity_decode($record->feedLink))=="#")
					{
						?>
      <?=text_decode($record->feedtitle);?>
      <?
					}
					else
					{
						?>
      <a href="<?=url_encode(html_entity_decode($record->feedLink));?> " style="text-decoration:none;"target="_blank">
      <?=text_decode($record->feedtitle);?>
      </a>
      <? 
					}
				   ?></td>
    <td  style="height:35px;"><?
	if($record->cat=="instagram" )
	{
	echo html_entity_decode($record->feedDesc);
	}
	else
	{
		echo text_decode($record->feedDesc);
	}
	?></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isSticky" id="isSticky"  onchange="update_sticky('<?=$record->feedId;?>',this.checked)" <?php if($record->isSticky=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isHighLight" id="isHighLight" onchange="update_highlighted('<?=$record->feedId;?>',this.checked)"  <?php if($record->isHighlight=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;text-align:right;"><a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/DelData.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/delete.png" /></a></td>
  </tr>
  <?php
				
				}
				}
				elseif($exludekeyword)
				{
					$includearray=explode(",",$exludekeyword);
					$cmd=0;
					foreach($includearray as $minc)
					{
						$chk=strchr(strtolower(text_decode($record->feedDesc)),strtolower($minc));
						if(strlen($chk)>0)
						{
							$cmd++;
						}
					}
					if($cmd==0)
					{
					?>
  <tr <?php if($cnt%2==0){ ?> style="background-color:#efefef;"<?php }?>>
    <td  style="height:35px;text-align:center;"><?=$cnt++;?></td>
    <td  style="height:35px;"><?php
					if(url_encode(html_entity_decode($record->feedLink))=="#")
					{
						?>
      <?=text_decode($record->feedtitle);?>
      <?
					}
					else
					{
						?>
      <a href="<?=url_encode(html_entity_decode($record->feedLink));?> " style="text-decoration:none;"target="_blank">
      <?=text_decode($record->feedtitle);?>
      </a>
      <? 
					}
				   ?></td>
    <td  style="height:35px;"><? 
	if($record->cat=="instagram" )
	{
	echo html_entity_decode($record->feedDesc);
	}
	else
	{
		echo text_decode($record->feedDesc);
	}
	?></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isSticky" id="isSticky"  onchange="update_sticky('<?=$record->feedId;?>',this.checked)" <?php if($record->isSticky=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;"><input type="checkbox" name="isHighLight" id="isHighLight" onchange="update_highlighted('<?=$record->feedId;?>',this.checked)"  <?php if($record->isHighlight=="1"){ ?> checked="checked"<?php } ?>/></td>
    <td align="center"  style="height:35px;text-align:right;"><a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/DelData.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/delete.png" /></a></td>
  </tr>
  <?php
				
				}
				}
				
			
			}
		?>
</table>
<?php
}
else
{
	?>
<br/>
<p style="color:red;">Sorry no feeds for this category.</p>
<?php
}
?>
<iframe width="1024" height="200" id="myFrame" name="myFrame" style="display:none;"></iframe>
