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
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $upload = $_FILES['image']; /*Receive the uploaded image from form*/

   function add_custom_image($upload)
    {
        global $wpdb;
        
        $message = "";
        $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/
		
        if (is_writable($uploads['path']))  /*Check if upload dir is writable*/
        {
            if ((!empty($upload['tmp_name'])))  /*Check if uploaded image is not empty*/
            {
                if ($upload['tmp_name'])   /*Check if image has been uploaded in temp directory*/
                {
                    $file=handle_image_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
					
					 $imageName = $file['url'];
					
					   // echo   $imageName;
						
					// $fileName = $file['file'];
					
					//$imageBind = explode('/', $fileName);
					
					//print_r($file);
					/*	echo "<br>";
					print_r($imageBind); 
					
					echo $key = array_search('uploads', $imageBind);
					$imgarray = $imageBind;*/
				
									
					
							
					/*$imageName = $imageBind[3];
					
					if(isset($imageBind[4]))
					{
						 $imageName = $imageBind[3]."/".$imageBind[4]."/".$imageBind[5];
					}*/
                
            
				   
				  
                    $wynneData = array(
                        'name' => $_POST['title'],
                        'excl' => $_POST['exclude'],
						'inc' => $_POST['include'],
					    'image' => $imageName
						
                    );
					
					 
					$tablename = $wpdb->prefix."multi_rss_category"; 
                   if($wpdb->insert($tablename, $wynneData))
                    {
                        
                        wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=feedcategory');
                    }
                    
                }
            }elseif(!empty($_POST['title']))
			{
			
			$siteurl= get_site_url();
	  $images_url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/defaultfeed.jpg';	
	  
		$wynneData = array(
                        'name' => $_POST['title'],
                        'excl' => $_POST['exclude'],
						'inc' => $_POST['include'],
						'image' => $images_url
						
                    );		
					 
				$tablename = $wpdb->prefix."multi_rss_category"; 

                   if($wpdb->insert($tablename, $wynneData))
                    {
                        
                        wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=feedcategory');
                    }
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

    add_custom_image($upload);

 


} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM


?>
<div id="wpbody-content">
    <div class="wrap">
        <h2>
            Add Category
        </h2>
    
   
        
        <form action="<?php echo $_SERVER['PHP_SELF'].'?page=feedcategory&action=add'; ?>" enctype="multipart/form-data" method="post" name="editFrmPlan" id="editFrmPlan">
            <table class="form-table">
                <tbody>
                <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Name
                        </label>
                        <td>
                            <input name="title" type="text" id="title" value=""/>
                        </td>
                    </th>
                </tr>
                
                
                <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Include Keyword
                        </label>
                        <td>
                            <input name="include" type="text" id="include" value=""/>
                        </td>
                    </th>
                </tr>
                <tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Exclude Keyword
                        </label>
                        <td>
                            <input name="exclude" type="text" id="exclude" value=""/>
                        </td>
                    </th>
                </tr>
                
                <tr class="form-field">
                    <th scope="row">
                        <label for="etag">
                            Upload an Image
                        </label>
                        <td>
                            <input type="file" name="image">
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

