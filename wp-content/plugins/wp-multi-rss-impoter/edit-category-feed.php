<?php
/**
 * Reading settings administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */


/*$parent_file = 'options-general.php';*/

/**
 * Display JavaScript on the page.
 *
 * @package WordPress
 * @subpackage Reading_Settings_Screen
 */


?>
<?php
            $ID = $_REQUEST['id'];
            global $wpdb;
			$tablename = $wpdb->prefix."multi_rss_category"; 
            $planDetail = $wpdb->get_row("SELECT * FROM `$tablename` WHERE MCID= $ID");
			
		

            if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit'])) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                $upload = $_FILES['image']; /*Receive the uploaded image from form*/



	
	
	   function add_custom_image($ID, $upload)
                {
                    $messageID = $ID; 
                    global $wpdb;
						$tablename = $wpdb->prefix."multi_rss_category"; 
                   
                    $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/

                    if (is_writable($uploads['path']))  /*Check if upload dir is writable*/
                    {                       						
						if(!empty($upload['tmp_name']))
						{
							 	$file=handle_image_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
								
								 $imageName = $file['url'];						 
								 
								
								
								
                            /*    $fileName = $file['file'];
									   
									   $imageBind = explode('/', $fileName);
									   						
								$imageName = $imageBind[3]."/".$imageBind[4]."/".$imageBind[5];
							*/
								
								$wynneData = array(
									'name' => $_POST['title'],									
									'inc' => $_POST['include'],  
									'excl' => $_POST['exclude'],
									'image' => $imageName
									 
								);
								$planWhere = array(
                                    'MCID' => $messageID
                                );
																
								if($wpdb->update( $tablename, $wynneData, $planWhere, $format = null, $where_format = null ))
								{
									
									 
                                    wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=feedcategory');	
								}
						}
						else
						{
							 $wynneData = array(
                                    'name' => $_POST['title'],                                    
									'inc' => $_POST['include'],  
									'excl' => $_POST['exclude']
									                                 
                                );
								
								
								$planWhere = array(
                                    'MCID' => $messageID
                                );
							
									
									$wpdb->update( $tablename, $wynneData, $planWhere, $format = null, $where_format = null );                                
                                    
                                    wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=feedcategory');
                                
						}
                    }
                }
				function handle_image_upload($upload)
    {
         if (file_is_displayable_image( $upload['tmp_name'] )) /*Check if image*/
        {
            /*handle the uploaded file*/
            $overrides = array('test_form' => false);
            $file=wp_handle_upload($upload, $overrides);
        }
        return $file;
    }
			add_custom_image($ID,$upload);


            } // END THE IF STATEMENT THAT STARTED THE WHOLE FORM


            ?>
<div id="wpbody">

    <div id="wpbody-content">
        <div class="wrap">
           
            
            <div id="wpbody-content">
                <div class="wrap">
                    <h2>
                        Edit Feed Category
                    </h2>
                  
                    <form action="<?php echo $_SERVER['PHP_SELF']."?page=feedcategory&action=edit&id=".$ID; ?>" enctype="multipart/form-data" method="post" name="editFrmPlan" id="editFrmPlan">
                        <table class="form-table">
                            <tbody>
                            <tr class="form-field">
                                <th scope="row">
                                    <label for="emessage">
                                        Title
                                    </label>
                                    <td>
                                        <input name="title" type="text" id="title" value="<?php echo $planDetail->name; ?>"/>
                                    </td>
                                </th>
                            </tr>
                            
                            <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Include Keyword
                        </label>
                        <td>
                            <input name="include" type="text" id="include" value="<?php echo $planDetail->inc; ?>"/>
                        </td>
                    </th>
                </tr>
              				  <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Exclude Keyword
                        </label>
                        <td>
                            <input name="exclude" type="text" id="exclude" value="<?php echo $planDetail->excl; ?>"/>
                        </td>
                    </th>
                </tr>
                            
                            
                            <tr class="form-field">
                                <th scope="row">
                                   <img  src="<?php echo $planDetail->image; ?>" width="75px" height="75px" alt="">
                                </th>
                            </tr>
                            <tr class="form-field">
                                <th scope="row">
                                    <label for="etag">
                                       Category an Image
                                    </label>
                                    <td>
                                        <input type="file" name="image">
                                    </td>
                                </th>
                            </tr>

          
                            </tbody>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" id="editPlan" class="button button-primary" value="Update Category"/>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

