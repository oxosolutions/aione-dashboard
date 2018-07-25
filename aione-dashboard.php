<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       Aione Dashboard
 * Plugin URI:        http://oxosolutions.com/products/wordpress-plugins/aione-dashboard/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0.0
 * Author:            OXO Solutions®
 * Author URI:        https://oxosolutions.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       aione-dashboard
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/oxosolutions/aione-dashboard
 * GitHub Branch: master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Add a widget in WordPress Dashboard
function dashboard_widget_account_function() {
	$pro_sites_object = new ProSites();
	$pro_sites_level = $pro_sites_object->get_level();
	$site_levels = get_site_option('psts_levels');
	$current_plan = '';
	$level = 1;
	
	echo "Website Pro Level: ".$pro_sites_level;
	echo "<br>Website Pro Plan: ".$site_levels [$pro_sites_level ]['name'];
	echo "<br>Package Pricing: Monthly ".$site_levels [$pro_sites_level ]['price_1'];
	echo ", Quarterly: ".$site_levels [$pro_sites_level ]['price_3'];
	echo ", Annually: ".$site_levels [$pro_sites_level ]['price_12'];
	
	echo '<ul class="site-levels">';
	foreach ($site_levels as $site_level){
		if($level == $pro_sites_level) { $current_plan = 'current'; } else { $current_plan = '';}
		echo '<li class="'.$current_plan.'"><div class="site-level">';
		echo '<h1 class="site-level-title">'.$site_level['name'].'</h1>';
		if($level == $pro_sites_level) { 
			echo '<p class="site-level-desc">Current Plan</p>'; 
		} else {
			echo '<a href="#plan_'.$level.'"><p class="site-level-desc">Plan Details</p></a>'; 		
		}
		//print_r($site_level);

		
		echo '</div></li>';
		$level++;
	}
	echo '</ul>
	<style>
	.site-levels{  
		display: table;
		width: 100%;
		text-align: center;
	}
	.site-levels li{  
		display: table-cell;
		padding:0 2px;
	}
	.site-levels .site-level{  
		text-align: center;
		padding:10px;
		min-height: 45px;
		background-color:#FFFFFF;
		-moz-box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
		-webkit-box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
		box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
	}
	.site-levels .current .site-level{  
		background-color:#168dc5;
	}
	.site-levels .site-level .site-level-title{
		font-size:18px;	
		font-weight:100;
		color:#168dc5;
		margin: 0 0 8px;
	}
	
	.site-levels .current .site-level-title{
		color:#FFFFFF;
	}
	.site-levels .site-level-desc{
		border-top: 1px solid #168dc5;
		color: #168dc5;
		display: inline-block;
		font-size: 11px;
		font-weight: 100;
		margin: 0;
	}
	.site-levels .current .site-level-desc{
		border-top: 1px solid #ffffff;
		color: #ffffff;
	}	
	</style>
	';
		
		

    //echo "Site Level ".$pro_sites_level;
    
    
        
	$level2 = get_site_option('psts_settings','expire ');
	//$levels2 = $pro_sites_object->get_setting();
	
	echo "<pre>";
	//var_dump($levels);
	
	//echo "----------------------------";
	
	//var_dump($levels2);
	//echo $levels2;
	echo "</pre>";



    //$levels1 = $psObj->get_level_setting($proLevel,'',false);



    //global $wpdb;
    //$blog_id = $wpdb->blogid;


    global $wpdb, $psts;
    if ( empty( $blog_id ) ){$blog_id = $wpdb->blogid;}

    //echo "<br>Site ID ".$blog_id;

    //echo "<br>PSTS ".$psts;

    echo "<pre>";
    //var_dump($psts);
    echo "</pre>";

    /*
    if ( is_pro_site($blog_id, $psts->1) || $this->check($blog_id) ) {
        echo "<br>Site ID ".$blog_id. "<br>Site Level 1".$proLevel;
    } else if ( is_pro_site($blog_id, $psts->2) || $this->check($blog_id) ) {
        echo "<br>Site ID ".$blog_id. "<br>Site Level 2".$proLevel;
    } else if ( is_pro_site($blog_id, $psts->3) || $this->check($blog_id) ) {
        echo "<br>Site ID ".$blog_id. "<br>Site Level 3".$proLevel;
    }
    */


    if (psts_show_ads()) {
        echo "<br>Ad Content Ad Content Ad Content Ad Content Ad Content Ad Content Ad Content Ad Content Ad Content Ad Content ";
    }

    //$proLevel is now an int of the current site's level


// Entering the text between the quotes
    //echo "<ul>	<li>Release Date: March 2012</li>	<li>Author: Aurelien Denis.</li>	<li>Hosting provider: my own server</li>	</ul>";
}
function add_dashboard_widget_account() {
    wp_add_dashboard_widget('wp_dashboard_widget_account', 'Account', 'dashboard_widget_account_function');
}
add_action('wp_dashboard_setup', 'add_dashboard_widget_account' );



