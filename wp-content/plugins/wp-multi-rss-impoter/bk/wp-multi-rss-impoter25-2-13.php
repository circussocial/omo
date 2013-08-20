<?php
/*
  Plugin Name:  WP Multi Rss Impoter
  Description: Plugins for manager Multi Rss Feed.
  Created By : Aashish Scripter
 */
ob_start();
define('WP_DEBUG', true);
// Hook for adding admin menus
add_action('admin_menu', 'wp_multi_rss_impoter');

function wp_multi_rss_impoter() {
    add_menu_page(__('Unilever Social Feeds', 'wp_multi_rss_impoter'), __('Unilever Social Feeds', 'menu-test'), 'manage_options', 'feedcategory', 'feedcategory');
	
	add_submenu_page('feedcategory', __('Edit Categories'), __('Edit Categories'), 'edit_themes', 'feedcategory', 'feedcategory');

    //add_submenu_page( 'feedcategory', 'Feed Category', 'Feed Category', 'manage_options', 'feedcategory', 'feedcategory' );
	
    add_submenu_page('feedcategory', 'Rss Feed ', 'Rss Feed ', 'manage_options', 'rmimanger', 'rmimanger');
    add_submenu_page('feedcategory', 'Twitter Feed', 'Twitter Feed', 'manage_options', 'addtwitter', 'addtwitter');
    add_submenu_page('feedcategory', 'Instagram Feed', 'Instagram Feed', 'manage_options', 'addinstagram', 'addinstagram');
    add_submenu_page('feedcategory', 'FaceBook Feed', 'FaceBook Feed', 'manage_options', 'addingfacebook', 'addingfacebook');
    add_submenu_page('feedcategory', 'Publish', 'Publish', 'manage_options', 'publishsection', 'publishsection');
    add_submenu_page('feedcategory', 'View Feed Data', 'View Feed Data', 'manage_options', 'viewfeeddata', 'viewfeeddata');
    
    add_submenu_page('feedcategory', 'Flagged Feeds', 'Flagged Feeds', 'manage_options', 'flaggedfeeds', 'flaggedfeeds');
    add_submenu_page('feedcategory', 'Edit Headline', 'Edit Headline', 'manage_options', 'setting', 'setting');
    add_submenu_page('feedcategory', 'Refresh', 'Refresh', 'manage_options', 'collectdata', 'collectdata');
	add_submenu_page('feedcategory', 'Publish View', 'Publish View', 'manage_options', 'publishview', 'publishview');
}

register_activation_hook(__FILE__, 'wp_multi_rss_impoter_install');

function wp_multi_rss_impoter_install() {   // Function for installation
    global $wpdb;
    $table_category = $wpdb->prefix . "multi_rss_category";
    $table_name = $wpdb->prefix . "multi_rss_feeds";
    $table_data = $wpdb->prefix . "multi_rss_feeds_data";

    $sql_cat = "CREATE TABLE $table_category (
  `MCID` int(15) NOT NULL auto_increment,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `inc` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `excl` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY  (`MCID`)
)";

    $sql = "CREATE TABLE $table_name (
  `catId` int(11) NOT NULL auto_increment,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL, 
  `cat` enum('instagram','twitter_search','twitter_name','rss','facebook') default 'rss',
  `mcatId` int(11) default NULL,
  PRIMARY KEY  (`catId`),
  KEY `fk_catId` (`mcatId`)
) ";
    $sql1 = " CREATE TABLE $table_data (
  `feedId` int(11) NOT NULL auto_increment,
  `feedtitle` varchar(255)  CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
  `feedLink` varchar(255)  CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
  `feedDesc` varchar(255)  CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
  `feedCat` int(11) default NULL,
  `feedImgThumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
  `isSticky` enum('0','1') default '0',
  `isHighlight` enum('0','1') default '0',
  `cat` enum('instagram','twitter_search','twitter_name','rss','facebook') default 'rss',
  `mcatId` int(11) default NULL,
  `createdon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci default NULL,
	  
  `isFlag` enum('0','1') default '0',
	  
  PRIMARY KEY  (`feedId`)
) ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_cat);
    dbDelta($sql);
    dbDelta($sql1);
}

