<?php
include('../../../wp-load.php');
$rcId=$_GET['rcId'];
global $wpdb;
$table_name=$wpdb->prefix."multi_rss_feeds_data";
$query="update $table_name set isFlag='1' where feedId=$rcId";
$sql=$wpdb->query($query);
if($sql)
{
	?>
	<script type="text/javascript">
	window.parent.document.getElementById("div_<?=$rcId;?>").style.backgroundColor="#ff0000";

	</script>
	<?php
}
?>