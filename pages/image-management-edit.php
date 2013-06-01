<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

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
	?><div class="error fade"><p><strong>Oops, selected details doesn't exist.</strong></p></div><?php
}
else
{
	$udisg_errors = array();
	$udisg_success = '';
	$udisg_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_udisg_TABLE."`
		WHERE `udisg_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'udisg_path' => $data['udisg_path'],
		'udisg_link' => $data['udisg_link'],
		'udisg_target' => $data['udisg_target'],
		'udisg_title' => $data['udisg_title'],
		'udisg_order' => $data['udisg_order'],
		'udisg_status' => $data['udisg_status'],
		'udisg_type' => $data['udisg_type']
	);
}
// Form submitted, check the data
if (isset($_POST['udisg_form_submit']) && $_POST['udisg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('udisg_form_edit');
	
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
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_udisg_TABLE."`
				SET `udisg_path` = %s,
				`udisg_link` = %s,
				`udisg_target` = %s,
				`udisg_title` = %s,
				`udisg_order` = %d,
				`udisg_status` = %s,
				`udisg_type` = %s
				WHERE udisg_id = %d
				LIMIT 1",
				array($form['udisg_path'], $form['udisg_link'], $form['udisg_target'], $form['udisg_title'], $form['udisg_order'], $form['udisg_status'], $form['udisg_type'], $did)
			);
		$wpdb->query($sSql);
		
		$udisg_success = 'Image details was successfully updated.';
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
      <h3>Update image details</h3>
      <label for="tag-image">Enter image path</label>
      <input name="udisg_path" type="text" id="udisg_path" value="<?php echo $form['udisg_path']; ?>" size="125" />
      <p>Where is the picture located on the internet</p>
      <label for="tag-link">Enter target link</label>
      <input name="udisg_link" type="text" id="udisg_link" value="<?php echo $form['udisg_link']; ?>" size="125" />
      <p>When someone clicks on the picture, where do you want to send them</p>
      <label for="tag-target">Enter target option</label>
      <select name="udisg_target" id="udisg_target">
        <option value='_blank' <?php if($form['udisg_target']=='_blank') { echo 'selected' ; } ?>>_blank</option>
        <option value='_parent' <?php if($form['udisg_target']=='_parent') { echo 'selected' ; } ?>>_parent</option>
        <option value='_self' <?php if($form['udisg_target']=='_self') { echo 'selected' ; } ?>>_self</option>
        <option value='_new' <?php if($form['udisg_target']=='_new') { echo 'selected' ; } ?>>_new</option>
      </select>
      <p>Do you want to open link in new window?</p>
      <label for="tag-title">Enter image reference</label>
      <input name="udisg_title" type="text" id="udisg_title" value="<?php echo $form['udisg_title']; ?>" size="125" />
      <p>Enter image reference. This is only for reference.</p>
      <label for="tag-select-gallery-group">Select gallery type</label>
      <select name="udisg_type" id="udisg_type">
        <option value='GROUP1' <?php if($form['udisg_type']=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($form['udisg_type']=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($form['udisg_type']=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($form['udisg_type']=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($form['udisg_type']=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($form['udisg_type']=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($form['udisg_type']=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($form['udisg_type']=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($form['udisg_type']=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($form['udisg_type']=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($form['udisg_type']=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($form['udisg_type']=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p>This is to group the images. Select your slideshow group. </p>
      <label for="tag-display-status">Display status</label>
      <select name="udisg_status" id="udisg_status">
        <option value='YES' <?php if($form['udisg_status']=='YES') { echo 'selected' ; } ?>>Yes</option>
        <option value='NO' <?php if($form['udisg_status']=='NO') { echo 'selected' ; } ?>>No</option>
      </select>
      <p>Do you want the picture to show in your galler?</p>
      <label for="tag-display-order">Display order</label>
      <input name="udisg_order" type="text" id="udisg_order" size="10" value="<?php echo $form['udisg_order']; ?>" maxlength="3" />
      <p>What order should the picture be played in. should it come 1st, 2nd, 3rd, etc.</p>
      <input name="udisg_id" id="udisg_id" type="hidden" value="">
      <input type="hidden" name="udisg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button-primary" value="Update Details" type="submit" />
        <input name="publish" lang="publish" class="button-primary" onclick="udisg_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="udisg_help()" value="Help" type="button" />
      </p>
	  <?php wp_nonce_field('udisg_form_edit'); ?>
    </form>
</div>
<p class="description"><?php echo WP_udisg_LINK; ?></p>
</div>