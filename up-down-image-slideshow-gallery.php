<?php

/*
Plugin Name: Up down image slideshow gallery
Plugin URI: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/
Description: Up down image slideshow gallery lets showcase images in a vertical move style. Single image at a time and pull one by one continually. This slideshow will pause on mouse over. The speed of the plugin gallery is customizable. Persistence of last viewed image supported, so when the user reloads the page, the slideshow continues from the last image.
Author: Gopi.R
Version: 2.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/
Tags: 
*/

global $wpdb, $wp_version;
define("WP_udisg_TABLE", $wpdb->prefix . "udisg_plugin");

function udisg() 
{
	
	global $wpdb;
	
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
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_1.jpg', 'http://www.gopiplus.com/work/2011/04/22/wordpress-plugin-wp-fadein-text-news/', '_blank', 'Image 1', '1', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg' ,'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/', '_blank', 'Image 2', '2', 'YES', 'widget', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_3.jpg', 'http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/', '_blank', 'Image 3', '1', 'YES', 'sample', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		
		$sSql = $IsSql . " VALUES ('http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_4.jpg', 'http://www.gopiplus.com/work/2010/10/10/superb-slideshow-gallery/', '_blank', 'Image 4', '2', 'YES', 'sample', '0000-00-00 00:00:00');";
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
	add_option('udisg_type', "widget");

}

function udisg_control() 
{
	echo '<p>Up down image slideshow gallery.<br><br> To change the setting goto "Left right slideshow" link under SETTING menu. ';
	echo '<a href="options-general.php?page=up-down-image-slideshow-gallery/up-down-image-slideshow-gallery.php">click here</a></p>';
	echo '<a target="_blank" href="http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/">Click here</a> for more help.<br>';
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
	
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo wp_specialchars( "Up down image slideshow gallery" ) ;
	echo "</h2>";
	$udisg_title = get_option('udisg_title');
	$udisg_width = get_option('udisg_width');
	$udisg_height = get_option('udisg_height');
	$udisg_pause = get_option('udisg_pause');
	$udisg_cycles = get_option('udisg_cycles');
	$udisg_persist = get_option('udisg_persist');
	$udisg_slideduration = get_option('udisg_slideduration');
	$udisg_random = get_option('udisg_random');
	$udisg_type = get_option('udisg_type');
	
	if ($_POST['udisg_submit']) 
	{
		$udisg_title = stripslashes($_POST['udisg_title']);
		$udisg_width = stripslashes($_POST['udisg_width']);
		$udisg_height = stripslashes($_POST['udisg_height']);
		$udisg_pause = stripslashes($_POST['udisg_pause']);
		$udisg_cycles = stripslashes($_POST['udisg_cycles']);
		$udisg_persist = stripslashes($_POST['udisg_persist']);
		$udisg_slideduration = stripslashes($_POST['udisg_slideduration']);
		$udisg_random = stripslashes($_POST['udisg_random']);
		$udisg_type = stripslashes($_POST['udisg_type']);

		update_option('udisg_title', $udisg_title );
		update_option('udisg_width', $udisg_width );
		update_option('udisg_height', $udisg_height );
		update_option('udisg_pause', $udisg_pause );
		update_option('udisg_cycles', $udisg_cycles );
		update_option('udisg_persist', $udisg_persist );
		update_option('udisg_slideduration', $udisg_slideduration );
		update_option('udisg_random', $udisg_random );
		update_option('udisg_type', $udisg_type );
	}
	
	echo '<form name="udisg_form" method="post" action="">';

	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $udisg_title . '" name="udisg_title" id="udisg_title" /> Widget title.</p>';

	echo '<p>Width:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $udisg_width . '" name="udisg_width" id="udisg_width" /> Widget Width (only number).</p>';

	echo '<p>Height:<br><input  style="width: 100px;" maxlength="200" type="text" value="';
	echo $udisg_height . '" name="udisg_height" id="udisg_height" /> Widget Height (only number).</p>';

	echo '<p>Pause:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $udisg_pause . '" name="udisg_pause" id="udisg_pause" /> Only Number / Pause between content change (millisec).</p>';

	echo '<p>Cycles :<br><input  style="width: 100px;" type="text" value="';
	echo $udisg_cycles . '" name="udisg_cycles" id="udisg_cycles" /> (only number)</p>';
	
	echo '<p>Persist:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $udisg_persist . '" name="udisg_persist" id="udisg_persist" /></p>';

	echo '<p>Slideduration :<br><input  style="width: 100px;" type="text" value="';
	echo $udisg_slideduration . '" name="udisg_slideduration" id="udisg_slideduration" /></p>';

	echo '<p>Random :<br><input  style="width: 100px;" type="text" value="';
	echo $udisg_random . '" name="udisg_random" id="udisg_random" /> (YES/NO)</p>';

	echo '<p>Type:<br><input  style="width: 150px;" type="text" value="';
	echo $udisg_type . '" name="udisg_type" id="udisg_type" /> This field is to group the images.</p>';

	echo '<input name="udisg_submit" id="udisg_submit" class="button-primary" value="Submit" type="submit" />';

	echo '</form>';
	
	echo '</div>';
	?>
    <div style="float:right;">
	<input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
    <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/up-down-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
    </div>
    <?php
	include("inc/help.php");
}

