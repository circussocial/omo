<?php
include('../../../wp-load.php');
$rcId=$_GET['rcId'];
global $wpdb;
$table_name=$wpdb->prefix."multi_rss_feeds_data";
$query="delete from $table_name where feedId=$rcId";
$sql=$wpdb->query($query);
if($sql)
{
	?>
	<script type="text/javascript">
	window.parent.view_feeds_by_cat();
	</script>
	<?php
}
?>