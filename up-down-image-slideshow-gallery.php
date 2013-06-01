<?php

/*
Plugin Name: Up down image slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/
Description: Up down image slideshow gallery lets showcase images in a vertical move style. Single image at a time and pull one by one continually. This slideshow will pause on mouse over. The speed of the plugin gallery is customizable. Persistence of last viewed image supported, so when the user reloads the page, the slideshow continues from the last image.
Author: Gopi.R
Version: 10.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/
Tags: slidshow, gallery
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;
define("WP_udisg_TABLE", $wpdb->prefix . "udisg_plugin");
define("WP_udisg_UNIQUE_NAME", "ivrss");
define("WP_udisg_TITLE", "Up down image slideshow gallery");
define('WP_udisg_LINK', 'Check official website for more information <a target="_blank" href="http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/">click here</a>');
define('WP_udisg_FAV', 'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/');


function udisg() 
{
	global $wpdb;
	$udisg_package = "";
	$udisg_title = get_option('udisg_title');
	$udisg_width = get_option('udisg_width');
	$udisg_height = get_option('udisg_height');
	$udisg_pause = get_option('udisg_pause');
	$udisg_cycles = get_option('udisg_cycles');
	$udisg_persist = get_option('udisg_persist');
	$udisg_slideduration = get_option('udisg_slideduration');
	$udisg_random = get_option('udisg_random');
	$udisg_type = get_option('udisg_type');
	
	if(!is_numeric(@$udisg_width)) { @$udisg_width = 250 ;}
	if(!is_numeric(@$udisg_height)) { @$udisg_height = 200; }
	if(!is_numeric(@$udisg_pause)) { @$udisg_pause = 2000; }
	if(!is_numeric(@$udisg_cycles)) { @$udisg_cycles = 5; }
	if(!is_numeric(@$udisg_slideduration)) { @$udisg_slideduration = 300; }
	
	$sSql = "select udisg_path,udisg_link,udisg_target,udisg_title from ".WP_udisg_TABLE." where 1=1";
	if($udisg_type <> ""){ $sSql = $sSql . " and udisg_type='".$udisg_type."'"; }
	if($udisg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY udisg_order"; }
	
	$data = $wpdb->get_results($sSql);
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$udisg_package = $udisg_package .'["'.$data->udisg_path.'", "'.$data->udisg_link.'", "'.$data->udisg_target.'"],';
		}
	}	
	$udisg_package = substr($udisg_package,0,(strlen($udisg_package)-1));
	
	?>
    <script type="text/javascript">

	var udisg_SlideShow=new udisg_Show({
		udisg_Wrapperid: "udisg_widgetss", 
		udisg_WidthHeight: [<?php echo $udisg_width; ?>, <?php echo $udisg_height; ?>], 
		udisg_ImageArray: [ <?php echo $udisg_package; ?> ],
		udisg_Displaymode: {type:'auto', pause:<?php echo $udisg_pause; ?>, cycles:<?php echo $udisg_cycles; ?>, pauseonmouseover:true},
		udisg_Orientation: "v", 
		udisg_Persist: <?php echo $udisg_persist; ?>, 
		udisg_Slideduration: <?php echo $udisg_slideduration; ?> 
	})
	
	</script>
    <div id="udisg_widgetss"></div>
    <?php

}

function udisg_install() 
{
	
	global $wpdb;
	
	if($wpdb->get_var("show tables like '". WP_udisg_TABLE . "'") != WP_udisg_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_udisg_TABLE . "` (";
		$sSql = $sSql . "`udisg_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`udisg_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`udisg_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`udisg_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_title` VARCHAR( 500 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_order` INT NOT NULL ,";
		$sSql = $sSql . "`udisg_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_extra1` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`udisg_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `udisg_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_udisg_TABLE . "` (`udisg_path`, `udisg_link`, `udisg_target` , `udisg_title` , `udisg_order` , `udisg_status` , `udisg_type` , `udisg_date`)"; 
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/up-down-image-slideshow-gallery/images/250x167_1.jpg', '#', '_blank', 'Image 1', '1', 'YES', 'Widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/up-down-image-slideshow-gallery/images/250x167_2.jpg' ,'#', '_blank', 'Image 2', '2', 'YES', 'Widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/up-down-image-slideshow-gallery/images/250x167_3.jpg', '#', '_blank', 'Image 3', '1', 'YES', 'Sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('".get_option('siteurl')."/wp-content/plugins/up-down-image-slideshow-gallery/images/250x167_4.jpg', '#', '_blank', 'Image 4', '2', 'YES', 'Sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);

	}

	add_option('udisg_title', "Up down slideshow");
	add_option('udisg_width', "250");
	add_option('udisg_height', "200");
	add_option('udisg_pause', "2000");
	add_option('udisg_cycles', "15");
	add_option('udisg_persist', "true");
	add_option('udisg_slideduration', "300");
	add_option('udisg_random', "YES");
	add_option('udisg_type', "Widget");
}

function udisg_control() 
{
	echo '<p>To change the setting goto <b>Left right slideshow</b> link under Settings menu. ';
	echo '<a href="options-general.php?page=up-down-image-slideshow-gallery">click here</a></p>';
	echo WP_udisg_LINK;
}

function udisg_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('udisg_Title');
	echo $after_title;
	udisg();
	echo $after_widget;
}

function udisg_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-management-edit.php');
			break;
		case 'add':
			include('pages/image-management-add.php');
			break;
		case 'set':
			include('pages/image-setting.php');
			break;
		default:
			include('pages/image-management-show.php');
			break;
	}
}

add_shortcode( 'up-slideshow', 'udisg_shortcode' );

function udisg_shortcode( $atts ) 
{
	global $wpdb;
	
	//[up-slideshow type="sample" width="250" height="170" pause="3000" random="YES"]
	if ( ! is_array( $atts ) ) { return ''; }
	$udisg_type = $atts['type'];
	$udisg_width = $atts['width'];
	$udisg_height = $atts['height'];
	$udisg_pause = $atts['pause'];
	$udisg_random = $atts['random'];

	$udisg_persist = get_option('udisg_persist');
	
	if($udisg_persist == "true")
	{
		$udisg_persist = "true";
	}
	else
	{
		$udisg_persist = "false";
	}
	
	$udisg_cycles = get_option('udisg_cycles');
	$udisg_slideduration = get_option('udisg_slideduration');
	
	if(!is_numeric(@$udisg_width)) { @$udisg_width = 250 ;}
	if(!is_numeric(@$udisg_height)) { @$udisg_height = 200; }
	if(!is_numeric(@$udisg_cycles)) { @$udisg_cycles = 5; }
	if(!is_numeric(@$udisg_slideduration)) { @$udisg_slideduration = 300; }
	if(!is_numeric(@$udisg_pause)) { @$udisg_pause = 2000; }
	
	$sSql = "select udisg_path,udisg_link,udisg_target,udisg_title from ".WP_udisg_TABLE." where 1=1";
	if($udisg_type <> ""){ $sSql = $sSql . " and udisg_type='".$udisg_type."'"; }
	if($udisg_random == "YES"){ $sSql = $sSql . " ORDER BY RAND()"; }else{ $sSql = $sSql . " ORDER BY udisg_order"; }
	
	$data = $wpdb->get_results($sSql);
	$udisg_package = "";
	$Lr = "";
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$udisg_package = $udisg_package .'["'.$data->udisg_path.'", "'.$data->udisg_link.'", "'.$data->udisg_target.'"],';
		}
		
		$udisg_package = substr($udisg_package,0,(strlen($udisg_package)-1));
		$udisg_pluginurl = get_option('siteurl') . "/wp-content/plugins/up-down-image-slideshow-gallery/";
		$type = "auto";
		$wrapperid = $udisg_type;
		$Lr = $Lr .'<script type="text/javascript">';
		$Lr = $Lr .'var udisg_SlideShow=new udisg_Show({udisg_Wrapperid: "'.$wrapperid.'",udisg_WidthHeight: ['.$udisg_width.', '.$udisg_height.'], udisg_ImageArray: [ '.$udisg_package.' ],udisg_Displaymode: {type:"'.$type.'", pause:'.$udisg_pause.', cycles:'.$udisg_cycles.', pauseonmouseover:true},udisg_Orientation: "v",udisg_Persist: '.$udisg_persist.',udisg_Slideduration: '.$udisg_slideduration.' })';
		$Lr = $Lr .'</script>';
		$Lr = $Lr .'<div id="'.$wrapperid.'"></div>';
	}	
	else
	{	
		$Lr = " Please check the short code ";
	}
		
	return $Lr;
}

function udisg_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Up down image slideshow gallery', 'Up down slideshow', 'manage_options', 'up-down-image-slideshow-gallery', 'udisg_admin_options' );
		//add_options_page('Up down image slideshow gallery', '', 'manage_options', "up-down-image-slideshow-gallery/image-management.php",'' );
	}
}

function udisg_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('up-down-image-slideshow-gallery', 'Up down image slideshow gallery', 'udisg_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('up-down-image-slideshow-gallery', array('Up down image slideshow gallery', 'widgets'), 'udisg_control');
	} 
}

function udisg_deactivation() 
{

}

function udisg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'up-down-image-slideshow-gallery', get_option('siteurl').'/wp-content/plugins/up-down-image-slideshow-gallery/inc/up-down-image-slideshow-gallery.js');
	}
}

add_action('wp_enqueue_scripts', 'udisg_add_javascript_files');
add_action("plugins_loaded", "udisg_init");
register_activation_hook(__FILE__, 'udisg_install');
register_deactivation_hook(__FILE__, 'udisg_deactivation');
add_action('admin_menu', 'udisg_add_to_menu');
?>