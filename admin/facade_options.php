<?php

if(isset($_POST['otitle'])){

$today = time();
$color = htmlentities($_POST[color],ENT_COMPAT,'utf-8');
$title = htmlentities($_POST[otitle],ENT_COMPAT,'utf-8');
$description = htmlentities($_POST[description],ENT_COMPAT,'utf-8');
mysql_query("UPDATE `".$wpdb->prefix."rbt_sliders` SET 
`title`='$title', 
`description`='$description', 
`opt1`='$_POST[swidth]', 
`opt2`='$_POST[sheight]', 
`opt3`='$_POST[border]', 
`opt5`='$_POST[bgcolor]', 
`opt4`='$_POST[color]' WHERE `id`='$_GET[options]'");
}

unset($slider);

$slider = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."rbt_sliders` WHERE `id`='$_GET[options]'"));

?>
<div class="wrap sks">
<h2>Manage Options : <?php echo $slider['title']; ?></h2>
<br />
<form action="" method="post">
<table class="sks-table">
<tr><td>Title</td><td><input type="text" name="otitle" value="<?php echo $slider['title']; ?>" /></td></tr>
<tr><td>Description</td><td><textarea rows="4" name="description"><?php echo $slider['description']; ?></textarea></td></tr>
<tr><td>Border Color</td><td>
<input id="color1" class="color-picker" type="text" size="36" name="color" value="<?php echo $slider['opt4']; ?>" />
<div rel="color1" id="color_picker_color1"></div></td></tr>
<tr><td>Background Color</td><td>
<input id="color2" class="color-picker" type="text" size="36" name="bgcolor" value="<?php echo $slider['opt5']; ?>" />
<div rel="color2" id="color_picker_color2"></div></td></tr>
<tr><td>Container Width</td><td><input type="text" name="swidth" value="<?php echo $slider['opt1']; ?>" /></td></tr>
<tr><td>Container Height</td><td><input type="text" name="sheight" value="<?php echo $slider['opt2']; ?>" /></td></tr>
<tr><td>Border Width</td><td><input type="text" name="border" value="<?php echo $slider['opt3']; ?>" /></td></tr>

</table>
<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
<a href="admin.php?page=rbt-settings.php"><input type="button" value="Back to Sliders" class="button button-primary" id="submit" name="link"></a></p>
</form>

</div>
<script>
jQuery('#color_picker_color1').farbtastic('#color1');
jQuery('#color_picker_color2').farbtastic('#color2');
</script>