/*********************************************************************************************
 *
 *  Dashboard Content Widget
 *
 *********************************************************************************************/


function aione_dashboard_widget_content() {
	
	$post_types = get_post_types( '', 'names' ); 
	$post_type_row_counter = 1;
	echo '<table style="width:100%;"><tbody>';
	$row_class = '';
	
	foreach ( $post_types as $post_type ) {
	
		$count_posts = wp_count_posts($post_type);
		$published_posts = $count_posts->publish;
		
		if($post_type_row_counter%2){ $row_class = ' class="alternate"';} else { $row_class = '';}
		if(1){
		echo '<tr '.$row_class.'>';
		$post_type_title = ucwords(str_replace('_',' ',$post_type));
		echo '<td>'.$post_type_title.'s('.$published_posts.')</td>';
		echo '<td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/edit.php?post_type='.$post_type.'">Edit '.$post_type_title.'s</a></td>';
		echo '<td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/post-new.php?post_type='.$post_type.'">Add New '.$post_type_title.'</a></td>';
		echo '</tr>';
		
		$post_type_row_counter++;
		}
		  
	}
	echo '</tbody></table>';

}
function add_dashboard_widget_content() {
    wp_add_dashboard_widget('wp_dashboard_widget_content', 'Website Content', 'aione_dashboard_widget_content');
}

add_action('wp_dashboard_setup', 'add_dashboard_widget_content' );

/*********************************************************************************************
 *
 *  Dashboard Information Widget
 *
 *********************************************************************************************/
function aione_dashboard_widget_info() {
  
    $filter ='raw';
    echo '<table style="width:100%;"><tbody>';
    echo '<tr><td>Site Title : </td><td>'.get_bloginfo('name', $filter).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr class="alternate"><td>Tag555552line : </td><td>'.get_bloginfo('description', $filter).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr><td>Admin E-mail : </td><td>'.get_bloginfo('admin_email', $filter).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr class="alternate"><td>Language : </td><td>'.get_bloginfo('language', $filter).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr><td>Date Format : </td><td>'.date(get_option('date_format')).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr class="alternate"><td>Time Format : </td><td>'.date(get_option('time_format')).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';
    echo '<tr><td>Timezone : </td><td>'.get_option('gmt_offset').' '.get_option('timezone_string').'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/wp-admin/options-general.php">Edit</a></td></tr>';  
    echo '<tr class="alternate"><td>Website URL : </td><td>'.get_bloginfo('url', $filter).'</td><td><a class="website-info_link" href="'.get_bloginfo('url', $filter).'/" target="_blank">Visit</a></td></tr>';
    echo '</tbody></table>';
}
function add_dashboard_widget_info() {
    wp_add_dashboard_widget('wp_dashboard_widget_info', 'Website Information', 'aione_dashboard_widget_info');
}
add_action('wp_dashboard_setup', 'add_dashboard_widget_info' );




/*
do_action( 'wp_dashboard_setup' );



// Function that outputs the contents of the dashboard widget
function dashboard_widget_function( $post, $callback_args ) {
	echo "Hello World, this is my first Dashboard Widget!";
}

// Function used in the action hook
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Example Dashboard Widget', 'dashboard_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

*/


//HIDING UNWANTED WORDPRESS DASHBOARD WIDGETS
/*
add_action('admin_init', 'wpc_dashboard_widgets');
function wpc_dashboard_widgets() {
    global $wp_meta_boxes;
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    //remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);


    echo "<pre>";
    var_dump($wp_meta_boxes);
    echo "</pre>";

    /*

	global $wp_meta_boxes;
	// Today widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	// Last comments
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	// Incoming links
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	// Plugins
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_wordpress_news']);


}
*/


function remove_dashboard_meta() {


    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    //remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'remove_dashboard_meta' );