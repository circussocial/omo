<?php 

global $wpdb;



$cattablename = $wpdb->prefix."multi_rss_category";



 $query=$wpdb->get_results("SELECT MCID,name FROM $cattablename ");

  

 if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['rss_publich'])) {

	 

														

									update_option('rss_publish_main_title',$_POST['maintitle']);
									update_option('rss_publish_fontsize',$_POST['fontsize']);
									update_option('rss_publish_divheight',$_POST['divheight']);

	 $massage =1;

 }

 

 

 

 if($massage==1){echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p>	</div>';		}?>

<?php   
 $rss_publish_main_title = get_option('rss_publish_main_title');
 $rss_publish_fontsize = get_option('rss_publish_fontsize');
 $rss_publish_divheight = get_option('rss_publish_divheight');

 $titlename = $rss_publish_main_title;

if(empty($rss_publish_main_title))
{$titlename ='';}

$fontsize='32';
$divheight='450';

if(!empty($rss_publish_fontsize))
{$fontsize =$rss_publish_fontsize;}

if(!empty($rss_publish_divheight))
{$divheight =$rss_publish_divheight;}
?>



<h2>Edit Headline</h2>



<form action="<?php echo $_SERVER['PHP_SELF'].'?page=setting'; ?>" method="post">

           <table class="wp-list-table widefat fixed users" cellspacing="0">



                           <thead>



                            <tr>



                                 



                                <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

								<th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Field</span></a></th>

           



                        



                            </tr>



                            </thead>



                            <tfoot>



                                <tr>



                                 

      						  <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Title</span></a></th>

								<th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Field</span></a></th>



                                </tr>



                            </tfoot>

                             <tbody id="the-list" class='list:user'>



      

           <tr id='user-15' class="alternate">

    				 <tr class="form-field">

                    <th scope="row">

                        <label for="emessage">

                            Title

                        </label>

                        <td>

                            <input name="maintitle" type="text" id="title" value="<?php echo $titlename ; ?>"/>

                        </td>

                    </th>

                </tr>
                <tr class="form-field">

                    <th scope="row">

                        <label for="emessage">

                            Box Heading Title Size

                        </label>

                        <td>

                            <input name="fontsize" type="text" id="title" size="5" value="<?php echo $fontsize ; ?>" style="width:80px"/>px

                        </td>

                    </th>

                </tr>
                <tr class="form-field">

                    <th scope="row">

                        <label for="emessage">

                           Box Height

                        </label>

                        <td>

                            <input name="divheight" type="text" id="title" size="5" value="<?php echo $divheight ; ?>"  style="width:80px"/>px

                        </td>

                    </th>

                </tr>

            </tr>

	



 </tbody>

 </table>





                

                <br /><br />

 <input type="submit" name="rss_publich" value="Submit"  />

</form>



 