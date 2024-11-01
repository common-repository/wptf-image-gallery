<?php global $wptf_upload;
$out = $out.'<div class="wptf-pnav"></div>
<div class="wptf-gallery" id="wptf-gallery-'.$data['id'].'">
'.$navigation1.'
<ul class="wptf-simple">';
$i=0;
while($row = mysql_fetch_assoc($res)){
$newpath = wptf_image_thumb($row['img'], 'w='.$data['w'].'&h='.$data['h']);
$out = $out.'<li id="wptf-img-'.$row['id'].'"><a class="mbox" data-init="'.$mode.'" title="'.$row['title'].'" href="'.$wptf_upload['baseurl'].'/wptf-uploads/'.$row['img'].'"><img src="'.$newpath.'" /></a></li>';
++$i;
}
$out = $out.'</ul>'.$navigation2.'
</div>

<script>
wptf_items_per_page = '.$items_per_pagex.';
jQuery(document).ready(function() {
jQuery(\'#wptf-gallery-'.$data['id'].' .wptf-pnav\').pagination({
items: '.$i.',
edges: 5,
itemsOnPage: '.$items_per_pagex.',
cssStyle: \'light-theme\',
onInit: wptf_init_startup,
onPageClick: wptf_navigate,
hrefTextPrefix: \'javascript:void(\',
hrefTextSuffix: \')\'
});
});
</script>';
?>