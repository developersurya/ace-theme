<?php
/*
 *  Adding Custom css and js to admin panel of accf to manipulate the style and behaviour of acf fields
 ==================================================================================================================
*/
function my_acf_admin_head()
{

    wp_enqueue_style('acf-style', get_stylesheet_directory_uri() . '/css/acf-admin-style.css', array());

}

add_action('acf/input/admin_head', 'my_acf_admin_head');