<?php
include('../../../wp-load.php');
$rcId=$_GET['rcId'];
global $wpdb;
$table_name=$wpdb->prefix."multi_rss_feeds_data";
$query="update $table_name set isFlag='0' where feedId=$rcId";
$sql=$wpdb->query($query);
if($sql)
{
	?>
	<script type="text/javascript">
window.parent.location.reload();
	</script>
	<?php
}
?>