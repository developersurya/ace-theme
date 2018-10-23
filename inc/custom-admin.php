<?php
include( "../../../../wp-config.php") ;
global $wpdb;
$sql = "
					SELECT max(ID) as id from 0a6y1m9_posts
			";
$maxId = $wpdb->get_row($sql);
echo "ATH" . ($maxId->id + 1);
?>