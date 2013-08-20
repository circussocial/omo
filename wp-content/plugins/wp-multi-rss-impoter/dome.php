<?php 
	$siteurl= get_site_url();
	echo  $images_url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/images';	
    global $wpdb;
	$action = isset($_GET['action'])?$_GET['action']:'';
	if($action == 'delete')
	{
		$message = " Favourite Social Platform deleted successfully";
		$message1 = "There was an error";
		echo $ID = $_REQUEST['id'];
		
					 if($wpdb->query("DELETE FROM wp_fsp_manager WHERE ID  ='" . $ID . "' LIMIT 1"))
				{
					queue_flash_message( $message, $class = 'updated' );
					wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=fspmanger');
				}
				else{
					queue_flash_message( $message1, $class = 'updated' );
					 wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=fspmanger');
				}
		
	}
	elseif($action == 'add')
	{
		
	include_once('add-fspm.php');
	}
	elseif($action == 'edit')
	{
		
	include_once('edit_fdpm.php');
	}
	else{?>
    
    	<div id="wpbody">
    <div id="wpbody-content">
        <div class="wrap">
            <h2>
                Favourite Social Platform Manager    <a href="admin.php?page=fspmanger&action=add"><input type="button" name="addWynneMessage" class="button button-primary" value="Add FSP "/></a>
            </h2>  
            <form action="<?php print $_SERVER['PHP_SELF'];?>" method="post" name="frmViewPlan" id="frmViewPlan">




                <table class="wp-list-table widefat fixed users" cellspacing="0">
                   <thead>
                    <tr>
                    	
                        <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>
   
                        <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                      
      					 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>
                              
                       	 <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</th>
                        </tr>
                    </tfoot>

                    <tbody id="the-list" class='list:user'>
                        <?php

                        $query=$wpdb->get_results("SELECT * FROM wp_fsp_manager");
						$as=1;
                        foreach($query as $result)
                        {
                            $planID = $result->id;
                            $date = strtotime($result->created_on);


                            ?>
                        <tr id='user-15' class="alternate">
                       		
                             <td class="view_plan_name column-view_plan_name"><?php echo $result->title ; ?></td>
                         
                            <td class="doview column-doview">
                              
                                <a href="admin.php?page=fspmanger&action=edit&id=<?php echo $result->ID ; ?>"><input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/></a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=fspmanger&action=delete&id=<?php echo $result->ID ; ?>"> <input type="button" name="" id="view_message_delete_<?php echo $result->id ; ?>" class="button action delete" value="Delete"/></a>
                            </td>
                        </tr>

                            <?php $as++; } ?>
                    </tbody>
                </table>

            </form>

            <div id ="textDiv"></div>
         



        </div>
    </div>
</div>
		<script type="text/javascript">
    function confirmSubmit()
    {
        var agree=confirm("Are you sure you want to delete?");
        if (agree)
            return true ;
        else
            return false ;
    }
</script>
    
    <?php }
	 ?>


 