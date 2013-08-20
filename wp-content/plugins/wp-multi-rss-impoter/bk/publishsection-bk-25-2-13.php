<?php 
global $wpdb;

$cattablename = $wpdb->prefix."multi_rss_category";

 $query=$wpdb->get_results("SELECT MCID,name FROM $cattablename ");
  
 if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['rss_publich'])) {
	 
							$cid_str='';
										if(is_array($_POST['id_arr']))
										{
											$cid_str = implode(",", $_POST['id_arr']);
										}
										//echo $cid_str;
										
										update_option('rss_publish_cat',$cid_str);
										update_option('rss_publish_cat_spotlight',$_POST['feedcategory']);
	 $massage =1;
 }
 
 
 
 if($massage==1){echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p>	</div>';		}?>


<h2>Cetegory Selection</h2>

<form action="<?php echo $_SERVER['PHP_SELF'].'?page=publishsection'; ?>" method="post">
           <table class="wp-list-table widefat fixed users" cellspacing="0">

                           <thead>

                            <tr>

                                 

                                <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Categert</span></a></th>

           

                        

                            </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                 
      				 <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Categert</span></a></th>

                                </tr>

                            </tfoot>
                             <tbody id="the-list" class='list:user'>
<?php 
								
		 $rss_publish_cat_str = get_option('rss_publish_cat');
		$rss_publish_cat_arr = explode(",", $rss_publish_cat_str);
		$aashish = 1;
	
		foreach($rss_publish_cat_arr as $row)
		{
			$rss_arr[$aashish]= $row;
			$aashish++;
		}				
		
								 
 foreach ($query as $row){ 
  
 
 
 $checked ='';																																			
	  $keys = array_search($row->MCID, $rss_arr);
	  if($keys){$checked = 'checked="checked"';}
	  ?>
      
           <tr id='user-15' class="alternate">
            <?php echo '<td class="view_plan_name column-view_plan_name"><input type="checkbox" id="id_'.$row->MCID.'" name="id_arr[]" value="'.$row->MCID.'" '. $checked.'   />  &nbsp;'.ucfirst($row->name).'</td>';
			
			 ?>
            </tr>
	  			 
	<?php 			

	 }

 ?>

 </tbody>
 </table>
 <br /><br />
  <?php   $rss_publish_cat_spotlight = get_option('rss_publish_cat_spotlight');?>
<tr class="form-field">
                    <th scope="row">
                        <label for="emessage">
                            Spotlight
                        </label>
                        <td>
                            <select name="feedcategory">
                            
                            <option value="0" >Select Category</option>
                            <?php 				
								$cattablename = $wpdb->prefix."multi_rss_category";
						
								 $query=$wpdb->get_results("SELECT MCID,name FROM $cattablename ");
								
								foreach( $query as $rows)
								{			$selectddl='';
										if($rss_publish_cat_spotlight == $rows->MCID){$selectddl = 'selected="selected"';}
									echo '<option value="'.$rows->MCID.'"  '.$selectddl.'>'.$rows->name.'</option>';	
								}
							?>
                            
                            </select>
                        </td>
                    </th>
                </tr>
                
                <br /><br />
 <input type="submit" name="rss_publich" value="Submit"  />
</form>

<br>
											<h3><?php _e("Short Code", 'wp-rss-multi-importer')?></h3>
<p ><label class='o_textinput' for='showsocial'><?php _e("Use This Short code <strong>[ogilvy_rss]</strong> For Show Ogilvy Multi RSS.", 'wp-rss-multi-importer')?></label>
</p>
<p ><?php _e("[ogilvy_rss]", 'wp-rss-multi-importer')?></p>