<div class="wrap sks"><div class="icon32" id="icon-options-general"><br></div><h2>WP True Fullscreen Gallery</h2><br />We also have PRO version available with lot of additional features. <a href="http://phploaded.com/page/plugin/wp-true-fullscreen-gallery-pro-5287cf519fef7.html" target="_blank">Click here for PRO version</a><br /><br /><a class="thickbox button button-primary button-large" href="#TB_inline?&inlineId=add-new-gallery">Create new gallery</a><br /><br /><?phpglobal $wptf_upload;if(isset($_POST['upd_idx'])){mysql_query("UPDATE `wp_wptf_albums` SET `type` = '".$_POST['ctmode']."',`name` = '".$_POST['ctitle']."',`w` = '".$_POST['ctw']."',`h` = '".$_POST['cth']."' WHERE `id` ='".$_POST['upd_idx']."'");echo'<div class="updated"><p>Album Updated successfully.</p></div>';}$numx=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as total FROM `".$wpdb->prefix."wptf_albums`"));$paginate = wptf_quick_paginate($numx['total'], 'galleries');echo $paginate['data'];?><table class="widefat"><tr><th>Name</th><th>Description</th><th width="100">Shortcode</th><th width="150">Options</th></tr><?phpif(isset($_POST['title'])){if($_POST['title']!='' && trim($_POST['title'])!=' '){$title = htmlentities($_POST['title'],ENT_COMPAT,'utf-8');$description = htmlentities($_POST[description],ENT_COMPAT,'utf-8');$type = $_POST['tmode'];$today = time();mysql_query("INSERT INTO `".$wpdb->prefix."wptf_albums` (`id`, `type`, `name`, `w`, `h`, `time`) VALUES (NULL, '".$type."', '".$_POST['title']."', '".$_POST['tw']."', '".$_POST['th']."', '".time()."')");$inserted = mysql_insert_id();echo'<script>document.location.href="admin.php?page=wptf-settings.php";</script>';}}if(isset($_GET['deletegal'])){$qry = mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_pics` WHERE `aid`='".$_GET['deletegal']."'");while($xdata = mysql_fetch_assoc($qry)){@unlink($wptf_upload['basedir'].'/wptf-uploads/'.$xdata['img']);mysql_query("DELETE FROM `".$wpdb->prefix."wptf_pics` WHERE `id`='".$xdata['id']."'");}mysql_query("DELETE FROM `".$wpdb->prefix."wptf_albums` WHERE `id`='".$_GET['deletegal']."'");echo'<div class="updated"><p>Album deleted. Please wait, redirecting . . .</p></div><script>wptf_gal_go_back();</script>';}$res = mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_albums` ORDER BY `time` DESC limit ".$paginate[start].",".$paginate[per_page]."");$i=0;while($row = mysql_fetch_assoc($res)){echo'<tr id="'.$row[id].'"><td class="wptf_name">'.$row[name].'</td><td><p class="wptf_desc">'.$row[description].'</p><b>Type : <i class="wptf_type">'.$wptf_types[$row['type']].'</i></b><br /><b>Dimentions : <i class="wptf_w">'.$row['w'].'</i> X <i class="wptf_h">'.$row['h'].'</i></b><h5>Created on '.date("l, d-m-Y, h:i a", $row['time']).'</h5></td><td>[wptf id="'.$row[id].'"]</td><td><a href="admin.php?page=wptf-settings.php&edit='.$row[id].'">Manage</a> |<a href="javascript:wptf_edit_gallery('.$row[id].')">Settings</a> |<a href="javascript:wptf_del_gallery('.$row[id].')">Delete</a></td></tr>';++$i;}if($i==0){echo'<tr><td colspan="5"><i>There are no galleries present. Create a gallery to continue.</i></td></tr>';}echo '</table>'.$paginate['data'];?><div id="add-new-gallery" style="display:none;"><form action="" method="post"><h2>Create new gallery</h2><table class="sks-table"><tr><td>Name</td><td><input type="text" name="title" /></td></tr><tr><td>Thumbnail Width</td><td><input type="text" name="tw" /></td></tr><tr><td>Thumbnail Height</td><td><input type="text" name="th" /></td></tr><tr><td>Thumbnail Mode</td><td><select name="tmode"><?phpforeach($wptf_types as $key => $value){echo'<option value="'.$key.'">'.$value.'</option>';}?></select></td></tr></table><p class="submit"><input type="submit" value="Create Gallery" class="button button-primary button-large" id="submit" name="submit"></p></form></div><div id="wptf-edit-gallery" style="display:none;"><form action="" method="post"><h2>Edit Gallery Settings</h2><table class="sks-table"><tr><td>Name</td><td><input type="text" name="ctitle" /><input type="hidden" name="upd_idx" /></td></tr><tr><td>Thumbnail Width</td><td><input type="text" name="ctw" /></td></tr><tr><td>Thumbnail Height</td><td><input type="text" name="cth" /></td></tr><tr><td>Thumbnail Mode</td><td><select name="ctmode"><?phpforeach($wptf_types as $key => $value){echo'<option value="'.$key.'">'.$value.'</option>';}?></select></td></tr></table><p class="submit"><input type="submit" value="Save Changes" class="button button-primary button-large" id="submit" name="submit"></p></form></div><a href="#" class="thickbox hidden-triggerx" style="display:none;"></a></div>