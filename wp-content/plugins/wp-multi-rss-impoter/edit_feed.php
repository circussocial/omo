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
			$tablename = $wpdb->prefix."multi_rss_feeds"; 
            $planDetail = $wpdb->get_row("SELECT * FROM `$tablename` WHERE catId= $ID");
			
		

            if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit'])) {
            
					  $messageID = $ID; 
						$wynneData = array(
                                    'name' => $_POST['title'],
                                    'url' => $_POST['url'],
									'mcatId' => $_POST['feedcategory']							
									                                 
                                );
								
								
								$planWhere = array(
                                    'catId' => $messageID
                                );
							
									
									$wpdb->update( $tablename, $wynneData, $planWhere, $format = null, $where_format = null );                                
                                    
                                    wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=rmimanger');
	
	  


            } // END THE IF STATEMENT THAT STARTED THE WHOLE FORM


            ?>
<div id="wpbody">

    <div id="wpbody-content">
        <div class="wrap">
           
            
            <div id="wpbody-content">
                <div class="wrap">
                    <h2>
                        Edit Feed
                    </h2>
                  
                    <form action="<?php echo $_SERVER['PHP_SELF']."?page=rmimanger&action=edit&id=".$ID; ?>" enctype="multipart/form-data" method="post" name="editFrmPlan" id="editFrmPlan">
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
                                        URL
                                    </label>
                                    <td>
                                        <input name="url" type="text" id="url" value="<?php echo $planDetail->url; ?>"/>
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
                            
                            <option value="0" >Select Category</option>
                            <?php 				
								$cattablename = $wpdb->prefix."multi_rss_category";
						
								 $query=$wpdb->get_results("SELECT MCID,name FROM $cattablename ");
								
								foreach( $query as $rows)
								{			$selectddl='';
										if($planDetail->mcatId == $rows->MCID){$selectddl = 'selected="selected"';}
									echo '<option value="'.$rows->MCID.'"  '.$selectddl.'>'.$rows->name.'</option>';	
								}
							?>
                            
                            </select>
                        </td>
                    </th>
                </tr>
                            
                            
                            
                            

          
                            </tbody>
                        </table>
                        <p class="submit">
                            <input type="submit" name="submit" id="editPlan" class="button button-primary" value="Update Feed"/>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