add_filter('the_content','udisg_Show_Filter');

function udisg_Show_Filter($content)
{
	return 	preg_replace_callback('/\[UD_IMAGE_GALLERY:(.*?)\]/sim','udisg_Show_Filter_Callback',$content);
}

function udisg_Show_Filter_Callback($matches) 
{
	global $wpdb;
	
	$scode = $matches[1];
	
	list($udisg_type_main, $udisg_width_main, $udisg_height_main, $udisg_pause_main, $udisg_random_main) = split("[:.-]", $scode);

	list($udisg_type_cap, $udisg_type) = split('[=.-]', $udisg_type_main);
	list($udisg_width_cap, $udisg_width) = split('[=.-]', $udisg_width_main);
	list($udisg_height_cap, $udisg_height) = split('[=.-]', $udisg_height_main);
	list($udisg_pause_cap, $udisg_pause) = split('[=.-]', $udisg_pause_main);
	list($udisg_random_cap, $udisg_random) = split('[=.-]', $udisg_random_main);

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
	
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$udisg_package = $udisg_package .'["'.$data->udisg_path.'", "'.$data->udisg_link.'", "'.$data->udisg_target.'"],';
		}
	}	
	$udisg_package = substr($udisg_package,0,(strlen($udisg_package)-1));
	
	$udisg_pluginurl = get_option('siteurl') . "/wp-content/plugins/up-down-image-slideshow-gallery/";
	
	$type = "auto";
	
	$wrapperid = $udisg_type;
	
   // $Lr = $Lr .'<script type="text/javascript" src="'.$udisg_pluginurl.'/inc/jquery.min.js"><script>';
   // $Lr = $Lr .'<script type="text/javascript" src="'.$udisg_pluginurl.'/inc/up-down-image-slideshow-gallery.js"><script>';
    $Lr = $Lr .'<script type="text/javascript">';

	$Lr = $Lr .'var udisg_SlideShow=new udisg_Show({udisg_Wrapperid: "'.$wrapperid.'",udisg_WidthHeight: ['.$udisg_width.', '.$udisg_height.'], udisg_ImageArray: [ '.$udisg_package.' ],udisg_Displaymode: {type:"'.$type.'", pause:'.$udisg_pause.', cycles:'.$udisg_cycles.', pauseonmouseover:true},udisg_Orientation: "v",udisg_Persist: '.$udisg_persist.',udisg_Slideduration: '.$udisg_slideduration.' })';
	
	$Lr = $Lr .'</script>';
    $Lr = $Lr .'<div id="'.$wrapperid.'"></div>';
   
		
	return $Lr;
}

function udisg_add_to_menu() 
{
	add_options_page('Up down image slideshow gallery', 'Up down slideshow', 'manage_options', __FILE__, 'udisg_admin_options' );
	add_options_page('Up down image slideshow gallery', '', 'manage_options', "up-down-image-slideshow-gallery/image-management.php",'' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'udisg_add_to_menu');
}

function udisg_init()
{
	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Up down image slideshow gallery', 'udisg_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Up down image slideshow gallery', 'widgets'), 'udisg_control');
	} 
}

function udisg_deactivation() 
{

}

function Lrisg_add_javascript_files() 
{
	wp_enqueue_script( 'jquery.min', get_option('siteurl').'/wp-content/plugins/up-down-image-slideshow-gallery/inc/jquery.min.js');
	wp_enqueue_script( 'up-down-image-slideshow-gallery', get_option('siteurl').'/wp-content/plugins/up-down-image-slideshow-gallery/inc/up-down-image-slideshow-gallery.js');
}

add_action('init', 'Lrisg_add_javascript_files');

add_action("plugins_loaded", "udisg_init");
register_activation_hook(__FILE__, 'udisg_install');
register_deactivation_hook(__FILE__, 'udisg_deactivation');
add_action('admin_menu', 'udisg_add_to_menu');


?>
