/*
##################################################################################################################################
###### Project   : Up down image slideshow gallery  																		######
###### File Name : setting.js                   																			######
###### Purpose   : This javascript is to authenticate the form.  															######
###### Created   : 26-04-2011                  																				######
###### Modified  : 26-04-2011                  																				######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        											######
###### Link      : http://www.gopiplus.com/work/																			######
##################################################################################################################################
*/


function udisg_submit()
{
	if(document.udisg_form.udisg_path.value=="")
	{
		alert("Please enter the image path.")
		document.udisg_form.udisg_path.focus();
		return false;
	}
	else if(document.udisg_form.udisg_link.value=="")
	{
		alert("Please enter the target link.")
		document.udisg_form.udisg_link.focus();
		return false;
	}
	else if(document.udisg_form.udisg_target.value=="")
	{
		alert("Please enter the target status.")
		document.udisg_form.udisg_target.focus();
		return false;
	}
//	else if(document.udisg_form.udisg_title.value=="")
//	{
//		alert("Please enter the image title.")
//		document.udisg_form.udisg_title.focus();
//		return false;
//	}
	else if(document.udisg_form.udisg_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.udisg_form.udisg_order.focus();
		return false;
	}
	else if(isNaN(document.udisg_form.udisg_order.value))
	{
		alert("Please enter the display order, only number.")
		document.udisg_form.udisg_order.focus();
		return false;
	}
	else if(document.udisg_form.udisg_status.value=="")
	{
		alert("Please select the display status.")
		document.udisg_form.udisg_status.focus();
		return false;
	}
	else if(document.udisg_form.udisg_type.value=="")
	{
		alert("Please enter the gallery type.")
		document.udisg_form.udisg_type.focus();
		return false;
	}
}

function udisg_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_udisg_display.action="options-general.php?page=up-down-image-slideshow-gallery/image-management.php&AC=DEL&DID="+id;
		document.frm_udisg_display.submit();
	}
}	

function udisg_redirect()
{
	window.location = "options-general.php?page=up-down-image-slideshow-gallery/image-management.php";
}