function getcatname($cid) {
    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_category";
    $slqcat = "SELECT `name` FROM $tablename WHERE `MCID` = $cid ";

    $query = $wpdb->get_results($slqcat);

    return $query[0]->name;
}

function rmimanger() {
    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_feeds";
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'delete') {
        $ID = $_REQUEST['id'];
        if ($wpdb->query("DELETE FROM $tablename WHERE catId  ='" . $ID . "' LIMIT 1")) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=rmimanger');
        } else {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=rmimanger');
        }
    } elseif ($action == 'add') {
        include_once('add-feed.php');
    } elseif ($action == 'edit') {
        include_once('edit_feed.php');
    } else {
        ?>
        <div id="wpbody">
            <div id="wpbody-content">
                <div class="wrap">
                    <h2> RSS Feed <a href="admin.php?page=rmimanger&action=add">
                            <input type="button" name="addWynneMessage" class="button button-primary" value="Add Feed "/>
                        </a> </h2>
                    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="frmViewPlan" id="frmViewPlan">
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_feeds";
        $query = $wpdb->get_results("SELECT * FROM $tablename where cat ='rss'");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->catId;
            $mcatId = $result->mcatId;
            $mcatname = getcatname($mcatId);
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>
                                        <td class="view_plan_name column-view_plan_name"><?php echo ucfirst($mcatname); ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=rmimanger&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=rmimanger&action=delete&id=<?php echo $planID; ?>">                                                    
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>
                                    </tr>
            <?php $as++;
        } ?>
                            </tbody>
                        </table>
                    </form>
                    <div id ="textDiv"></div>
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
                </div>
            </div>
        </div>
        <?php
    }
}

function addtwitter() {
    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_feeds";
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'delete') {
        $ID = $_REQUEST['id'];
        if ($wpdb->query("DELETE FROM $tablename WHERE catId  ='" . $ID . "' LIMIT 1")) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addtwitter');
        } else {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addtwitter');
        }
    } elseif ($action == 'add') {
        include_once('add-tiwitter-feed.php');
    } elseif ($action == 'edit') {
        include_once('edit-tiwitter-feed.php');
    } else {
        ?>
        <div id="wpbody">
            <div id="wpbody-content">
                <div class="wrap">
                    <h2> Twitter Hashtags / Search Feed <a href="admin.php?page=addtwitter&action=add">
                            <input type="button" name="addWynneMessage" class="button button-primary" value="Add Feed "/>
                        </a> </h2>
                    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="frmViewPlan" id="frmViewPlan">
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_feeds";
        $query = $wpdb->get_results("SELECT * FROM $tablename where cat ='twitter_search'");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->catId;
            $mcatId = $result->mcatId;
            $mcatname = getcatname($mcatId);
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>
                                        <td class="view_plan_name column-view_plan_name"><?php echo ucfirst($mcatname); ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=addtwitter&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=addtwitter&action=delete&id=<?php echo $planID; ?>">
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>
                                    </tr>

                                    <?php $as++;
                                } ?>
                            </tbody>
                        </table>
                        <h2> Twitter User Feed </h2>
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_feeds";
        $query = $wpdb->get_results("SELECT * FROM $tablename where cat ='twitter_name'");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->catId;
            $mcatId = $result->mcatId;
            $mcatname = getcatname($mcatId);
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>
                                        <td class="view_plan_name column-view_plan_name"><?php echo ucfirst($mcatname); ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=addtwitter&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=addtwitter&action=delete&id=<?php echo $planID; ?>">
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>
                                    </tr>

                                    <?php $as++;
                                } ?>
                            </tbody>
                        </table>
                    </form>
                    <div id ="textDiv"></div>
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
                </div>
            </div>
        </div>
        <?php
    }
}

