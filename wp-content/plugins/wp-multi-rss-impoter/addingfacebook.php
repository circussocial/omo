<?php
/**
 * Reading settings administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */




/*$parent_file = 'index.php';*/

/**
 * Display JavaScript on the page.
 *
 * @package WordPress
 * @subpackage add Feed
 */


global $wpdb;
$message = "";

if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit'])) {
     if(!empty($_POST['title']))
			{
			
			
			$wynneData = array(
                        'name' => $_POST['title'],
                   		'mcatId' => $_POST['feedcategory'],
						'url' => 'https://graph.facebook.com/search?q='.$_POST['title'].'&type=post',						
                       	'cat'=> 'facebook'
                    );
					//print_r($wyneData);		
					$tablename = $wpdb->prefix."multi_rss_feeds"; 
       if($wpdb->insert($tablename, $wynneData))
                    {
                        
                        wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=addingfacebook');
                    }
					else{
						print($wpdb->error);
					}
	}

 


} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM


?>
<div id="wpbody-content">
    <div class="wrap">
        <h2>
            Facebook Feeds
        </h2>
    
   
        
        <form action="<?php echo $_SERVER['PHP_SELF'].'?page=addingfacebook&action=add'; ?>" enctype="multipart/form-data" method="post" name="editFrmPlan" id="editFrmPlan">
            <table class="form-table">
                <tbody>
                <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Facebook Search
                        </label>
                        <td>
                            <input name="title" type="text" id="title" value=""/>
                        </td>
                    </th>
                </tr>
                <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Category
                        </label>
                        <td>
                            <select name="feedcategory">
                            
                            <option value="0">Select Category</option>
                            <?php 				
		$cattablename = $wpdb->prefix."multi_rss_category";

		 $query=$wpdb->get_results("SELECT MCID,name FROM $cattablename ");
		
		foreach( $query as $rows)
		{
			echo '<option value="'.$rows->MCID.'">'.$rows->name.'</option>';	
		}
	?>                    </select>
                        </td>
                    </th>
                </tr>
                   </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="editPlan" class="button button-primary" value="Save"/>
            </p>
        </form>
    </div>
</div>

