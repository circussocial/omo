<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 

   function add_custom_image($upload)
    {
        global $wpdb;
        $messages = "Please Upload your Image There is an error";
        $messages1 = "Image uploaded";
        $message = "New Message added successfully";
        $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/

        if (is_writable($uploads['path']))  /*Check if upload dir is writable*/
        {
            if ((!empty($upload['tmp_name'])))  /*Check if uploaded image is not empty*/
            {
                if ($upload['tmp_name'])   /*Check if image has been uploaded in temp directory*/
                {
                    $file=handle_image_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
                    $fileName = $file['file'];
                    $filePath = $file['url'];
                    $imageName = $_FILES['wynneImage']['name'];
                    $w = 130;
                    $h = 200;
                    $imageArray = image_resize_crop ( $filePath, $w, $h, $dest = null, $override = false, $createNewIfExists = false );



                    $imageBind = explode('/', $imageArray);
                    /*echo '<pre>';
                   print_r($imageBind);
                   echo '</pre>';*/
                    $imageName = $imageBind[5]."/".$imageBind[6]."/".$imageBind[7];
                    $wynneData = array(
                        'message' => $_POST['emessage'],
                        'category' => $_POST['ecategory'],
                        'tag' => $_POST['etag'],
                        'caricature_img' => $imageName
                    );

                    if($wpdb->insert('wp_wynne_message', $wynneData))
                    {
                        queue_flash_message( $message, $class = 'updated' );
                        wp_redirect(bloginfo('url').'/wp-admin/admin.php?page=view_message');
                    }
                    queue_flash_message($messages1, $class = 'updated' );
                }
            }
            else
            {
                queue_flash_message($messages, $class = 'updated' );
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
	
	
	   function add_custom_image($ID, $upload)
                {
                    $messageID = $ID;
                    global $wpdb;
                    $messages = "Please Upload your Image There is an error";
                    $messages2 = "Image uploaded";
                    $message = "Message updated successfully";
                    $message1 = "There was an error";
                    $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/

                    if (is_writable($uploads['path']))  /*Check if upload dir is writable*/
                    {
                        if ((!empty($upload['tmp_name'])))  /*Check if uploaded image is not empty*/
                        {
                            if ($upload['tmp_name'])   /*Check if image has been uploaded in temp directory*/
                            {
                                $file=handle_image_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
                                $fileName = $file['file'];
                                $filePath = $file['url'];
                                $imageName = $_FILES['wynneImage']['name'];
                                $w = 130;
                                $h = 200;
                                $imageArray = image_resize_crop ( $filePath, $w, $h, $dest = null, $override = false, $createNewIfExists = false );



                                $imageBind = explode('/', $imageArray);
                                /*echo '<pre>';
                                print_r($imageBind);
                                echo '</pre>';*/
                                $imageName = $imageBind[5]."/".$imageBind[6]."/".$imageBind[7];
                                $wynneData = array(
                                    'message' => $_POST['emessage'],
                                    'category' => $_POST['ecategory'],
                                    'tag' => $_POST['etag'],
                                    'caricature_img' => $imageName
                                );


                                $planWhere = array(
                                    'id' => $messageID
                                );

                                if($wpdb->update( 'wp_wynne_message', $wynneData, $planWhere, $format = null, $where_format = null ))
                                {
                                    queue_flash_message( $message, $class = 'updated' );
                                    wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=view_message');
                                }
                                else{

                                    queue_flash_message( $message1, $class = 'updated' );
                                    wp_redirect(get_option('siteurl').'/wp-admin/edit-wynneMessage.php?id='.$messageID);
                                }
                                queue_flash_message($messages2, $class = 'updated' );
                            }
                        }
                        else
                        {
                            queue_flash_message($messages, $class = 'updated' );
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
                if($upload = $_FILES['wynneImage']['name'] != "")
                {
                    add_custom_image($upload);
                }
                else{
                    $wynneData = array(
                        'message' => $_POST['emessage'],
                        'category' => $_POST['ecategory'],
                        'tag' => $_POST['etag'],
                    );

                    if($wpdb->insert('wp_wynne_message', $wynneData))
                    {
                        queue_flash_message( $message, $class = 'updated' );
                        wp_redirect(bloginfo('url').'/wp-admin/admin.php?page=view_message');
                    }
                }

?>
</body>
</html>