function addinstagram() {
    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_feeds";
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'delete') {
        $ID = $_REQUEST['id'];
        if ($wpdb->query("DELETE FROM $tablename WHERE catId ='" . $ID . "' LIMIT 1")) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addinstagram');
        } else {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addinstagram');
        }
    } elseif ($action == 'add') {
        include_once('add-instagram-feed.php');
    } elseif ($action == 'edit') {
        include_once('edit-instagram-feed.php');
    } else {
        ?>
        <div id="wpbody">
            <div id="wpbody-content">
                <div class="wrap">
                    <h2> Instagram Hashtags Search Feed <a href="admin.php?page=addinstagram&action=add">
                            <input type="button" name="addWynneMessage" class="button button-primary" value="Add Feed "/>
                        </a> </h2>
                    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="frmViewPlan" id="frmViewPlan">
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_feeds";
        $query = $wpdb->get_results("SELECT * FROM $tablename where cat='instagram' ");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->catId;
            $mcatId = $result->mcatId;
            $mcatname = getcatname($mcatId);
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>

                                        <td class="view_plan_name column-view_plan_name"><?php echo ucfirst($mcatname); ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=addinstagram&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=addinstagram&action=delete&id=<?php echo $planID; ?>">
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>

            <?php $as++;
        } ?>
                            </tbody>
                        </table>
                    </form>
                    <div id ="textDiv"></div>
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
                </div>
            </div>
        </div>
        <?php
    }
}

function feedcategory() {
    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_category";
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'delete') {
        $ID = $_REQUEST['id'];
        if ($wpdb->query("DELETE FROM $tablename WHERE MCID  ='" . $ID . "' LIMIT 1")) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=feedcategory');
        } else {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=feedcategory');
        }
    } elseif ($action == 'add') {
        include_once('add-category-feed.php');
    } elseif ($action == 'edit') {
        include_once('edit-category-feed.php');
    } else {
        ?>
        <div id="wpbody">
            <div id="wpbody-content">
                <div class="wrap">
                    <h2> Feed Category <a href="admin.php?page=feedcategory&action=add">
                            <input type="button" name="addWynneMessage" class="button button-primary" value="Add Category "/>
                        </a> </h2>
                    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="frmViewPlan" id="frmViewPlan">
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_category";
        $query = $wpdb->get_results("SELECT * FROM $tablename ");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->MCID;
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=feedcategory&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=feedcategory&action=delete&id=<?php echo $planID; ?>">
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>
                                    </tr>

            <?php $as++;
        } ?>
                            </tbody>
                        </table>
                    </form>
                    <div id ="textDiv"></div>
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
                </div>
            </div>
        </div>
                                <?php
                            }
                        }

                        function collectdata() {
                            include_once('collectdata.php');
                        }

                        function publishview() {
                            include_once('publishview.php');
                        }

                        function publishsection() {
                            include_once('publishsection.php');
                        }

                        function admin_head_settings() {
                            ?>
    <script type="text/javascript">
        function view_feeds_by_cat()
        {
            var str=document.getElementById("catName").value;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }else {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?= get_site_url(); ?>/wp-content/plugins/wp-multi-rss-impoter/getfeeds.php?catName="+str,true);
            xmlhttp.send();
        }
        function update_sticky(id,state)
        {
            var murl="<?= get_site_url(); ?>/wp-content/plugins/wp-multi-rss-impoter/saveData.php"
            murl=murl+"?rcId="+id+"&state="+state+"&type=sticky";
            document.getElementById("myFrame").src=murl
        }
        function update_highlighted(id,state)
        {
            var murl="<?= get_site_url(); ?>/wp-content/plugins/wp-multi-rss-impoter/saveData.php"
            murl=murl+"?rcId="+id+"&state="+state+"&type=highlight";
            document.getElementById("myFrame").src=murl
        }
    </script>
    <style type="text/css">
        .data-table{
            width:100%;
            height:auto;
        }
        .data-table td{
            height:35px;
        }
        .headerrow{
            background-color:#00105f;
            color:white;
            height:25px;

        }
        .headerrow td{
            border-right:solid 1px white;
        }
        .row2{
            background-color:#e9e9e9;
            height:35px;
        }
    </style> 
    <?php
}

