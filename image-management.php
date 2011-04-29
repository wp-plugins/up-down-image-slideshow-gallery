<!--
##############################################################################################################################
###### Project   : Up down image slideshow gallery  																	######
###### File Name : image-management.php                   																######
###### Purpose   : This page is to manage the image.  																	######
###### Created   : 26-04-2011                  																			######
###### Modified  : 26-04-2011                   																		######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        										######
###### Link      : #  																									######
##############################################################################################################################
-->

<div class="wrap">
  <?php
  	global $wpdb;
    $title = __('Up down image slideshow gallery');
    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=up-down-image-slideshow-gallery/image-management.php";
    $DID=@$_GET["DID"];
    $AC=@$_GET["AC"];
    $submittext = "Insert Message";
	if($AC <> "DEL" and trim($_POST['udisg_link']) <>"")
    {
			if($_POST['udisg_id'] == "" )
			{
					$sql = "insert into ".WP_udisg_TABLE.""
					. " set `udisg_path` = '" . mysql_real_escape_string(trim($_POST['udisg_path']))
					. "', `udisg_link` = '" . mysql_real_escape_string(trim($_POST['udisg_link']))
					. "', `udisg_target` = '" . mysql_real_escape_string(trim($_POST['udisg_target']))
					. "', `udisg_title` = '" . mysql_real_escape_string(trim($_POST['udisg_title']))
					. "', `udisg_order` = '" . mysql_real_escape_string(trim($_POST['udisg_order']))
					. "', `udisg_status` = '" . mysql_real_escape_string(trim($_POST['udisg_status']))
					. "', `udisg_type` = '" . mysql_real_escape_string(trim($_POST['udisg_type']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_udisg_TABLE.""
					. " set `udisg_path` = '" . mysql_real_escape_string(trim($_POST['udisg_path']))
					. "', `udisg_link` = '" . mysql_real_escape_string(trim($_POST['udisg_link']))
					. "', `udisg_target` = '" . mysql_real_escape_string(trim($_POST['udisg_target']))
					. "', `udisg_title` = '" . mysql_real_escape_string(trim($_POST['udisg_title']))
					. "', `udisg_order` = '" . mysql_real_escape_string(trim($_POST['udisg_order']))
					. "', `udisg_status` = '" . mysql_real_escape_string(trim($_POST['udisg_status']))
					. "', `udisg_type` = '" . mysql_real_escape_string(trim($_POST['udisg_type']))
					. "' where `udisg_id` = '" . $_POST['udisg_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_udisg_TABLE." where udisg_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_udisg_TABLE." where udisg_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $udisg_id_x = htmlspecialchars(stripslashes($data->udisg_id)); 
		if ( !empty($data) ) $udisg_path_x = htmlspecialchars(stripslashes($data->udisg_path)); 
        if ( !empty($data) ) $udisg_link_x = htmlspecialchars(stripslashes($data->udisg_link));
		if ( !empty($data) ) $udisg_target_x = htmlspecialchars(stripslashes($data->udisg_target));
        if ( !empty($data) ) $udisg_title_x = htmlspecialchars(stripslashes($data->udisg_title));
		if ( !empty($data) ) $udisg_order_x = htmlspecialchars(stripslashes($data->udisg_order));
		if ( !empty($data) ) $udisg_status_x = htmlspecialchars(stripslashes($data->udisg_status));
		if ( !empty($data) ) $udisg_type_x = htmlspecialchars(stripslashes($data->udisg_type));
        $submittext = "Update Message";
    }
    ?>
  <h2><?php echo wp_specialchars( $title ); ?></h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/up-down-image-slideshow-gallery/inc/setting.js"></script>
  <form name="udisg_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return udisg_submit()"  >
    <table width="100%">
      <tr>
        <td colspan="2" align="left" valign="middle">Enter image url:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="udisg_path" type="text" id="udisg_path" value="<?php echo $udisg_path_x; ?>" size="125" /></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Enter target link:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="udisg_link" type="text" id="udisg_link" value="<?php echo $udisg_link_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter target option:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="udisg_target" type="text" id="udisg_target" value="<?php echo $udisg_target_x; ?>" size="50" /> ( _blank, _parent, _self, _new )</td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter image reference:</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="udisg_title" type="text" id="udisg_title" value="<?php echo $udisg_title_x; ?>" size="125" /></td>
      </tr>
	  <tr>
        <td colspan="2" align="left" valign="middle">Enter gallery type (This is to group the images):</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"><input name="udisg_type" type="text" id="udisg_type" value="<?php echo $udisg_type_x; ?>" size="50" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Display Status:</td>
        <td align="left" valign="middle">Display Order:</td>
      </tr>
      <tr>
        <td width="22%" align="left" valign="middle"><select name="udisg_status" id="udisg_status">
            <option value="">Select</option>
            <option value='YES' <?php if($udisg_status_x=='YES') { echo 'selected' ; } ?>>Yes</option>
            <option value='NO' <?php if($udisg_status_x=='NO') { echo 'selected' ; } ?>>No</option>
          </select>
        </td>
        <td width="78%" align="left" valign="middle"><input name="udisg_order" type="text" id="udisg_rder" size="10" value="<?php echo $udisg_order_x; ?>" maxlength="3" /></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="bottom"><table width="100%">
            <tr>
              <td width="50%" align="left"><input name="publish" lang="publish" class="button-primary" value="<?php echo $submittext?>" type="submit" />
                <input name="publish" lang="publish" class="button-primary" onclick="udisg_redirect()" value="Cancel" type="button" />
              </td>
              <td width="50%" align="right">
			  <input name="text_management1" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        	  <input name="setting_management1" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/up-down-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
			  </td>
            </tr>
          </table></td>
      </tr>
      <input name="udisg_id" id="udisg_id" type="hidden" value="<?php echo $udisg_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_udisg_TABLE." order by udisg_type,udisg_order");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_udisg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="10%" align="left" scope="col">Type
              </td>
            <th width="52%" align="left" scope="col">Reference
              </td>
			 <th width="10%" align="left" scope="col">Target
              </td>
            <th width="8%" align="left" scope="col">Order
              </td>
            <th width="7%" align="left" scope="col">Display
              </td>
            <th width="13%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
		if($data->udisg_status=='YES') { $displayisthere="True"; }
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->udisg_type)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->udisg_title)); ?></td>
			<td align="left" valign="middle"><?php echo(stripslashes($data->udisg_target)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->udisg_order)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->udisg_status)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=up-down-image-slideshow-gallery/image-management.php&DID=<?php echo($data->udisg_id); ?>">Edit</a> &nbsp; <a onClick="javascript:udisg_delete('<?php echo($data->udisg_id); ?>')" href="javascript:void(0);">Delete</a> </td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
        <?php if($displayisthere<>"True") { ?>
        <tr>
          <td colspan="6" align="center" style="color:#FF0000" valign="middle">No message available with display status 'Yes'!' </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
  <table width="100%">
    <tr>
      <td align="right"><input name="text_management" lang="text_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/image-management.php'" value="Go to - Image Management" type="button" />
        <input name="setting_management" lang="setting_management" class="button-primary" onClick="location.href='options-general.php?page=up-down-image-slideshow-gallery/up-down-image-slideshow-gallery.php'" value="Go to - Gallery Setting" type="button" />
      </td>
    </tr>
  </table>
</div>
<?php include("inc/help.php"); ?>