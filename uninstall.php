<?php
global $wpdb;
mysql_query("DROP TABLE `".$wpdb->prefix."wptf_albums`");
mysql_query("DROP TABLE `".$wpdb->prefix."wptf_pics`");
?>