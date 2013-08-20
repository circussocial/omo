<?php
global $wpdb;
$cattable=$wpdb->prefix."multi_rss_category";
$table1=$wpdb->prefix.'multi_rss_feeds';
$table2=$wpdb->prefix.'multi_rss_feeds_data';
$query1="select * from $cattable order by name";
$sql1=$wpdb->get_results($query1);
if(sizeof($sql1)>0)
{
	
	?>
    
	<Table cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td width="100"><label>Category</label></td>
            <td>
            <select name="catName" id="catName" onChange="view_feeds_by_cat()">
            <?php
			foreach($sql1 as $cat)
			{
				?>
				<option value="<?=$cat->MCID;?>"><?=ucwords($cat->name);?></option>
				<?php
			}
			?>
            </select>
            </td>
        </tr>
        <tr>
        	<td>&nbsp;
            	
            </td>
        </tr>
    </Table>
    <div id="txtHint"><img src="<?= get_site_url(); ?>/wp-content/plugins/wp-multi-rss-impoter/wait.gif" /></div>
    <script type="text/javascript">
	view_feeds_by_cat();
	</script>
	<?php
}
?>