<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @@version@@ @@author@@ 
 */

/* get the path to the wp-config.php */


/* get db connection */


define('DB_NAME', 'ogilvya_unileverwp');
define('DB_USER', 'ogilvya_unilever');
define('DB_PASSWORD', '}y3vX]g-+4]%');
define('DB_HOSTNAME', 'localhost');




/* check db connection and give a success message */

/* write a small select query */



?>
<?php 
ob_start();
	
	$host=DB_HOSTNAME;
	$user=DB_USER;
	$pass=DB_PASSWORD;
	
	$db=DB_NAME;
	

	$con=mysql_connect($host,$user,$pass) or die("Error :-".mysql_error());

	mysql_select_db($db,$con) or die("Error :-".mysql_error());
	

        $cattable	=	"wp_multi_rss_category";
	$table1		=	"wp_multi_rss_feeds"; 
	$table2		=	"wp_multi_rss_feeds_data_2";
	$query1		=	"select * from $cattable order by name";
	
	
	
	//$sql=$wpdb->get_results($query1);
	$sql1=mysql_query($query1);	
	$row = mysql_fetch_object($sql1);
	print_r($row);
?>
