/**
 *     Up down image slideshow gallery
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 *     http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
		document.frm_udisg_display.action="options-general.php?page=up-down-image-slideshow-gallery&ac=del&did="+id;
		document.frm_udisg_display.submit();
	}
}	

function udisg_redirect()
{
	window.location = "options-general.php?page=up-down-image-slideshow-gallery";
}

function udisg_help()
{
	window.open("http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-up-down-image-slideshow-script/");
}