<?php

if(isset($_POST['title'])){
$today = time();
$color = htmlentities($_POST[color],ENT_COMPAT,'utf-8');
$title = htmlentities($_POST[title],ENT_COMPAT,'utf-8');
$description = htmlentities($_POST[description],ENT_COMPAT,'utf-8');
mysql_query("INSERT INTO `".$wpdb->prefix."rbt_slides` (`id`, `sliderid`, `date`, `title`, `desc`, `url`, `color`) 
VALUES (NULL, '$_GET[edit]', '$today', '$title', '$description', '$_POST[upload_image]', '$color')");
}

if(isset($_POST['etitle'])){

$today = time();
$color = htmlentities($_POST[color],ENT_COMPAT,'utf-8');
$title = htmlentities($_POST[etitle],ENT_COMPAT,'utf-8');
$description = htmlentities($_POST[description],ENT_COMPAT,'utf-8');
mysql_query("UPDATE `".$wpdb->prefix."rbt_slides` SET `title`='$title', `desc`='$description', `url`='$_POST[upload_image]', `color`='$color' WHERE `id`='$_GET[sedit]'");
}

?>
<div class="wrap sks">
<h2>Manage slider : <?php echo $slider['title']; ?></h2>
<br />
<?php

if($slider['type']=='Simple Roundabout 3D slider'){

if(isset($_GET[del])){
mysql_query("DELETE FROM `".$wpdb->prefix."rbt_slides` WHERE `id`='$_GET[del]'");
echo'<script>document.location.href="admin.php?page=rbt-settings.php&edit='.$_GET[edit].'";</script>';
}

echo'<table class="form-table">
<tr><th style="width:40px;">ID</th><th>Title</th><th style="width:50%;">Description</th><th style="width:50px;">Image</th><th>Options</th></tr>';

$res = mysql_query("SELECT * FROM `".$wpdb->prefix."rbt_slides` WHERE `sliderid`='$_GET[edit]' ORDER BY `date` DESC");

$i=0;

while($row = mysql_fetch_assoc($res)){
if($row[url]!='' && trim($row[url])!=' '){
$img = get_image_thumb($row[url], 'w=50&h=50');
} else {
$img = RBTURL.'images/noimage.jpg';
}
echo'<tr><td>'.$row[id].'</td><td>'.$row[title].'</td>
<td>'.$row[desc].'<h5>Created on '.date("l, d-m-Y, h:i a", $row['date']).'</h5><h5>'.$row['type'].'</h5></td>
<td style="background-color:'.$row[color].'"><img src="'.$img.'"></td><td>
<a title="Edit this slide" href="admin.php?page=rbt-settings.php&edit='.$_GET[edit].'&sedit='.$row[id].'"><img src="'.RBTURL.'images/edit.png" /></a>
<a title="Delete this slide" onclick="del_slide('.$row[id].', '.$_GET[edit].')" href="#"><img src="'.RBTURL.'images/delete.png" /></a>
</td></tr>';
++$i;
}

if($i==0){echo'<tr><td colspan="5"><i>There are no slides present. Create a slider to continue.</i></td></tr>';}

if(!isset($_GET['sedit'])){

?>
</table>
<form action="" method="post">
<h2>&nbsp;</h2>
<h2>Create new slide</h2>
<table class="sks-table">
<tr><td>Title</td><td><input type="text" name="title" /></td></tr>
<tr><td>Description</td><td><textarea rows="4" name="description"></textarea></td></tr>
<tr><td>Image</td><td>
<input id="upload_image" type="text" size="36" name="upload_image" readonly="readonly" value="" />
</td></tr>
<tr><td>Background</td><td>
<input id="color1" class="color-picker" type="text" size="36" name="color" value="#eeeeee" />
<div rel="color1" id="color_picker_color1"></div></td></tr>
</table>
<p class="submit"><input type="submit" value="Create Slide" class="button button-primary" id="submit" name="submit">
<a href="admin.php?page=rbt-settings.php"><input type="button" value="Back to Sliders" class="button button-primary" id="submit" name="link"></a></p>
</form>

<?php } else {

$data = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."rbt_slides` WHERE `id`='$_GET[sedit]'"));

echo'</table>
<form action="" method="post">
<h2>&nbsp;</h2>
<h2>Editing slide at ID = '.$_GET['sedit'].'</h2>
<table class="sks-table">
<tr><td>Title</td><td><input type="text" value="'.$data['title'].'" name="etitle" /></td></tr>
<tr><td>Description</td><td><textarea rows="4" name="description">'.$data['desc'].'</textarea></td></tr>
<tr><td>Image</td><td>
<input id="upload_image" type="text" size="36" name="upload_image" readonly="readonly" value="'.$data['url'].'" />
</td></tr>
<tr><td>Background</td><td>
<input id="color1" class="color-picker" type="text" size="36" name="color" value="'.$data['color'].'" />
<div rel="color1" id="color_picker_color1"></div></td></tr>
</table>
<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
<a href="admin.php?page=rbt-settings.php&edit='.$_GET[edit].'"><input type="button" value="New Slide" class="button button-primary" id="submit" name="link"></a></p>
</p>
</form>';

 } } ?>
<script>
jQuery('#color_picker_color1').farbtastic('#color1');
</script>
</div>