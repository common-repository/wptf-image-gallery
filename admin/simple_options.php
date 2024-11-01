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
`opt3`='$_POST[axis]', 
`opt4`='$_POST[color]', 
`opt5`='$_POST[cwidth]', 
`opt6`='$_POST[cheight]', 
`opt7`='$_POST[autoplay]', 
`opt8`='$_POST[hover]', 
`opt9`='$_POST[duration]', 
`opt10`='$_POST[minop]', 
`opt11`='$_POST[maxop]', 
`opt12`='$_POST[direct]', 
`opt13`='$_POST[drag]' WHERE `id`='$_GET[options]'");
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
<tr><td>Slide Background</td><td>
<input id="color1" class="color-picker" type="text" size="36" name="color" value="<?php echo $slider['opt4']; ?>" />
<div rel="color1" id="color_picker_color1"></div></td></tr>
<tr><td>Slide Width</td><td><input type="text" name="swidth" value="<?php echo $slider['opt1']; ?>" /></td></tr>
<tr><td>Slide Height</td><td><input type="text" name="sheight" value="<?php echo $slider['opt2']; ?>" /></td></tr>
<tr><td>Container Width</td><td><input type="text" name="cwidth" value="<?php echo $slider['opt5']; ?>" /></td></tr>
<tr><td>Container Height</td><td><input type="text" name="cheight" value="<?php echo $slider['opt6']; ?>" /></td></tr>
<tr><td>Autoplay</td><td>
<select name="autoplay" id="x-autoplay"><option>true</option><option>false</option></select>
<script>jQuery('#x-autoplay').val('<?php echo $slider['opt7']; ?>');</script>
</td></tr>
<tr><td>Pause on Hover</td><td>
<select name="hover" id="x-hover"><option>true</option><option>false</option></select>
<script>jQuery('#x-hover').val('<?php echo $slider['opt8']; ?>');</script>
</td></tr>
<tr><td>Slide Duration</td><td><input type="text" name="duration" value="<?php echo $slider['opt9']; ?>" /></td></tr>
<tr><td>Minimum Opacity</td><td><input type="text" name="minop" value="<?php echo $slider['opt10']; ?>" /></td></tr>
<tr><td>Maximum Opacity</td><td><input type="text" name="maxop" value="<?php echo $slider['opt11']; ?>" /></td></tr>
<tr><td>Rotation direction</td><td>
<select name="direct" id="x-direct"><option value="false">ClockWise</option><option value="true">Anti-ClockWise</option></select>
<script>jQuery('#x-direct').val('<?php echo $slider['opt12']; ?>');</script>
</td></tr>
<tr><td>Enable Drag</td><td>
<select name="drag" id="x-drag"><option>true</option><option>false</option></select>
<script>jQuery('#x-drag').val('<?php echo $slider['opt13']; ?>');</script>
</td></tr>
<tr><td>Drag Axis</td><td>
<select name="axis" id="x-axis"><option>x</option><option>y</option></select>
<script>jQuery('#x-axis').val('<?php echo $slider['opt3']; ?>');</script>
</td></tr>
</table>
<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
<a href="admin.php?page=rbt-settings.php"><input type="button" value="Back to Sliders" class="button button-primary" id="submit" name="link"></a></p>
</form>
<script>
jQuery('#color_picker_color1').farbtastic('#color1');
</script>
</div>