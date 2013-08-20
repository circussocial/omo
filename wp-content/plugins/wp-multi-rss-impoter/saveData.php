<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include('../../../wp-load.php');
global $wpdb;
$table_name=$wpdb->prefix."multi_rss_feeds_data";
$type=trim($_GET['type']);

$state=trim($_GET['state']);
$rcId=trim($_GET['rcId']);
if($rcId)
{
if($type=="sticky")
{
	if($state=="true")
	{
		 $query="update $table_name set isSticky='1' where feedId=$rcId";
	}
	else
	{
		$query="update $table_name set isSticky='0' where feedId=$rcId";
	}
}
elseif($type=="highlight")
{
	if($state=="true")
	{
		$query="update $table_name set isHighlight='1' where feedId=$rcId";
	}
	else
	{
		$query="update $table_name set isHighlight='0' where feedId=$rcId";
	}
}
}
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
</body>
</html>