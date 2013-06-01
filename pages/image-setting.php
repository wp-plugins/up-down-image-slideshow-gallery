<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php echo WP_udisg_TITLE; ?></h2>
	<h3>Widget setting</h3>
    <?php
	$udisg_title = get_option('udisg_title');
	$udisg_width = get_option('udisg_width');
	$udisg_height = get_option('udisg_height');
	$udisg_pause = get_option('udisg_pause');
	$udisg_cycles = get_option('udisg_cycles');
	$udisg_persist = get_option('udisg_persist');
	$udisg_slideduration = get_option('udisg_slideduration');
	$udisg_random = get_option('udisg_random');
	$udisg_type = get_option('udisg_type');
	
	if (@$_POST['udisg_submit']) 
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('udisg_form_setting');
			
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
		
		?>
		<div class="updated fade">
			<p><strong>Details successfully updated.</strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/up-down-image-slideshow-gallery/pages/setting.js"></script>
    <form name="udisg_form" method="post" action="">
      
	  <label for="tag-title">Enter widget title</label>
      <input name="udisg_title" id="udisg_title" type="text" value="<?php echo $udisg_title; ?>" size="80" />
      <p>Enter widget title, Only for widget.</p>
      
	  <label for="tag-width">Width (Only number)</label>
      <input name="udisg_width" id="udisg_width" type="text" value="<?php echo $udisg_width; ?>" />
      <p>Widget Width (only number). (Example: 250)</p>
      
	  <label for="tag-height">Height of each image</label>
      <input name="udisg_height" id="udisg_height" type="text" value="<?php echo $udisg_height; ?>" />
      <p>Widget Height (only number). (Example: 200)</p>
	  
	  <label for="tag-height">Pause</label>
      <input name="udisg_pause" id="udisg_pause" type="text" value="<?php echo $udisg_pause; ?>" />
      <p>Only Number / Pause time of the slideshow in milliseconds.</p>
	  
	  <label for="tag-height">Cycles</label>
      <input name="udisg_cycles" id="udisg_cycles" type="text" value="<?php echo $udisg_cycles; ?>" />
      <p>Gallery will automatically start the slideshow and it will stop number of cycle mentioned in this property. (only number)</p>
	  
	  <label for="tag-height">Persist</label>
      <input name="udisg_persist" id="udisg_persist" type="text" value="<?php echo $udisg_persist; ?>" />
      <p></p>
	  
	  <label for="tag-height">Slide duration</label>
      <input name="udisg_slideduration" id="udisg_slideduration" type="text" value="<?php echo $udisg_slideduration; ?>" />
      <p>Slideshow transition duration in milliseconds.</p>
	  
	  <label for="tag-height">Random</label>
      <input name="udisg_random" id="udisg_random" type="text" value="<?php echo $udisg_random; ?>" />
      <p>(YES/NO)</p>
      
	  <label for="tag-height">Select your gallery group (Gallery  Type)</label>
	  <select name="udisg_type" id="udisg_type">
        <option value='GROUP1' <?php if($udisg_type=='GROUP1') { echo 'selected' ; } ?>>Group1</option>
        <option value='GROUP2' <?php if($udisg_type=='GROUP2') { echo 'selected' ; } ?>>Group2</option>
        <option value='GROUP3' <?php if($udisg_type=='GROUP3') { echo 'selected' ; } ?>>Group3</option>
        <option value='GROUP4' <?php if($udisg_type=='GROUP4') { echo 'selected' ; } ?>>Group4</option>
        <option value='GROUP5' <?php if($udisg_type=='GROUP5') { echo 'selected' ; } ?>>Group5</option>
        <option value='GROUP6' <?php if($udisg_type=='GROUP6') { echo 'selected' ; } ?>>Group6</option>
        <option value='GROUP7' <?php if($udisg_type=='GROUP7') { echo 'selected' ; } ?>>Group7</option>
        <option value='GROUP8' <?php if($udisg_type=='GROUP8') { echo 'selected' ; } ?>>Group8</option>
        <option value='GROUP9' <?php if($udisg_type=='GROUP9') { echo 'selected' ; } ?>>Group9</option>
        <option value='GROUP0' <?php if($udisg_type=='GROUP0') { echo 'selected' ; } ?>>Group0</option>
		<option value='Widget' <?php if($udisg_type=='Widget') { echo 'selected' ; } ?>>Widget</option>
		<option value='sample' <?php if($udisg_type=='Sample') { echo 'selected' ; } ?>>Sample</option>
      </select>
      <p>This field is to group the images. Select your group name to fetch the images for widget.</p>
      
	  <input name="udisg_submit" id="udisg_submit" class="button-primary" value="Submit" type="submit" />
	  <input name="publish" lang="publish" class="button-primary" onclick="udisg_redirect()" value="Cancel" type="button" />
        <input name="Help" lang="publish" class="button-primary" onclick="udisg_help()" value="Help" type="button" />
	  <?php wp_nonce_field('udisg_form_setting'); ?>
    </form>
  </div>
  <br /><p class="description"><?php echo WP_udisg_LINK; ?></p>
</div>
