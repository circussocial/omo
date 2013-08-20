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
            $planDetail = $wpdb->get_row("SELECT * FROM `$tablename` WHERE catId = $ID");

            if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit'])) {
               
						if(!empty($_POST['title']))
						{
			
						if($_POST['category'] == 'twitter_search')
						{
							$url='http://search.twitter.com/search.atom?q='.strtolower(trim($_POST['title']));
						}
						else{$url='http://api.twitter.com/1/statuses/user_timeline.rss?screen_name='.strtolower(trim($_POST['title']));}
			
		
					$wynneData = array(
									'name' => $_POST['title'],
									'cat' =>$_POST['category'],
									'url' => $url,	
									'mcatId' => $_POST['feedcategory']
								);			
		
					
						$planWhere = array(
                                    'catId' => $ID
                                );
					
							$tablename = $wpdb->prefix."multi_rss_feeds";
					
                   $wpdb->update( $tablename, $wynneData, $planWhere, $format = null, $where_format = null );
                                            
                        wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=addtwitter');
                    
			}


	
            } // END THE IF STATEMENT THAT STARTED THE WHOLE FORM


            ?>
<div id="wpbody">

    <div id="wpbody-content">
        <div class="wrap">
           
            
            <div id="wpbody-content">
                <div class="wrap">
                    <h2>
                        Edit Twitter Feed
                    </h2>
                  
                    <form action="<?php echo $_SERVER['PHP_SELF']."?page=addtwitter&action=edit&id=".$ID; ?>" enctype="multipart/form-data" method="post" name="editFrmPlan" id="editFrmPlan">
                        <table class="form-table">
                            <tbody>
                            <tr class="form-field">
                                <th scope="row">
                                    <label for="emessage">
                                        Twitter Keyword
                                    </label>
                                    <td>
                                        <input name="title" type="text" id="title" value="<?php echo $planDetail->name; ?>"/>
                                    </td>
                                </th>
                            </tr>
                            
                            
              				  
                            
                            
                            
                            <tr class="form-field">
                    <th scope="row">
                   
                        <label for="emessage">
                            Type
                        </label>
                        <td>
                            <select name="category">
                            <option value="twitter_search"  <?php if($planDetail->cat =='twitter_search'){ echo $selectddl ='selected="selected"';} ?> >Twitter Hashtags / Search</option>
                            <option value="twitter_name"  <?php if($planDetail->cat =='twitter_name'){ echo $selectddl ='selected="selected"';} ?>>Twitter Name</option>
                            </select>
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

