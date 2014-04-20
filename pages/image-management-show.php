<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_udisg_display']) && $_POST['frm_udisg_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$udisg_success = '';
	$udisg_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_udisg_TABLE."
		WHERE `udisg_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'udisg'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('udisg_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_udisg_TABLE."`
					WHERE `udisg_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$udisg_success_msg = TRUE;
			$udisg_success = __('Selected record was successfully deleted.', 'udisg');
		}
	}
	
	if ($udisg_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $udisg_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Up down image slideshow gallery', 'udisg'); ?>
	<a class="add-new-h2" href="<?php echo WP_UDISG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'udisg'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_udisg_TABLE."` order by udisg_type, udisg_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_UDISG_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_udisg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="udisg_group_item[]" /></th>
			<th scope="col"><?php _e('Group/Type', 'udisg'); ?></th>
			<th scope="col"><?php _e('Reference', 'udisg'); ?></th>
            <th scope="col"><?php _e('URL', 'udisg'); ?></th>
			<th scope="col"><?php _e('Target', 'udisg'); ?></th>
            <th scope="col"><?php _e('Order', 'udisg'); ?></th>
            <th scope="col"><?php _e('Display', 'udisg'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" name="udisg_group_item[]" /></th>
			<th scope="col"><?php _e('Group/Type', 'udisg'); ?></th>
			<th scope="col"><?php _e('Reference', 'udisg'); ?></th>
            <th scope="col"><?php _e('URL', 'udisg'); ?></th>
			<th scope="col"><?php _e('Target', 'udisg'); ?></th>
            <th scope="col"><?php _e('Order', 'udisg'); ?></th>
            <th scope="col"><?php _e('Display', 'udisg'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['udisg_id']; ?>" name="udisg_group_item[]"></td>
						<td>
						<strong><?php echo esc_html(stripslashes($data['udisg_type'])); ?></strong>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo WP_UDISG_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['udisg_id']; ?>"><?php _e('Edit', 'udisg'); ?></a> | </span>
							<span class="trash"><a onClick="javascript:udisg_delete('<?php echo $data['udisg_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'udisg'); ?></a></span> 
						</div>
						</td>
						<td><?php echo esc_html(stripslashes($data['udisg_title'])); ?></td>
						<td><a href="<?php echo $data['udisg_path']; ?>" target="_blank"><?php echo $data['udisg_path']; ?></a></td>
						<td><?php echo esc_html(stripslashes($data['udisg_target'])); ?></td>
						<td><?php echo esc_html(stripslashes($data['udisg_order'])); ?></td>
						<td><?php echo esc_html(stripslashes($data['udisg_status'])); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				}
			}
			else
			{
				?><tr><td colspan="6" align="center"><?php _e('No records available', 'udisg'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('udisg_form_show'); ?>
		<input type="hidden" name="frm_udisg_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_UDISG_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'udisg'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_UDISG_ADMIN_URL; ?>&amp;ac=set"><?php _e('Widget setting', 'udisg'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_UDISG_FAV; ?>"><?php _e('Help', 'udisg'); ?></a>
	  </h2>
	  </div>
	  <br />
	<p class="description">
		<?php _e('Check official website for more information', 'udisg'); ?>
		<a target="_blank" href="<?php echo WP_UDISG_FAV; ?>"><?php _e('click here', 'udisg'); ?></a>
	</p>
	</div>
</div>