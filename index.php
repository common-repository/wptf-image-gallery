<?php 
/* Plugin Name: wptf-image-gallery
Plugin URI: http://plugins.phploaded.com/wptf-lite/
Description: WordPress True Fullscreen (WPTF) Image Gallery is the best gallery plugin that supports true fullscreen and have a lot of features built with it.
Author: Satish Kumar Sharma
Version: 1.0.3
Author URI: http://profiles.wordpress.org/sakush100/
*/
$wptf_upload = wp_upload_dir();

if (!file_exists($wptf_upload['basedir'].'/wptf-uploads/')) {
mkdir($wptf_upload['basedir'].'/wptf-uploads/', 0755, true);
}

if (!file_exists($wptf_upload['basedir'].'/wptf-images/')) {
mkdir($wptf_upload['basedir'].'/wptf-images/', 0755, true);
}

define('WPTFPATH', dirname(__FILE__).'/');
define('WPTFURL', plugins_url( '/', __FILE__ ));

$wptf_types = array(
'simple' => 'Simple (Default)',
'black' => 'Black &amp; White to Normal',
'blur' => 'Blur to normal',
'emboss' => 'Normal to emboss',
'negative' => 'Normal to negative',
'sketch' => 'Normal to sketch'
);

function register_wptf_options(){
register_setting( 'wptf-options', 'sttags' );
register_setting( 'wptf-options', 'stscript' );
}

add_action( 'admin_init', 'register_wptf_options' );


class wptfPaginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $limit;
	var $return;
	var $default_ipp;
	var $querystring;
	var $ipp_array;

	function wptfPaginator()
	{
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->ipp_array = array(5,10,25,50,100);
		$this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
	}

	function paginate()
	{
	error_reporting(0);
		if(!isset($this->default_ipp)) $this->default_ipp=10;
		if($_GET['ipp'] == 'All')
		{
			$this->num_pages = 1;

		}
		else
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
		}
		$this->current_page = (isset($_GET['pagenumber'])) ? (int) $_GET['pagenumber'] : 1 ; // must be numeric > 0
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;
		if($_GET)
		{
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg)
			{
				$keyval = explode("=",$arg);
				if($keyval[0] != "pagenumber" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				if($key != "pagenumber" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}
		if($this->num_pages > 10)
		{
			$this->return = ($this->current_page > 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?pagenumber=$prev_page&ipp=$this->items_per_page$this->querystring\">&laquo; Previous</a> ":"<span class=\"inactive\" href=\"#\">&laquo; Previous</span> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";

				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					$this->return .= ($i == $this->current_page And $_GET['pagenumber'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"$_SERVER[PHP_SELF]?pagenumber=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
			}
			$this->return .= (($this->current_page < $this->num_pages And $this->items_total >= 10) And ($_GET['pagenumber'] != 'All') And $this->current_page > 0) ? "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?pagenumber=$next_page&ipp=$this->items_per_page$this->querystring\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";
			$this->return .= ($_GET['pagenumber'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px;display:none;\" href=\"#\">All</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?pagenumber=1&ipp=All$this->querystring\">All</a> \n";
		}
		else
		{
			for($i=1;$i<=$this->num_pages;$i++)
			{
				$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?pagenumber=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
			}
			$this->return .= "<a class=\"paginate\" style=\"display:none;\" href=\"$_SERVER[PHP_SELF]?pagenumber=1&ipp=All$this->querystring\">All</a> \n";
		}
		$this->low = ($this->current_page <= 0) ? 0:($this->current_page-1) * $this->items_per_page;
		if($this->current_page <= 0) $this->items_per_page = 0;
		$this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
	}
	function display_items_per_page()
	{
		$items = '';
		if(!isset($_GET['ipp'])) $this->items_per_page = $this->default_ipp;
		foreach($this->ipp_array as $ipp_opt) $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return " &nbsp; &nbsp; <span class=\"paginate\">Items per page : </span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?pagenumber=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}
	function display_jump_menu()
	{
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?pagenumber='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}
	function display_pages()
	{
		return $this->return;
	}
}

function wptf_quick_paginate($numrows, $text='Items'){

if(!isset($_GET['ipp'])){
$per_page = 10;
} else {
$per_page = $_GET['ipp'];
}

if(!isset($_GET['pagenumber'])){
$start = 0;
} else {
$start = ($_GET['pagenumber']-1)*$per_page;
}

$pages = new wptfPaginator;
$pages->items_total = $numrows;
$pages->mid_range = 5;
$pages->paginate();
$paginate['data'] = $pages->display_pages();
$paginate['data'] =str_replace('Items', $text, '<div class="pagination"><span class="paginate">Total '.$numrows.' Items Found &nbsp; </span>'.$paginate['data'] .''. $pages->display_items_per_page().'</div>');

$paginate['start'] = $start;
$paginate['per_page'] = $per_page;

return $paginate;
}


function include_wptfsetting_page(){
global $wpdb;
if(isset($_GET['edit'])){
include('wptf-manage.php');
} elseif(isset($_GET['options'])){
include('wptf-options.php');
} else {
global $wptf_types;
include('wptf-settings.php');
}
}

function wptf_image_thumb($thumb, $query){
global $wptf_upload;
$path_parts = pathinfo($thumb);
$thumb2 = $path_parts['filename'].'.'.$path_parts['extension'];
$domain = plugins_url( '', __FILE__ );
$domain2 = $wptf_upload['baseurl'];
$cmt = $path_parts['dirname'];
$query2=str_replace('|', '-pipe-', $query);
if(file_exists($wptf_upload['basedir'].'/wptf-images/'.$query2.'___'.$thumb2)){
return $domain2.'/wptf-images/'.$query2.'___'.$thumb2;
} else {
$get_file1 = file_get_contents($domain.'/wptf-timthumb.php?src='.$domain2.'/wptf-uploads/'.urlencode($thumb).'&'.$query);
$new_file1 = fopen($wptf_upload['basedir'].'/wptf-images/'.$query2.'___'.$thumb2, "w");
fwrite($new_file1, $get_file1);
fclose($new_file1);
return $domain2.'/wptf-images/'.$query2.'___'.$thumb2;
}}

function wpsb_goptions_page(){
include('wptf-goptions.php');
}

function wptf_admin_actions() {  
add_menu_page('WPTF Gallery', 'WPTF Gallery','activate_plugins','wptf-settings.php', 'include_wptfsetting_page',plugins_url( 'icon.png', __FILE__ ),480); 
add_submenu_page( 'wptf-settings.php', 'Documentation', 'Documentation', 'activate_plugins', 'wptf-goptions.php', 'wpsb_goptions_page' );
}  

add_action('admin_menu', 'wptf_admin_actions');


function init_wptf_admin() {
wp_enqueue_script( 'jquery' );
wp_register_script( 'wptfajs', plugins_url( 'js/admin.js', __FILE__ ));
wp_enqueue_script( 'wptfajs' );
wp_register_style( 'wptfacss', plugins_url( 'css/admin.css', __FILE__ ));
wp_enqueue_style( 'wptfacss' );
wp_enqueue_script('thickbox');  
wp_enqueue_style('thickbox'); 
}

function init_wptf_plugin() {
wp_enqueue_script( 'jquery' );
wp_register_script( 'mboxjs', plugins_url( 'lib-mbox/custom.js', __FILE__ ));
wp_enqueue_script( 'mboxjs' );
wp_register_style( 'mboxcss', plugins_url( 'lib-mbox/style.css', __FILE__ ));
wp_enqueue_style( 'mboxcss' );
wp_register_style( 'wptfcss', plugins_url( 'css/style.css', __FILE__ ));
wp_enqueue_style( 'wptfcss' );
wp_register_script( 'wptfjs', plugins_url( 'js/front.js', __FILE__ ));
wp_enqueue_script( 'wptfjs' );
wp_register_style( 'pagenavcss', plugins_url( 'css/simplePagination.css', __FILE__ ));
wp_enqueue_style( 'pagenavcss' );
wp_register_script( 'pagenavjs', plugins_url( 'js/jquery.simplePagination.js', __FILE__ ));
wp_enqueue_script( 'pagenavjs' );
}

function wptf_install(){

global $wpdb;

mysql_query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wptf_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(5000) NOT NULL,
  `name` varchar(5000) DEFAULT NULL,
  `w` varchar(50) DEFAULT NULL,
  `h` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4");

mysql_query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wptf_pics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(5000) NOT NULL,
  `title` varchar(5000) NOT NULL,
  `desc` varchar(5000) NOT NULL,
  `img` varchar(5000) DEFAULT NULL,
  `aid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90");

}

function wptf_shortcode($atts){
global $wpdb;
$out = '';
extract(shortcode_atts(array(
"id" => 'id',
"items_per_page" => 'items_per_page',
"mode" => 'mode',
"thumb_type" => 'thumb_type',
"navigation" => 'navigation'
), $atts));

if($comments=='comments' || $comments=='' || $comments=='facebook'){$comments='facebook';}

if($items_per_page=='items_per_page' || $items_per_page==''){$items_per_pagex=20;} else {$items_per_pagex=$items_per_page;}

if($navigation=='navigation' || $navigation=='' || $navigation=='both'){
$navigation1='<div class="wptf-pnav"></div>';
$navigation2='<div class="wptf-pnav"></div>';
} elseif($navigation=='bottom') {
$navigation1='';
$navigation2='<div class="wptf-pnav"></div>';
} elseif($navigation=='top'){
$navigation1='<div class="wptf-pnav"></div>';
$navigation2='';
} else {
$navigation1='';
$navigation2='';
}

$csys = '';

$data = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_albums` WHERE `id`='$id'"));

$res = mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_pics` WHERE `aid`='$id'");

$out = '<script>wptf_csys = \''.$comments.'\';</script>'.$csys;
global $wptf_types;
if(@array_key_exists($thumb_type, $wptf_types)){include('front/'.$thumb_type.'.php');} else {include('front/'.$data['type'].'.php');}

return $out;
}

function render_wptf($sid, $anim = 'lazySusan'){
return do_shortcode('[wptf  animation="'.$anim.'" slider_id="'.$sid.'"]');
}

function wptf_admin_head(){
echo '<script>wptf_domain = "'.plugins_url().'/wptf-image-gallery";
ajaxurl = \''.admin_url('admin-ajax.php').'\';
mbox_sharethis_tags = "'.preg_replace("/[\n\r]/", "", get_option('sttags')).'";
</script>'.get_option('stscript');
}

function wptf_get_info(){
global $wpdb;
if($_POST['mode']=='descr'){
$data_id = str_replace("wptf-img-","", $_POST['imgid']);
$xdata = mysql_fetch_assoc(mysql_query("SELECT * FROM `".$wpdb->prefix."wptf_pics` WHERE `id`='".$data_id."'"));
echo '<h2>'.$xdata['title'].'</h2>'.$xdata['desc'];
}
die();
}


add_action('wp_ajax_nopriv_wptf_ajax', 'wptf_get_info');
add_action('wp_ajax_wptf_ajax', 'wptf_get_info');

add_action('admin_head', 'wptf_admin_head');
add_action('wp_head', 'wptf_admin_head');
add_action('admin_print_scripts', 'init_wptf_admin');

add_action('wp_enqueue_scripts', 'init_wptf_plugin');

register_activation_hook(__FILE__,'wptf_install'); 

add_shortcode("wptf", "wptf_shortcode");
?>