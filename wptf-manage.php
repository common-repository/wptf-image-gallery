<?php
global $wptf_upload;
$slider = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_albums` WHERE `id`='$_GET[edit]'"));

if(isset($_POST['title'])){

}

if(isset($_FILES['image']['name'])){

$today = time();
$desc = htmlentities($_POST['descr'],ENT_COMPAT,'utf-8');
$title = htmlentities($_POST['title'],ENT_COMPAT,'utf-8');

$path_info = pathinfo($_FILES['image']['name']);
$ext = strtolower($path_info['extension']);
$fname = $today.'.'.$ext;
if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
move_uploaded_file($_FILES['image']['tmp_name'], $wptf_upload['basedir'].'/wptf-uploads/'.$fname);
mysql_query("INSERT INTO `".$wpdb->prefix."wptf_pics` (`id`, `date`, `title`, `desc`, `img`, `aid`) 
VALUES (NULL, '$today', '$title', '$desc', '$fname', '".$_GET['edit']."')");
} else {
echo'<div class="error">Invalid file type or no file selected.</div>';
}

}




if(isset($_FILES['zipfile']['name'])){

$today = time();
$desc = '';

$path_info = pathinfo($_FILES['zipfile']['name']);
$ext = strtolower($path_info['extension']);
$fname = $today.'.'.$ext;
if($ext=='zip' || $ext=='gz' || $ext=='tar'){



$path = $_FILES['zipfile']['tmp_name'];

$zip = new ZipArchive;
if ($zip->open($path) === true) {
    for($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $fileinfo = pathinfo($filename);
		$ext = strtolower($fileinfo['extension']);
		if($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif'){
		$fname = uniqid().'.'.$ext;
        copy("zip://".$path."#".$filename, $wptf_upload['basedir'].'/wptf-uploads/'.$fname);
mysql_query("INSERT INTO `".$wpdb->prefix."wptf_pics` (`id`, `date`, `title`, `desc`, `img`, `aid`) 
VALUES (NULL, '".time()."', 'no title', '', '$fname', '".$_GET['edit']."')");
		}
    }                  
    $zip->close();                  
}

}

}

?>
<div class="wrap sks">
<h2>Manage Gallery : <?php echo $slider['name']; ?></h2>
<br />

<a class="thickbox button button-primary button-large" href="#TB_inline?&inlineId=add-new-image">Upload Images</a>
<br /><br />
<?php

if(isset($_GET['deleteimage'])){

$xdata = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_pics` WHERE `id`='".$_GET['deleteimage']."'"));
@unlink(WPTFPATH.'uploads/'.$xdata['img']);
mysql_query("DELETE FROM `".$wpdb->prefix."wptf_pics` WHERE `id`='".$_GET['deleteimage']."'");

echo'<div class="updated"><p>Image deleted. Please wait, redirecting . . .</p></div><script>wptf_img_go_back();</script>';
}

if(isset($_POST['etitle'])){

mysql_query("UPDATE `".$wpdb->prefix."wptf_pics` SET `title` = '".htmlentities($_POST['etitle'])."',
`desc` = '".htmlentities($_POST['edescr'])."' WHERE `id` ='".$_POST['upd_id']."'");

echo'<div class="updated"><p>Changes updated successfully.</p></div>';
}

$numx=mysql_fetch_assoc(mysql_query("SELECT COUNT(*) as total FROM `".$wpdb->prefix."wptf_pics` WHERE `aid`='".$_GET['edit']."'"));
$paginate = wptf_quick_paginate($numx['total'], 'images');
echo $paginate['data'];

?>
<table class="widefat">
<tr><th width="100">Image</th><th>Title</th><th width="100">Options</th></tr>
<?php

$sql = mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_pics` WHERE `aid`='".$_GET['edit']."' ORDER BY `id` DESC limit ".$paginate[start].",".$paginate[per_page]."");

if($numx['total']==0){
echo'<tr><td colspan="2" align="center"><h3><i><b>Oops! No images found in this gallery.</b></i></h3></td></tr>';
}

while($row = mysql_fetch_assoc($sql)){
$newpath = wptf_image_thumb($row['img'], 'w=100&h=100');
echo'<tr id="'.$row['id'].'"><td><img src="'.$newpath.'" /></td><td><h3>'.$row['title'].'</h3><p>'.$row['desc'].'</p><i><b>Uploaded On</b> : '.date("l, d-m-Y, h:i a", $row['date']).'</i></td><td><a href="javascript:wptf_edit_image(\''.$row['id'].'\')">Edit</a> | <a href="javascript:wptf_delete_image(\''.$row['id'].'\')">Delete</a></td></tr>';
}

echo '</table>'.$paginate['data'];

?>


<div id="add-new-image" style="display:none;">

<div class="tabbed-area">

<ul class="tabs group">
<li class="active-tab"><a href="#box-one">Upload Single Image</a></li>
<li><a href="#box-two">Upload Multiple Images</a></li>
</ul>

<div class="box-wrap">

<div id="box-one"style="display:block;">
<form action="" enctype="multipart/form-data" method="post">
<h2>Add new image</h2>
<table class="sks-table">
<tr><td>Title</td><td><input type="text" name="title" /></td></tr>
<tr><td>Description</td><td><textarea name="descr"></textarea></td></tr>
<tr><td>Image</td><td><input type="file" name="image" /></td></tr>
</table>
<p class="submit"><input type="submit" value="Upload Image" class="button button-primary button-large" id="submit" name="submit"></p>
</form>
</div>


<div id="box-two">
<form action="" enctype="multipart/form-data" method="post">
<h2>Add Zip file containing images</h2>
<table class="sks-table">
<tr><td colspan="2">All image files will be uploaded with their <i>No title</i> as title, no description. Any unknown file-types will be ignored.</td></tr>
<tr><td>Select Zip file</td><td><input type="file" name="zipfile" /></td></tr>
</table>
<p class="submit"><input type="submit" value="Upload Zip file with Images" class="button button-primary button-large" id="submit" name="submit"></p>
</form>
</div>


</div>


</div>
</div>










<div id="wptf-edit-image" style="display:none;">
<form action="" enctype="multipart/form-data" method="post">
<h2>Editing Image</h2>
<table class="sks-table">
<tr><td width="100">Title</td><td><input type="text" name="etitle" /><input type="hidden" name="upd_id" /></td></tr>
<tr><td>Description</td><td><textarea rows="5" name="edescr"></textarea></td></tr>
</table>
<p class="submit"><input type="submit" value="Save Changes" class="button button-primary button-large" id="submit" name="submit"></p>
</form>

</div>



<a href="#" class="thickbox hidden-trigger" style="display:none;"></a>

</div>