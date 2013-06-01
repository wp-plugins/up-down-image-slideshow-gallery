<div class="wrap">
<?php
$udisg_errors = array();
$udisg_success = '';
$udisg_error_found = FALSE;

// Preset the form fields
$form = array(
	'udisg_path' => '',
	'udisg_link' => '',
	'udisg_target' => '',
	'udisg_title' => '',
	'udisg_order' => '',
	'udisg_status' => '',
	'udisg_type' => ''
);

// Form submitted, check the data
if (isset($_POST['udisg_form_submit']) && $_POST['udisg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('udisg_form_add');
	
	$form['udisg_path'] = isset($_POST['udisg_path']) ? $_POST['udisg_path'] : '';
	if ($form['udisg_path'] == '')
	{
		$udisg_errors[] = __('Please enter the image path.', WP_udisg_UNIQUE_NAME);
		$udisg_error_found = TRUE;
	}

	$form['udisg_link'] = isset($_POST['udisg_link']) ? $_POST['udisg_link'] : '';
	if ($form['udisg_link'] == '')
	{
		$udisg_errors[] = __('Please enter the target link.', WP_udisg_UNIQUE_NAME);
		$udisg_error_found = TRUE;
	}
	
	$form['udisg_target'] = isset($_POST['udisg_target']) ? $_POST['udisg_target'] : '';
	$form['udisg_title'] = isset($_POST['udisg_title']) ? $_POST['udisg_title'] : '';
	$form['udisg_order'] = isset($_POST['udisg_order']) ? $_POST['udisg_order'] : '';
	$form['udisg_status'] = isset($_POST['udisg_status']) ? $_POST['udisg_status'] : '';
	$form['udisg_type'] = isset($_POST['udisg_type']) ? $_POST['udisg_type'] : '';

	//	No errors found, we can add this Group to the table
	if ($udisg_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_udisg_TABLE."`
			(`udisg_path`, `udisg_link`, `udisg_target`, `udisg_title`, `udisg_order`, `udisg_status`, `udisg_type`)
			VALUES(%s, %s, %s, %s, %d, %s, %s)",
			array($form['udisg_path'], $form['udisg_link'], $form['udisg_target'], $form['udisg_title'], $form['udisg_order'], $form['udisg_status'], $form['udisg_type'])
		);
		$wpdb->query($sql);
		
		$udisg_success = __('New image details was successfully added.', WP_udisg_UNIQUE_NAME);
		
		// Reset the form fields
		$form = array(
			'udisg_path' => '',
			'udisg_link' => '',
			'udisg_target' => '',
			'udisg_title' => '',
			'udisg_order' => '',
			'udisg_status' => '',
			'udisg_type' => ''
		);
	}
}

if ($udisg_error_found == TRUE && isset($udisg_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $udisg_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($udisg_error_found == FALSE && strlen($udisg_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $udisg_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=up-down-image-slideshow-gallery">Click here</a> to view the details</strong></p>
	  </div>
	  <?php
	}
?>
<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/up-down-image-slideshow-gallery/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php echo WP_udisg_TITLE; ?></h2>
	<form name="udisg_form" method="post" action="#" onsubmit="return udisg_submit()"  >
      <h3>Add new image details</h3>
      <label for="tag-image">Enter image path (URL)</label>
      <input name="udisg_path" type="text" id="udisg_path" value="" size="125" />
      <p>Where is the picture located on the internet (ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg)</p>
      <label for="tag-link">Enter target link</label>
      <input name="udisg_link" type="text" id="udisg_link" value="" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="udisg_target" id="udisg_target">
        <option value='_blank'>_blank</option>
        <option value='_parent'>_parent</option>
        <option value='_self'>_self</option>
        <option value='_new'>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image reference</label>
      <input name="udisg_title" type="text" id="udisg_title" value="" size="125" />
      <p>Enter image reference. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
      <select name="udisg_type" id="udisg_type">
        <option value='GROUP1'>Group1</option>
        <option value='GROUP2'>Group2</option>
        <option value='GROUP3'>Group3</option>
        <option value='GROUP4'>Group4</option>
        <option value='GROUP5'>Group5</option>
        <option value='GROUP6'>Group6</option>
        <option value='GROUP7'>Group7</option>
        <option value='GROUP8'>Group8</option>
        <option value='GROUP9'>Group9</option>
        <option value='GROUP0'>Group0</option>
		<option value='Widget'>Widget</option>
		<option value='Sample'>Sample</option>
      </select>
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="udisg_status" id="udisg_status">
        <option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="udisg_order" type="text" id="udisg_order" size="10" value="" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="udisg_id" id="udisg_id" type="hidden" value="">
      <input type="hidden" name="udisg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="Insert Details" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="udisg_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="udisg_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('udisg_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_udisg_LINK; ?></p>
</div>