add_action("admin_head", "admin_head_settings");

function viewfeeddata() {
    include('viewfeeddata.php');
}

function setting() {
    include('setting.php');
}

function flaggedfeeds() {
    include('flaggedfeeds.php');
}
function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date         = strtotime($date);
   
       // check validity of date
    if(empty($unix_date)) {   
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
} 


function ogilvy_rss_func() {

    global $wpdb;
    $siteurl = get_site_url();

    $Images_url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/defaultfeed.jpg';

    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';
    $feedFlag = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/feedFlag.png';


    $tablename = $wpdb->prefix . "multi_rss_feeds_data";

    $rss_publish_cat_str = get_option('rss_publish_cat');
    $rss_publish_cat_spotlight = get_option('rss_publish_cat_spotlight');

    $rss_publish_cat_arr = explode(",", $rss_publish_cat_str);

    $rss_cat_sticky_arr = '';
    $rss_sportlight_sticky_arr = '';
    $rss_feed_cat_arr = '';
    $cattablename = $wpdb->prefix . "multi_rss_category";

    if (!empty($rss_publish_cat_str)) {

        foreach ($rss_publish_cat_arr as $row) {

            $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
            $as = 1;
            foreach ($cat_arr as $catrow) {

                $inc = trim($catrow->inc);
                $excl = trim($catrow->excl);
                $image = $catrow->image;


                if (!empty($inc) && !empty($excl)) {
                    
                } else {
                    if (!empty($inc)) {
                        $inc_arr = explode(",", $inc);
                        $ie = 1;

                        $feedwere = '';
                        foreach ($inc_arr as $word) {
                            if ($ie == 1) {
                                $feedwere = "(`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                            } else {
                                $feedwere .= "OR (`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                            }

                            $ie++;
                        }
                        $incl = "SELECT * FROM $tablename WHERE $feedwere and (`isSticky` = '1' ) and  mcatId in ($catrow->MCID) ";

                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($incl);
                    } elseif (!empty($excl)) {
                        $excl_arr = explode(",", $excl);

                        $ie = 1;

                        $feedwere = '';
                        foreach ($excl_arr as $exclword) {
                            if ($ie == 1) {
                                $feedwere = "(`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                            } else {
                                $feedwere .= "OR (`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                            }

                            $ie++;
                        }

                        $exclude = "SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` = '1' ) and mcatId in ($catrow->MCID) ";

                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($exclude);
                    } else {
                        $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE (`isSticky` = "1" ) and  mcatId in (' . $catrow->MCID . ')';

                        $rss_cat_sticky_arr[$as]['image'] = $image;
                        $rss_cat_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                    }
                }
                $as++;
            }
        }
    }

    if (!empty($rss_publish_cat_spotlight)) {



        $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $rss_publish_cat_spotlight ");
        $as = 1;
        foreach ($cat_arr as $catrow) {

            $inc = trim($catrow->inc);
            $excl = trim($catrow->excl);
            $image = $catrow->image;



            if (!empty($inc) && !empty($excl)) {
                
            } else {
                if (!empty($inc)) {
                    $inc_arr = explode(",", $inc);
                    $ie = 1;

                    $feedwere = '';
                    foreach ($inc_arr as $word) {
                        if ($ie == 1) {
                            $feedwere = "(`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                        } else {
                            $feedwere .= "OR (`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                        }

                        $ie++;
                    }
                    $incl = "SELECT * FROM $tablename WHERE $feedwere and (`isSticky` = '1' ) and  mcatId in ($catrow->MCID) ";

                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($incl);
                } elseif (!empty($excl)) {
                    $excl_arr = explode(",", $excl);

                    $ie = 1;

                    $feedwere = '';
                    foreach ($excl_arr as $exclword) {
                        if ($ie == 1) {
                            $feedwere = "(`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                        } else {
                            $feedwere .= "OR (`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                        }

                        $ie++;
                    }

                    $exclude = "SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` = '1' ) and mcatId in ($catrow->MCID) ";

                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($exclude);
                } else {
                    $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE (`isSticky` = "1" ) and  mcatId in (' . $catrow->MCID . ')';

                    $rss_sportlight_sticky_arr[$as]['image'] = $image;
                    $rss_sportlight_sticky_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                }
            }
            $as++;
        }
    }

    if (!empty($rss_publish_cat_str)) {



        foreach ($rss_publish_cat_arr as $row) {

            $cat_arr = $wpdb->get_results("SELECT * FROM $cattablename where MCID = $row  ");
            $as = 1;
            foreach ($cat_arr as $catrow) {

                $inc = trim($catrow->inc);
                $excl = trim($catrow->excl);
                $image = $catrow->image;



                if (!empty($inc) && !empty($excl)) {
                    
                } else {
                    if (!empty($inc)) {
                        $inc_arr = explode(",", $inc);
                        $ie = 1;

                        $feedwere = '';
                        foreach ($inc_arr as $word) {
                            if ($ie == 1) {
                                $feedwere = "(`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                            } else {
                                $feedwere .= "OR (`feedtitle`  like '%$word%' and `feedDesc`  like '%$word%')";
                            }

                            $ie++;
                        }
                        $incl = "SELECT * FROM $tablename WHERE $feedwere and (`isSticky` != '1' ) and  mcatId in ($catrow->MCID) ";

                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($incl);
                    } elseif (!empty($excl)) {
                        $excl_arr = explode(",", $excl);

                        $ie = 1;

                        $feedwere = '';
                        foreach ($excl_arr as $exclword) {
                            if ($ie == 1) {
                                $feedwere = "(`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                            } else {
                                $feedwere .= "OR (`feedtitle` Not like '%$exclword%' and `feedDesc` Not like '%$exclword%')";
                            }

                            $ie++;
                        }

                        $exclude = "SELECT * FROM  $tablename  WHERE $feedwere and (`isSticky` != '1' ) and mcatId in ($catrow->MCID) ";

                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($exclude);
                    } else {
                        $rss_cat_sticky = 'SELECT * FROM ' . $tablename . ' WHERE (`isSticky` != "1" ) and  mcatId in (' . $catrow->MCID . ')';

                        $rss_feed_cat_arr[$as]['image'] = $image;
                        $rss_feed_cat_arr[$as]['data'] = $wpdb->get_results($rss_cat_sticky);
                    }
                }
                $as++;
            }
        }
    }

 $rss_publish_fontsize = get_option('rss_publish_fontsize');
  $rss_publish_divheight = get_option('rss_publish_divheight');
 $fontsize='32';
 $divheight='450';
 if(!empty($rss_publish_fontsize))
{$fontsize =$rss_publish_fontsize;}
if(!empty($rss_publish_divheight))
{$divheight =$rss_publish_divheight;}


    $rsshtml = '';

    $rsshtml .='<style>
  .feedWrapper{ border:2px solid #8a8a8a; margin:0 0 0 0;-webkit-border-radius: 12px;border-radius: 12px; }
.feedHead{background:url(http://ogilvyapplications.com/puneet/OMO/wp-content/plugins/wp-multi-rss-impoter/redRight.png) no-repeat right top; 
color:#fff; text-transform:uppercase; font-size:'.$fontsize.'px; font-weight:bold;font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; margin:0 0 19px 0;-webkit-border-radius: 12px 0px 0px 0px;border-radius: 12px 0px 0px 0px; }
.feedHead span{ background:url(http://ogilvyapplications.com/puneet/OMO/wp-content/plugins/wp-multi-rss-impoter/redLeft.png) no-repeat left; height:64px; display:block; padding:0 0 0 10px}
.feed_rss-output{ padding: 0px 0 20px 0px; position:relative; line-height:120%; margin:0 20px}
.feed_title{margin:0 30px 5px 80px !important;}
.feed_title, .feed_title a{ color:#000; font-size:12px; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; font-weight: bold;text-decoration:none}
.feed_title a:hover{ text-decoration:underline}
.wrapTime{ float:right; font-size:10px; position:absolute: right:0px; top:0px; width:95px; text-align:right}
.wrapTime img{ float:right; margin:5px 0 0 5px}
.feed_body{ color:#666666; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; font-size:11px; text-align:justify; margin:0 0 0 80px;}
.imagefix{ position:absolute; top:0px; left:0px; width:75px; float:left}
.rssicon {margin-top:20px;}
.isHighlight{ width:20px; float:right; position:absolute; margin:-10px 0 0 0; right:25px;}
.isSticky{width:20px; float:right; position:absolute; margin:-10px 0px 0 0; right:50px;}
.feedFlag{ width:20px; float:right; position:absolute; margin:-10px 0 0 0; right:0px;}
.feedWrap{ height:'.$divheight.'px; overflow:scroll;}
</style>';


    $rss_publish_main_title = get_option('rss_publish_main_title');
    $titlename = $rss_publish_main_title;
    if (empty($rss_publish_main_title)) {
        $titlename = '';
    }

    $rsshtml .='<div class="feedWrapper"><div class="feedHead">
	<span>' . $titlename . '</span>
</div> <div class="feedWrap">';


    if ($rss_sportlight_sticky_arr) {
        foreach ($rss_sportlight_sticky_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
                $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
                $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';
				
				
				 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
				 
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }

                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }

                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }

                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }
					
					$timeage = nicetime($row->createdon);

                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '" width="75px" height="75px" ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title"><a href="' . $row->feedLink . '" target="_blank">' . $row->feedtitle . '</a></div>';
			
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';
                $rsshtml .= '<div class="isSticky" ><img src="' . $isSticky . '"  ></div>';
                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
				
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
			
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
            }
        }
    }


    if ($rss_cat_sticky_arr) {
        foreach ($rss_cat_sticky_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
                $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
                $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';

                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }

                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }

                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }

		 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
				 
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }
				 $timeage = nicetime($row->createdon);

                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '" width="75px" height="75px" ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title"><a href="' . $row->feedLink . '" target="_blank">' . $row->feedtitle . '</a></div>';				
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';
                $rsshtml .= '<div class="isSticky" ><img src="' . $isSticky . '"  ></div>';
                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
            }
        }
    }
    if ($rss_feed_cat_arr) {
        foreach ($rss_feed_cat_arr as $catrow) {
            foreach ($catrow['data'] as $row) {
                $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offPin.png';
                $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/offStar.png';

                if (empty($row->feedImgThumb)) {
                    $row->feedImgThumb = $Images_url;
                }

                $flagedFeed = '';
                if ($row->isFlag == 1) {
                    $flagedFeed = 'flagedFeed';
                }
                if ($row->isSticky == 1) {
                    $isSticky = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onPin.png';
                }
                if ($row->isHighlight == 1) {
                    $isHighlight = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/onStar.png';
                }

                if (empty($row->feedImgThumb)) {
                    if (!empty($rowcat['image'])) {
                        $row->feedImgThumb = $rowcat['image'];
                    } else {
                        $row->feedImgThumb = $Images_url;
                    }
                }
$icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
				 
				 switch($row->cat)
				 {
					 case 'instagram':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniInsta.png';
					 break;
					 case 'twitter_search':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'twitter_name':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/minitwitter.png';
					 break;
					 case 'facebook':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniFB.png';
					 break;
					 case 'rss':
					 $icenrss = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/miniRSS.png';
					 break;
				 }
				 $timeage = nicetime($row->createdon);

                $rsshtml .= '<div class="feed_rss-output ' . $flagedFeed . '  " id="div_' . $row->feedId . '">';
                $rsshtml .= '<div class="imagefix"><img src="' . rawurldecode($row->feedImgThumb) . '" width="75px" height="75px" ></div>';
				$rsshtml .= '<div class="wrapTime" >';
				$rsshtml .= '<div class="timeage" >'.$timeage.' <img src="' .$icenrss. '" ></div>';
				$rsshtml .= '</div>';
                $rsshtml .= '<div class="feed_title"><a href="' . $row->feedLink . '" target="_blank">' . $row->feedtitle . '</a></div>';
				
                $rsshtml .= '<div class="feed_body">' . $row->feedDesc . '</div>';
                $rsshtml .='<div class="rssicon">';

                $rsshtml .= '<div class="feedFlag"  ><a href="' . get_site_url() . '/wp-content/plugins/wp-multi-rss-impoter/flagData.php?rcId=' . $row->feedId . '" target="mdisFrame"><img src="' . $feedFlag . '"  ></a></div>';
                $rsshtml .= '<div class="isHighlight" ><img src="' . $isHighlight . '" ></div>';
				
                $rsshtml .= '</div>';
                $rsshtml .= '</div>';
            }
        }
    }

    $rsshtml .= '</div><iframe width="100" height="100" style="display:none" name="mdisFrame" id="mdisFrame"></iframe></div>';
    return $rsshtml;
}

add_shortcode('ogilvy_rss', 'ogilvy_rss_func');

add_filter('widget_text', 'do_shortcode');

function addingfacebook() {

    global $wpdb;
    $tablename = $wpdb->prefix . "multi_rss_feeds";
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if ($action == 'delete') {
        $ID = $_REQUEST['id'];
        if ($wpdb->query("DELETE FROM $tablename WHERE catId  ='" . $ID . "' LIMIT 1")) {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addingfacebook');
        } else {
            wp_redirect(get_option('siteurl') . '/wp-admin/admin.php?page=addingfacebook');
        }
    } elseif ($action == 'add') {
        include_once('addingfacebook.php');
    } elseif ($action == 'edit') {
        include_once('editingfacebook.php');
    } else {
        ?>
        <div id="wpbody">
            <div id="wpbody-content">
                <div class="wrap">
                    <h2> Facebook Feeds <a href="admin.php?page=addingfacebook&action=add">
                            <input type="button" name="addWynneMessage" class="button button-primary" value="Add Feed "/>
                        </a> </h2>
                    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post" name="frmViewPlan" id="frmViewPlan">
                        <table class="wp-list-table widefat fixed users" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>Feed</span></a></th>
                                    <th scope='col' id='view_plan_name' class='manage-column column-view_plan_name'  style=""><a href=""><span>category</span></a></th>
                                    <th scope='col' id='view_plan_action' class='manage-column column-view_plan_action'  style=""><span>Action</span></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class='list:user'>
        <?php
        $tablename = $wpdb->prefix . "multi_rss_feeds";
        $query = $wpdb->get_results("SELECT * FROM $tablename where cat ='facebook'");
        $as = 1;
        foreach ($query as $result) {
            $planID = $result->catId;
            $mcatId = $result->mcatId;
            $mcatname = getcatname($mcatId);
            ?>
                                    <tr id='user-15' class="alternate">
                                        <td class="view_plan_name column-view_plan_name"><?php echo $result->name; ?></td>
                                        <td class="view_plan_name column-view_plan_name"><?php echo ucfirst($mcatname); ?></td>
                                        <td class="doview column-doview"><a href="admin.php?page=addingfacebook&action=edit&id=<?php echo $planID; ?>">
                                                <input type="button" name="view_message_edit" id="view_message_edit" class="button action" value="Edit"/>
                                            </a>&nbsp; | &nbsp; <a onclick="return confirmSubmit();" href="admin.php?page=addingfacebook&action=delete&id=<?php echo $planID; ?>">                                                    
                                                <input type="button" name="" id="view_message_delete_<?php echo $planID; ?>" class="button action delete" value="Delete"/>
                                            </a></td>
                                    </tr>
                                    </tr>
            <?php $as++;
        } ?>
                            </tbody>
                        </table>
                    </form>
                    <div id ="textDiv"></div>
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
                </div>
            </div>
        </div>
        <?php
    }
}
?>
