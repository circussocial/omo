<?php

global $wpdb;

$tablename=$wpdb->prefix."multi_rss_feeds_data";
$query="select * from $tablename where isFlag='1'";
$sql=$wpdb->get_results($query);
if(sizeof($sql)>0)
{
	?>
	<table cellpadding="0" cellspacing="0" width="98%" align="center">
    	<tr style="background-color:#00284e;color:white;">
        	<td style="height:35px;width:40px;text-align:center;">
            #
            </td>
			<td  style="height:35px;">
           <strong> Title</strong>
            </td>
			
        <td style="height:35px;">&nbsp;
         
            </td>
        </tr>
     <?php
		$cnt=1;
			foreach($sql as $record)
			{
				?>
				<tr <?php if($cnt%2==0){ ?> style="background-color:#efefef;"<?php }?>>
                <td  style="height:35px;text-align:center;">
               <?=$cnt++;?> 
                </td>
                <td  style="height:35px;">
               <a href="<?=html_entity_decode($record->feedLink);?> " style="text-decoration:none;"target="_blank"><?=utf8_decode(html_entity_decode($record->feedtitle));?></a>
                </td>
			     <td align="center"  style="height:35px;text-align:right;">
             		<a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/resetFlag.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/reset.png" /></a>

             		<a href="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/DelData.php?rcId=<?=$record->feedId;?>" target="myFrame"><img src="<?=get_site_url();?>/wp-content/plugins/wp-multi-rss-impoter/delete.png" /></a>
                </td>                               
                </tr>
				<?php
			}
		?>
    </table>
	<?php

}
else
{
	?>
	<p style="color:red;">No Feeds are flagged in current</p>
	<?php
}
?>
<iframe width="1024" height="200" id="myFrame" name="myFrame" style="display:none;"></iframe>