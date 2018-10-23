<?php
/**
 * acethehimalaya functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package acethehimalaya
 */

add_filter('gform_field_content', function ($field_content, $field, $value, $lead_id, $form_id) {

	if ($field->type == 'address' && $form_id != 6 && $form_id != 8) {
		//echo $field_content;
		return str_replace('<select', "<select  class='selectpicker' data-live-search='true'", $field_content);
	}
	if ($field->type == 'multiselect' && $form_id != 3 && $form_id != 4 && $form_id != 8 && $form_id != 2 && $form_id != 7 && $form_id != 12 && $form_id != 13) {
		//echo $field_content;
		return str_replace("class='medium gfield_select'", "class='selectpicker'", $field_content);
	}
	if ($field->type == 'select' && $form_id != 1 && $form_id != 6 && $form_id != 4 && $form_id != 8 && $form_id != 2 && $form_id != 7 && $form_id != 12 && $form_id != 13 && $form_id != 3) {
		return str_replace("class='medium gfield_select'", "class='selectpicker gfield_select'", $field_content);
	}
	return $field_content;
}, 10, 5);

function exclude_category($query) {
	if (isset($_GET['destination']) && $_GET['destination'] != '') {
		if ($query->is_tax('activity') && $query->is_main_query()) {
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'destination',
					'field' => 'slug',
					'terms' => $_GET['destination'],
					'operator' => 'IN',
				),
			);
			$query->set('tax_query', $tax_query);
		}
	}

	return $query;
}

add_action('pre_get_posts', 'exclude_category');

if (!function_exists('acethehimalaya_setup')):

	function acethehimalaya_setup() {

		load_theme_textdomain('acethehimalaya', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		add_theme_support('title-tag');

		add_theme_support('post-thumbnails');

		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('acethehimalaya_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
	}
endif;
add_action('after_setup_theme', 'acethehimalaya_setup');

function acethehimalaya_content_width() {
	$GLOBALS['content_width'] = apply_filters('acethehimalaya_content_width', 640);
}

add_action('after_setup_theme', 'acethehimalaya_content_width', 0);
function acethehimalaya_widgets_init() {
	register_sidebar(array(
		'name' => esc_html__('Sidebar', 'acethehimalaya'),
		'id' => 'sidebar-1',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s"> <div class="widget-wrap">',
		'after_widget' => '</div></section>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	));

	register_sidebar(array(
		'name' => esc_html__('Trip Single Sidebar', 'acethehimalaya'),
		'id' => 'trip-sidebar',
		'description' => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s"> <div class="widget-wrap">',
		'after_widget' => '</div></section>',
		'before_title' => '<h5 class="widget-title hidden-title">',
		'after_title' => '</h5>',
	));

}

add_action('widgets_init', 'acethehimalaya_widgets_init');

function acethehimalaya_scripts() {
	wp_enqueue_style('wpb-google-fonts', '///fonts.googleapis.com/css?family=Domine:400,700|Open+Sans:400,600,700', false);
	//wƒp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/lib/css/fonts.css', array(), true);
	wp_enqueue_style('acethehimalaya-style', get_stylesheet_uri());
	wp_enqueue_style('bootstrap-min-css', get_stylesheet_directory_uri() . '/lib/css/bootstrap.css', array());
	wp_enqueue_style('compile', get_stylesheet_directory_uri() . '/lib/css/compile.css', array());
	wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . '/lib/css/jquery.fancybox.css', array());
	wp_enqueue_style('slick-min', get_stylesheet_directory_uri() . '/lib/css/slick-min.css', array());
	wp_enqueue_style('mCustomScrollbar', get_stylesheet_directory_uri() . '/lib/css/jquery.mCustomScrollbar.min.css', array());
	wp_enqueue_script('scripts', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), '1.11', false);
	wp_enqueue_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js', array(), '3.3.6', false);
	wp_enqueue_script('cookie-js', get_template_directory_uri() . '/lib/js/jquery.cookie.js', array(), '1.4.1', false);
	wp_enqueue_script('acethehimalaya-script', get_template_directory_uri() . '/lib/js/plugins.js', array());
	wp_enqueue_script('acethehimalaya-main', get_template_directory_uri() . '/lib/js/main.js', array());
	wp_enqueue_script('ace-bootstrap-select', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js', array());
	wp_enqueue_style('ace-bootstrap-select-css', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css');
	wp_enqueue_style('jquery-ui-css', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_localize_script(
		'scripts', 'ajax_object',
		array(
			'ajax_url' => admin_url('admin-ajax.php'),
		)
	);
}

add_action('wp_enqueue_scripts', 'acethehimalaya_scripts');

require get_template_directory() . '/lib/inc/custom-header.php';

require get_template_directory() . '/lib/inc/template-tags.php';

require get_template_directory() . '/lib/inc/extras.php';

require get_template_directory() . '/lib/inc/customizer.php';

function my_acf_admin_head() {

	wp_enqueue_style('acf-style', get_stylesheet_directory_uri() . '/lib/css/acf-admin-style.css', array());

}

add_action('acf/input/admin_head', 'my_acf_admin_head');

function wpcodex_add_excerpt_support_for_pages() {
	add_post_type_support('page', 'excerpt');
}

add_action('init', 'wpcodex_add_excerpt_support_for_pages');

function new_excerpt_more($more) {
	return '';
}

add_filter('excerpt_more', 'new_excerpt_more');

/**
 *
 * Custom Admin filter for activities
 * =========================================================
 */
//add_action('restrict_manage_posts', 'my_filter_list');
function my_filter_list() {
	$screen = get_current_screen();
	global $wp_query;
	if ($screen->post_type == 'trip') {
		wp_dropdown_categories(array(
			'show_option_all' => 'Show All Activities',
			'taxonomy' => 'activity',
			'name' => 'activity',
			'orderby' => 'name',
			'selected' => (isset($wp_query->query['activity']) ? $wp_query->query['activity'] : ''),
			'hierarchical' => false,
			'depth' => 3,
			'show_count' => false,
			'hide_empty' => true,
		));
	}
}

add_filter('parse_query', 'perform_filtering');
function perform_filtering($query) {
	$qv = &$query->query_vars;
	if (($qv['activity']) && is_numeric($qv['activity'])) {
		$term = get_term_by('id', $qv['activity'], 'activity');
		$qv['activity'] = $term->slug;
	}
}

/**
 * Custom Admin filter for Destination
 * ===========================================================
 */
add_action('restrict_manage_posts', 'my_filter_destination');
function my_filter_destination() {
	$screen = get_current_screen();
	global $wp_query;
	if ($screen->post_type == 'trip') {
		wp_dropdown_categories(array(
			'show_option_all' => 'Show All Destination',
			'taxonomy' => 'destination',
			'name' => 'destination',
			'orderby' => 'name',
			'selected' => (isset($wp_query->query['destination']) ? $wp_query->query['destination'] : ''),
			'hierarchical' => false,
			'depth' => 3,
			'show_count' => false,
			'hide_empty' => true,
		));
	}
}

add_filter('parse_query', 'perform_desti_filtering');
function perform_desti_filtering($query) {
	$qv = &$query->query_vars;
	if (($qv['destination']) && is_numeric($qv['destination'])) {
		$term = get_term_by('id', $qv['destination'], 'destination');
		$qv['destination'] = $term->slug;
	}
}

/**
 * This code register the theme option.
 */

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Ace Options',
		'menu_title' => 'Ace Options',
		'menu_slug' => 'ace-options',
		'capability' => 'edit_posts',
		'redirect' => false,
	));
}
// Remove theme customizer
add_action('after_setup_theme', 'remove_custom_wpoption', 20);

function remove_custom_wpoption() {
	remove_custom_background();
	remove_custom_image_header();
}

//for shortcode support in widget
add_filter('widget_text', 'do_shortcode');
//for support svg
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

//// Register Navigation Menus
function custom_navigation_menus() {

	$locations = array(
		'primary_menu' => __('Primary Menu', 'acethehimalaya'),
		'secondary_menu' => __('Secondary Menu', 'acethehimalaya'),
	);
	register_nav_menus($locations);

}

add_action('init', 'custom_navigation_menus');

//Responsive iamge hook
function adjust_image_sizes_attr($sizes, $size) {
	$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	return $sizes;
}

add_filter('wp_calculate_image_sizes', 'adjust_image_sizes_attr', 10, 2);

function trips_where($where) {
	if (is_page('find-trip') || is_page('trip-find')) {
		$where = str_replace("meta_key = 'small_group_journey_%", "meta_key LIKE 'small_group_journey_%", $where);
	}
	return $where;
}

add_filter('posts_where', 'trips_where');

function count_depature_trip($key) {

	global $wpdb;
	$sql = "SELECT count(post_id) as counts  FROM `0a6y1m9_postmeta` WHERE `meta_key` LIKE 'small_group_journey_%_start_date/end_date' AND `meta_value` LIKE '" . $key . "'";
	$posts = $wpdb->get_row($sql);
	return $posts->counts;
}

function filter_departure_date() {
	global $wpdb;
	$q = "SELECT DISTINCT(CONCAT(substr(meta_value, 7, 4), substr(meta_value, 1, 2))) as dttt, substr(meta_value, 7, 4) as yr, substr(meta_value, 1, 2) as mn, CONCAT('%', substr(meta_value, 1, 2), '/%/', substr(meta_value, 7, 4), ' -%') as dt FROM `0a6y1m9_postmeta` WHERE `meta_key` LIKE 'small_group_journey_%_start_date/end_date' AND meta_value != '' ORDER BY `dttt` ASC";
	$results = $wpdb->get_results($q);
	return $results;
}

function find_trip_get($taxonomy_activity_id, $taxonomy_dest_id, $trip_date, $cost_m, $costM, $tripd, $tripD) {
	global $wpdb;

	$sql = "
            SELECT 0a6y1m9_posts.ID FROM 0a6y1m9_posts INNER JOIN 0a6y1m9_term_relationships ON (0a6y1m9_posts.ID = 0a6y1m9_term_relationships.object_id) INNER JOIN 0a6y1m9_term_relationships AS tt1 ON (0a6y1m9_posts.ID = tt1.object_id) INNER JOIN 0a6y1m9_postmeta ON ( 0a6y1m9_posts.ID = 0a6y1m9_postmeta.post_id ) INNER JOIN 0a6y1m9_postmeta AS mt1 ON ( 0a6y1m9_posts.ID = mt1.post_id ) INNER JOIN 0a6y1m9_postmeta AS mt2 ON ( 0a6y1m9_posts.ID = mt2.post_id ) INNER JOIN 0a6y1m9_postmeta AS mt3 ON ( 0a6y1m9_posts.ID = mt3.post_id ) WHERE 1=1
            ";
	if ($taxonomy_activity_id != '' && $taxonomy_activity_id != '0') {
		$sql .= "  AND ( 0a6y1m9_term_relationships.term_taxonomy_id IN ($taxonomy_activity_id)) ";
	}

	if ($taxonomy_dest_id != '') {
		$sql .= " AND (tt1.term_taxonomy_id IN ($taxonomy_dest_id) ) ";
	}

	$sql .= "  AND ( 0a6y1m9_postmeta.meta_key = 'trip_cost' AND CAST(0a6y1m9_postmeta.meta_value AS SIGNED) BETWEEN '$cost_m' AND '$costM' ) ";
	$sql .= " AND ( mt1.meta_key = 'total_days' AND CAST(mt1.meta_value AS SIGNED) BETWEEN '$tripd' AND '$tripD' ) ";

	if ($trip_date != '') {
		$sql .= "AND (  mt2.meta_key = 'departure_or_group_trip' AND CAST(mt2.meta_value AS CHAR) = '1' )
            AND ( mt3.meta_key LIKE 'small_group_journey_%_start_date/end_date' AND CAST(mt3.meta_value AS CHAR)
            LIKE '$trip_date' )  ";
	}

	$sql .= "AND 0a6y1m9_posts.post_type = 'trip' AND (0a6y1m9_posts.post_status = 'publish' OR 0a6y1m9_posts.post_status = 'acf-disabled' OR 0a6y1m9_posts.post_status = 'private') GROUP BY 0a6y1m9_posts.ID ORDER BY 0a6y1m9_posts.post_date DESC";
	// print $sql;
	// exit();
	$results = $wpdb->get_results($sql);
	return $results;

}

//Remove website field from comment form
function remove_comment_fields($fields) {
	unset($fields['url']);
	return $fields;
}

add_filter('comment_form_default_fields', 'remove_comment_fields');

//image size
add_image_size('home-trip', 400, 267, array('center', 'center', true));
add_image_size('small-thumb', 245, 130, array('center', 'center', true));
add_image_size('square', 560, 400, array('center', 'center', true));

// delete the next line if you do not need additional image sizes

add_image_size('footer-blog-thumb', 300, 205, true); // Hard Crop Mode
add_image_size('banner-image', 1920, 600, true); //above 320 pixels wide
add_image_size('banner-image-tab', 1024, 520, true); //above 768 pixels wide
add_image_size('banner-image-mobile', 420, 300, true); //above 1200 pixels wide

//function created to add the alt text to the image tag
function get_image_alt_value($image_url, $default = '') {
	if ($img_id = get_image_id($image_url)) {
		return $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
	}
	return $default;
}

// retrieves the attachment ID from the file URL
function get_image_id($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
	if ($attachment[0] > 0) {
		return $attachment[0];
	}
	return false;
}

require dirname(__FILE__) . '/inc/custom-functions.php';

/*==============================
Populating trip title in dropdown in the testimonial form
=================================*/

add_filter('gform_pre_render_10', 'populate_posts');
function populate_posts($form) {

	foreach ($form['fields'] as &$field) {
		if ($field->id == 18) {
			$posts = get_posts('numberposts=-1&post_type=trip');
			$postSlug = get_post(get_the_ID());
			$slug = $postSlug->post_name;
			$choices = array();
			if (!is_page(3550)) {
				//reviews page id
				$choices[] = array('text' => get_the_title(), 'value' => $slug);
			}
			$choices[] = array('text' => 'General Category', 'value' => 'general');

			foreach ($posts as $post) {
				if ($slug != $post->post_name) {
					$choices[] = array('text' => $post->post_title, 'value' => $post->post_name);
				}
			}

			$field->choices = $choices;
		}
	}

	return $form;
}

//add_filter('gform_pre_render_3', 'populate_custom_field');
function populate_custom_field($form) {

	$pid = $_POST['post_id'];
	if (!isset($_SESSION['post_id']) || !isset($_SESSION['slug-name'])):
		$_SESSION['post_id'] = $pid;
	endif;
	$today = strtotime(date('Y-m-d'));

	////check the slug of new date post
	$post_slug = $_POST['trip_slug_name'];
	$args = array(
		'post_type' => 'tripdates',
		'name' => $post_slug,
	);
	$trip_posts = array();
	$loop = new WP_Query($args);
	while ($loop->have_posts()): $loop->the_post();
		$p_id = get_the_ID();
		wp_reset_postdata();
	endwhile;

	foreach ($form['fields'] as &$field) {
		if ($field->id == 1) {
			$pid = $_POST['post_id'];

			//new trip date post type
			if (have_rows('new_small_group_journey', $p_id)) {
				while (have_rows('new_small_group_journey', $p_id)): the_row();
					if (!empty(get_sub_field('new_start_dateend_date'))) {

						$dateS = explode('-', get_sub_field('new_start_dateend_date'));
						if (strtotime($dateS[0]) >= $today) {
							$choices[] = array('text' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])), 'value' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])));
						}
					}
				endwhile;
			}

			$field->placeholder = 'Fixed Departure Dates';

			$field->choices = $choices;
		} else {
			if (have_rows('small_group_journey', $pid)):
				while (have_rows('small_group_journey', $pid)): the_row();
					if (!empty(get_sub_field('start_date/end_date'))) {
						$dateS = explode('-', get_sub_field('start_date/end_date'));
						$choices[] = array('text' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])), 'value' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])));
					}
				endwhile;
			endif;

			$field->placeholder = 'Fixed Departure Dates';

			$field->choices = $choices;
		}
	}

	return $form;
}

//Form dynamic populate with departure dates in booking page
add_filter('gform_pre_validation_13', 'populate_departure_date');
add_filter('gform_pre_submission_filter_13', 'populate_departure_date');
add_filter('gform_admin_pre_render_13', 'populate_departure_date');
add_filter('gform_pre_render_13', 'populate_departure_date');
add_action('gform_after_submission_13', 'populate_departure_date', 10, 2);
function populate_departure_date($form) {
	$pid = $_POST['post_id'];
	if (!isset($_SESSION['post_id']) || !isset($_SESSION['slug-name'])):
		$_SESSION['post_id'] = $pid;
	endif;
	$today = strtotime(date('Y-m-d'));

	////check the slug of new date post
	$post_slug = $_POST['trip_slug_name'];
	$args = array(
		'post_type' => 'tripdates',
		'name' => $post_slug,
	);
	$trip_posts = array();
	$loop = new WP_Query($args);
	while ($loop->have_posts()): $loop->the_post();
		$p_id = get_the_ID();
		wp_reset_postdata();
	endwhile;

	foreach ($form['fields'] as &$field) {
		if ($field->id == 37) {

			//new trip date post type
			if (have_rows('new_small_group_journey', $p_id)) {
				while (have_rows('new_small_group_journey', $p_id)): the_row();
					if (!empty(get_sub_field('new_start_dateend_date'))) {
						$dateS = explode('-', get_sub_field('new_start_dateend_date'));
						if (strtotime($dateS[0]) >= $today) {
							$choices[] = array('text' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])), 'value' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])));
						}
					}
				endwhile;

				$field->placeholder = 'Fixed Departure Dates';
				$field->choices = $choices;

			} else {

				if (have_rows('small_group_journey', $_SESSION['post_id'])):
					while (have_rows('small_group_journey', $_SESSION['post_id'])): the_row();
						if (!empty(get_sub_field('start_date/end_date'))) {

							$dateS = explode('-', get_sub_field('start_date/end_date'));
							if (strtotime($dateS[0]) >= $today) {
								$choices[] = array('text' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])), 'value' => date('F j, Y', strtotime($dateS[0])) . ' - ' . date('F j, Y', strtotime($dateS[1])));
							}
						}
					endwhile;
				endif;
				$field->placeholder = 'Fixed Departure Dates';
				$field->choices = $choices;
			}
		}

		//normal dropdown populate
		if ($field->id == 46) {
			//new trip date post type
			if (have_rows('new_small_group_journey', $p_id)) {
				while (have_rows('new_small_group_journey', $p_id)): the_row();
					if (!empty(get_sub_field('new_start_dateend_date'))) {

						$dateS = explode('-', get_sub_field('new_start_dateend_date'));
						if (strtotime($dateS[0]) >= $today) {
							//$choices[] = array('text' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])), 'value' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])));
						}
					}
				endwhile;
			} else {
				//old trip post type
				if (have_rows('small_group_journey', $_SESSION['post_id'])) {
					while (have_rows('small_group_journey', $_SESSION['post_id'])): the_row();
						if (!empty(get_sub_field('start_date/end_date'))) {

							$dateS = explode('-', get_sub_field('start_date/end_date'));
							if (strtotime($dateS[0]) >= $today) {
								//$choices[] = array('text' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])), 'value' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])));
							}
						}
					endwhile;
				}
			}

			$field->placeholder = 'Fixed Departure Dates';

			$field->choices = $choices;
		}
	}

	return $form;
}

/*
 * Destroy session if not booking form page
 * */

if (!is_page('booking-form')) {
	if (isset($_SESSION['post_id']) || isset($_SESSION['slug-name'])) {
		unset($_SESSION['post_id']);
		unset($_SESSION['slug-name']);
	}
}
//add_filter( 'gform_pre_render_13', 'populate_departure_date' );
//add_filter( 'gform_pre_validation_13', 'populate_departure_date' );
//add_filter( 'gform_admin_pre_render_13', 'populate_departure_date' );
//add_filter( 'gform_pre_submission_filter_13', 'populate_departure_date' );
//function populate_departure_date( $form ) {
//    $today = strtotime(date('Y-m-d'));
//    //only populating drop down for form id 5
//    if ( $form['id'] != 13 ) {
//        return $form;
//    }
//    $pid = $_POST['post_id'];
//    //Creating item array.
//    $items = array();
//
//    //Adding initial blank value.
//    $items[] = array( 'text' => '', 'value' => '' );
//
//    //Adding post titles to the items array
//    if (have_rows('small_group_journey', $pid)):
//
//              while (have_rows('small_group_journey', $pid)): the_row();
//                  if (!empty(get_sub_field('start_date/end_date'))) {
//                  $dateS = explode('-', get_sub_field('start_date/end_date'));
//                      if (strtotime($dateS[0]) >= $today) {
//                        $items[] = array('text' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])), 'value' => date('F j Y', strtotime($dateS[0])) . ' - ' . date('F j Y', strtotime($dateS[1])));
//                     }
//                  }
//                endwhile;
//        endif;
//
//    //Adding items to field id 8. Replace 8 with your actual field id. You can get the field id by looking at the input name in the markup.
//    foreach ( $form['fields'] as &$field ) {
//        if ( $field->id == 37 ) {
//
//            $field->placeholder = 'Fixed Departure Dates';
//            $field->choices = $items;
//        }
//    }
//
//    return $form;
//}

add_filter('gform_pre_render_11', 'populate_post');
function populate_post($form) {

	foreach ($form['fields'] as &$field) {
		if ($field->id == 5) {
			$posts = get_posts('numberposts=-1&post_type=trip');

			$choices = array();

			foreach ($posts as $post) {
				$choices[] = array('text' => $post->post_title, 'value' => $post->post_name);
			}

			// update 'Select a Post' to whatever you'd like the instructive option to be
			$field->placeholder = 'Select a Trip';

			$field->choices = $choices;
		}
	}

	return $form;
}

//add_filter('gform_pre_render_2', 'populate_day_trips');
//add_filter('gform_pre_validation_2', 'populate_day_trips');
//add_filter('gform_pre_submission_filter_2', 'populate_day_trips');
//add_filter('gform_admin_pre_render_2', 'populate_day_trips');
////add_filter('gform_pre_render_2', 'populate_day_trips');
//function populate_day_trips($form)
//{
//
//
//    foreach ($form['fields'] as &$field) {
//
//        $field_id = 26;
//        if ($field->id != $field_id) {
//            continue;
//        }
//
//        $args = array(
//            'post_type' => 'trip',
//            'posts_per_page' => '-1',
//            'meta_query' => array(
//                array(
//                    'key' => 'trip_extension',
//                    'value' => '1',
//                    'compare' => '=='
//                )
//            )
//        );
//        if ($field->id == 26) {
//            $posts = get_posts($args);
//
//            $choices = array();
//
//            $input_id = 1;
//            foreach ($posts as $post) {
//                if ($input_id % 10 == 0) {
//                    $input_id++;
//                }
//
//                $choices[] = array('text' => $post->post_title, 'value' => $post->post_name);
//                $inputs[] = array('label' => $post->post_title, 'id' => "{$field_id}.{$input_id}");
//                $input_id++;
//            }
//
//            // update 'Select a Post' to whatever you'd like the instructive option to be
//            $field->placeholder = 'Trip Extension';
//
//            $field->choices = $choices;
//            $field->inputs = $inputs;
//        }
//    }
//
//    return $form;
//}
//
//add_filter('gform_pre_render_13', 'populate_day_trip');
//add_filter('gform_pre_validation_13', 'populate_day_trip');
//add_filter('gform_pre_submission_filter_13', 'populate_day_trip');
//add_filter('gform_admin_pre_render_13', 'populate_day_trip');
////add_filter('gform_pre_render_13', 'populate_day_trip');
//function populate_day_trip($form)
//{
//
//    foreach ($form['fields'] as &$field) {
//
//        $field_id = 26;
//        if ($field->id != $field_id) {
//            continue;
//        }
//
//        $args = array(
//            'post_type' => 'trip',
//            'posts_per_page' => '-1',
//            'meta_query' => array(
//                array(
//                    'key' => 'trip_extension',
//                    'value' => '1',
//                    'compare' => '=='
//                )
//            )
//        );
//
//
//        if ($field->id == 26) {
//            $posts = get_posts($args);
//
//            $choices = array();
//            $input_id = 1;
//            foreach ($posts as $post) {
//                if ($input_id % 10 == 0) {
//                    $input_id++;
//                }
//
//                $choices[] = array('text' => $post->post_title, 'value' => $post->post_name);
//                $inputs[] = array('label' => $post->post_title, 'id' => "{$field_id}.{$input_id}");
//                $input_id++;
//            }
//
//            // update 'Select a Post' to whatever you'd like the instructive option to be
//            $field->placeholder = 'Trip Extension';
//
//            $field->choices = $choices;
//            $field->inputs = $inputs;
//        }
//    }
//
//    return $form;
//}

add_filter('posts_search', 'wpse_45153_filter_search', null, 2);
function wpse_45153_filter_search($search, $a_wp_query) {
	if (!is_admin()) {
		return $search;
	}
	// work only in the dashboard

	$search = preg_replace("# OR \(.*posts\.post_content LIKE \\'%.*%\\'\)#", "", $search);

	return $search;
}

/**
 * Truncate string in center
 *
 * @param $file File basename
 * @return truncated file name
 */
function ace_truncate_text($str, $length = 20) {
	if (strlen($str) <= $length) {
		return $str;
	}
	$separator = '...';
	$separatorlength = strlen($separator);
	$maxlength = $length - $separatorlength;
	$start = $maxlength / 2;
	$trunc = strlen($str) - $maxlength;

	return substr_replace($str, $separator, $start, $trunc);
}

function tax_paginate($cntQuery, $page, $slug) {
	if (!isset($page)) {
		$page = 1;
	}
	$pagination = '';
	$totalpage = $cntQuery->found_posts;
	if (isset($page)) {
		$numPost = $page * 10;
	} else {
		$numPost = 10;
	}
	$prev = $page - 1;
	if ($totalpage > $numPost) {
		$next = $page + 1;
		$pagination .= '<div class="alignright"><a  href=' . site_url() . '/testimonial-category/' . $slug . '?page=' . $next . '>' . 'next' . '</a></div>';
		if ($prev > 0) {
			$pagination .= '<div class="alignleft"><a  href=' . site_url() . '/testimonial-category/' . $slug . '?page=' . $prev . '>' . 'prev' . '</a></div>';
		}
	} else {
		if ($prev != 0) {
			$pagination .= '<div class="alignleft"><a  href=' . site_url() . '/testimonial-category/' . $slug . '?page=' . $prev . '>' . 'prev' . '</a></div>';
		}
	}
	echo $pagination;
}

add_filter('bwsplgns_get_pdf_print_content', 'pdf_content');

function pdf_content($content) {
	if (is_singular('trip')) {
		global $post;
		$pid = $post->ID;
		$html = '';
		//$map = get_field("trip_map");
		$banner_img = wp_get_attachment_image_src(get_post_thumbnail_id($pid), "full");
		if ($banner_img[0] != '') {
			$html .= '<img class="banner-image" src="' . $banner_img[0] . '"  alt="' . $post->post_title . '">';
		}

		$html .= '<h1 class="print-title">' . $post->post_title . '</h1>';

		$trip_code = get_field("trip_code", $pid);
		$trip_days = get_field("total_days", $pid);
		$trip_size = get_field("group_size", $pid);
		$trip_cost = get_field("trip_cost", $pid);
		$trip_level = get_field("trip_level", $pid);
		$trip_alt = get_field("max_altitude", $pid);
		$trip_country = get_field("country_visited", $pid);
		$trip_desti = get_field("destination", $pid);
		$trip_season = get_field("best_season", $pid);
		$trip_activityday = get_field("activity_per_day", $pid);
		$trip_route = get_field("trip_route", $pid);
		$trip_activity = get_field("activity", $pid);
		$trip_category = get_field("destination", $pid);
		$trip_discount = get_field("discount_percentage", $pid);
		$trip_level_type = get_field("trip_level_type", $pid);
		if ($trip_discount) {
			$dcost = $trip_cost - ($trip_discount / 100) * $trip_cost;
		}

		$html .= '<ul class="trip-facts clearfix">';
		if ($trip_code) {
			$html .= '<li class="trip-code odd"><span class="trip-facts__title"><i class="icon-tf_pen"></i>Trip Code: </span><span>' . $trip_code . '</span></li>';
		}
		if ($trip_country) {
			$html .= '<li class="trip-visited even"><span class="trip-facts__title"><i class="icon-tf_country"></i>Country: </span><span>' . $trip_country . '</span></li>';
		}
		if ($trip_days) {
			$html .= '<li class="trip-days odd"><span class="trip-facts__title"><i class="icon-tf_clock"></i>Duration: </span><span>' . $trip_days . ' Days</span></li>';
		}
		if ($trip_level) {
			$html .= '<li class="trip-level even col-lg-6';
			if ($trip_level_type == 'Biking') {
				$html .= ' biking-type';
			} elseif ($trip_level_type == 'Climbing') {
				$html .= ' climbing-type';
			} else {
				$html .= ' tour-treks-type';
			}
			if ($trip_level == 'Easy') {
				$html .= ' Easy';
			} elseif ($trip_level == 'Beginners') {
				$html .= ' Beginners';
			} elseif ($trip_level == 'Advanced Beginners') {
				$html .= ' advanced-beginners';
			} elseif ($trip_level == 'Moderate') {
				$html .= ' Moderate';
			} elseif ($trip_level == 'Demanding') {
				$html .= ' Demanding';
			} elseif ($trip_level == 'Strenuous') {
				$html .= ' Strenuous';
			} elseif ($trip_level == 'Challenging') {
				$html .= ' Challenging';
			} elseif ($trip_level == 'Tough') {
				$html .= ' Tough';
			} elseif ($trip_level == 'Very Strenuous') {
				$html .= ' very-strenuous';
			} elseif ($trip_level == 'Intermediate') {
				$html .= ' Intermediate';
			} elseif ($trip_level == 'Advanced') {
				$html .= ' Advanced';
			}
			$html .= '"><span class="trip-facts__title"><i class="icon-';
			if ($trip_level_type == 'Biking') {
				$html .= 'biking';
			} elseif ($trip_level_type == 'Climbing') {
				$html .= 'climbing';
			} else {
				$html .= 'tf_level';
			}
			$html .= '"></i>Trip Level: </span><span>' . $trip_level . '</span>';

			$html .= '</li>';

		}
		if ($trip_alt) {
			$html .= '<li class="trip-altitude odd"><span class="trip-facts__title"><i class="icon-tf_altitude"></i>Max Altitude: </span><span>' . $trip_alt . '</span></li>';
		}
		if ($trip_activity) {
			$html .= '<li class="trip-activity even"><span class="trip-facts__title"><i class="icon-tf_activity"></i>Activity: </span><span>' . $trip_activity . '</span></li>';
		}
		if (get_field("starts_at", $pid)) {
			$html .= '<li class="trip-starts-at odd"><span class="trip-facts__title"><i class="icon-tf_trip-start"></i>Starts at: </span><span>' . get_field("starts_at", $pid) . '</span></li>';
		}
		if (get_field("ends_at", $pid)) {
			$html .= '<li class="trip-ends-at even"><span class="trip-facts__title"><i class="icon-tf_trip-end"></i>Ends at: </span><span>' . get_field("ends_at", $pid) . '</span></li>';
		}

		$html .= '</ul>';

		$html .= '<ul class="trip-facts full-width clearfix">';
		if ($trip_route) {
			$html .= '<li class="trip-route"><span class="trip-facts__title"><i class="icon-tf_trip-route"></i>Trip Route:</span><span>' . $trip_route . '</span></li>';
		}
		if ($trip_season) {
			$html .= '<li class="trip-season"><span class="trip-facts__title"><i class="icon-tf_season"></i>Best Season: </span><span>' . $trip_season . '</span></li>';
		}

		$html .= '</ul>';

		if (get_field('trip_highlight', $pid) != '') {
			$html .= '<div class="col-lg-12 trip-highlight">';
			$html .= '<h4 class="section__heading">Trip Highlights</h4>';
			$html .= apply_filters('the_content', get_field('trip_highlight', $pid)) . '</div>';
		}

		if ($post->post_content != '') {
			$html .= '<div class="trip-info">';
			$html .= '<h4 class="section__heading">Trip Information</h4>' . apply_filters('the_content', $post->post_content) . '</div>';
		}

		if (have_rows('detail_itinerary', $pid)):
			$html .= '<h4 class="section__heading">Detailed Itinerary</h4>';
			while (have_rows('detail_itinerary', $pid)): the_row();
				$html .= '<div class="itinerary--item">';
				$html .= '<h6>' . get_sub_field("heading") . '</h6>' . get_sub_field("description") . '</div>';
			endwhile;
		endif;

		if (get_field("include_description", $pid)) {
			$html .= '<div class="include_note">' . get_field("include_description", $pid) . '</div>';
		}
		if (have_rows('cost_includes')) {
			$html .= '<h4 class="section__heading">Price Includes</h4>';
			$html .= '<ul class="clearfix cost-included">';
			while (have_rows('cost_includes', $pid)) {
				the_row();

				$html .= '<li><span class="icon-included"></span><p>' . get_sub_field("included", $pid) . '</p></li>';

			}
			$html .= '</ul>';
		}
		if (have_rows('not_include', $pid)):
			$html .= '<h4 class="section__heading">Price Does not Include</h4>';
			$html .= '<ul class="clearfix cost-excluded">';
			while (have_rows('not_include', $pid)): the_row();
				$html .= '<li><span class="icon-cross"></span><p>' . get_sub_field("excluded", $pid) . '</p></li>';
			endwhile;
			$html .= '</ul>';
		endif;
		$html .= '<div style="margin-top:20px;">' . get_field("include_exclude_note", $pid) . '</div>';
		//if(isset($_GET['id'])) {
		if (have_rows('sidebar_before_booking_a_trip', $_GET['id'])):
			while (have_rows('sidebar_before_booking_a_trip', $_GET['id'])): the_row();
				$page_link[] = get_sub_field('page_url', $_GET['id']);

			endwhile;

			if (in_array("/before-booking-a-trip/your-leader/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/your-leaders');
				$post_content = get_post($page->ID);
				$html .= '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/travel-insurance/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/travel-insurance');
				$post_content = get_post($page->ID);
				$html .= '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/altitude-sickness-info/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/altitude-sickness-info');
				$post_content = get_post($page->ID);
				$altitude_sickness_info = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/nepal-international-flights/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/nepal-international-flights');
				$post_content = get_post($page->ID);
				$international_flights = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/india-international-flights/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/india-international-flights');
				$post_content = get_post($page->ID);
				$international_flights = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/bhutan-international-flights/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/bhutan-international-flights');
				$post_content = get_post($page->ID);
				$international_flights = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/tibet-international-flights/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/tibet-international-flights');
				$post_content = get_post($page->ID);
				$international_flights = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/multi-country-international-flights/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/multi-country-international-flights');
				$post_content = get_post($page->ID);
				$international_flights = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/nepal-travel-guide/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/nepal-travel-guide');
				$post_content = get_post($page->ID);
				$travel_guide = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/india-travel-guide/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/india-travel-guide');
				$post_content = get_post($page->ID);
				$travel_guide = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/bhutan-travel-guide/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/bhutan-travel-guide');
				$post_content = get_post($page->ID);
				$travel_guide = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/tibet-travel-guide/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/tibet-travel-guide');
				$post_content = get_post($page->ID);
				$travel_guide = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
			if (in_array("/before-booking-a-trip/multi-country-travel-guide/", $page_link)) {
				$page = get_page_by_path('before-booking-a-trip/multi-country-travel-guide');
				$post_content = get_post($page->ID);
				$travel_guide = '<h4 class="section__heading">' . $post_content->post_title . '</h4>' . apply_filters('the_content', $post_content->post_content);
			}
		endif;

		// }
		if (get_field("equipment_main_description", $pid) || have_rows('equipments', $pid) || get_field('equipment_extra_description', $pid)) {
			$html .= '<h4 class="section__heading">Equipment</h4>' . get_field("equipment_main_description", $pid);

			if (have_rows('equipments', $pid)):
				while (have_rows('equipments', $pid)): the_row();

					$html .= '<h5 class="section__heading">' . get_sub_field("heading") . '</h5>' . get_sub_field("equipment_list");

				endwhile;
			endif;
			if (get_field('equipment_extra_description', $pid)) {

				$html .= '<div class="equipment-extra-description">' . get_field("equipment_extra_description", $pid) . '</div>';
			}
		}

		if ($altitude_sickness_info) {
			$html .= $altitude_sickness_info;
		}
		if ($international_flights) {
			$html .= $international_flights;
		}
		if ($travel_guide) {
			$html .= $travel_guide;
		}
		if (have_rows('faqs_list', $pid)):
			$html .= '<h4 class="section__heading">FAQs</h4>';
			while (have_rows('faqs_list', $pid)): the_row();
				$html .= '<h6>' . get_sub_field("question") . '</h6>';
				$html .= '<p class="panel-body">' . get_sub_field("answer") . '</p>';
			endwhile;
		endif;
		if (get_field('trip_note')) {
			$html .= '<div class="extra-info">' . get_field('trip_note') . '</div><!--extra-info-->';
		}
		if (get_field('trip_distinct_features')) {
			$html .= '<div class="trip-speciality">' . get_field('trip_distinct_features') . '</div>';
		}
		$html .= '<h4 class="section__heading">Contact Us</h4>';
		$html .= '<h6>Head Office</h6>';

		$html .= '<div class="footer-contact--row">';
		$html .= '<div class="col">' . get_field('head_office', 'option') . '</div>';
		$html .= '<div class="col">' . get_field('north_america_office', 'option') . '</div>';
		$html .= '<div class="col">' . get_field('europe_office', 'option') . '</div>';
		$html .= '</div>';
		$html .= '<div class="footer-contact--row">';

		$html .= '<div class="col">' . get_field('south_africa_office', 'option') . '</div>';
		$html .= '<div class="col">' . get_field('indonesia_office', 'option') . '</div>';
		$html .= '<div class="col">' . get_field('russia_and_east_europe_office', 'option') . '</div>';
		if (get_field('b2b_email')) {
			$html .= '<span class="b2b-email">' . get_field('b2b_email') . '</span>';
		}
		$html .= '</div>';
		$map = get_field("trip_map");
		if ($map != '') {
			$html .= '<h4 class="section__heading map-title">Larger Map</h4>';
			$html .= '<img class="img-map" src="' . $map['url'] . '"  alt="' . $map['alt'] . '">';
		}
		return $html;
	}
}

function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

function ip_visitor_country() {
	$ip = $_SERVER['REMOTE_ADDR'];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=" . $ip);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$ip_data_in = curl_exec($ch);
	curl_close($ch);

	$ip_data = json_decode($ip_data_in, true);
	$ip_data = str_replace('&quot;', '"', $ip_data);

	if ($ip_data && $ip_data['geoplugin_countryName'] != null) {
		$country = $ip_data['geoplugin_countryName'];
	}
	$explCountry = explode(' ', $country);
	$explCountryComma = explode(', ', $country);
	if (!isset($explCountryComma[1])) {
		if (!isset($explCountry[1])) {
			$slugToMatch = get_field('country_' . strtolower($country) . '_number', 'option');
		} else {
			$slugToMatch = get_field('country_' . strtolower($explCountry[0]) . '_' . strtolower($explCountry[1]) . '_number', 'option');
		}
	} else {
		$explAfterComma = explode(' ', $explCountryComma[1]);
		$slugToMatch = get_field('country_' . strtolower($explCountryComma[0]) . '_' . $explAfterComma[0] . '_number', 'option');
	}
	if (empty($slugToMatch)) {
		$slugToMatch = get_field('default_phone_number', 'option');
	}
	return $slugToMatch;

}

add_action('do_meta_boxes', 'replace_featured_image_box');
function replace_featured_image_box() {
	remove_meta_box('postimagediv', 'trip', 'side');
	add_meta_box('postimagediv', __('Banner Image'), 'post_thumbnail_meta_box', 'trip', 'side', 'low');
}

//    add_action( 'init', 'stop_heartbeat', 1 );
//    function stop_heartbeat() {
//        wp_deregister_script('heartbeat');
//    }

//admin : hide menu options
/* ------------ for lastdoor admin only ------------- */
//$current_user = wp_get_current_user();
//if ( $current_user->data->user_login != 'lastdoor' ) {
//    function remove_menus() {
//        //Search filter pro
//        remove_menu_page( 'edit.php?post_type=search-filter-widget' );
//        //Comments
//        remove_menu_page( 'edit-comments.php' );
//        //Appearance
//        remove_menu_page( 'themes.php' );
//        //Users
//        remove_menu_page( 'users.php' );
//        //Plugins
//        remove_menu_page( 'plugins.php' );
//        //Settings
//        remove_menu_page( 'options-general.php' );
//        //Custom Fields
//        remove_menu_page( 'edit.php?post_type=acf-field-group' );
//        //dashboard
//        remove_menu_page( 'index.php' );
//        //wordfence
//        remove_menu_page( 'Wordfence' );
//    }
//
//    add_action( 'admin_menu', 'remove_menus' );
//}
// Our custom post type function
function create_posttype() {
	register_post_type('TripDates',
		// CPT Options
		array(
			'labels' => array(
				'name' => __('Trip Dates'),
				'singular_name' => __('Trip Date'),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'TripDates'),
			'supports' => array('title', 'custom_field'),
		)
	);
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');

//Dynamically populate custom post title in dropdown
function acf_load_color_field_choices($field) {
	// Get the 'Profiles' post type
	$args = array(
		'post_type' => 'trip',
		'posts_per_page' => 500,
		'orderby' => 'title',
		'order' => 'asc',
	);
	$trip_posts = array();
	$loop = new WP_Query($args);

	while ($loop->have_posts()): $loop->the_post();
		//the_title();

		$trip_posts[] = get_the_title();

	endwhile;
	wp_reset_query();

	// reset choices
	//$field['choices'] = $trip_posts;

	$choices = $trip_posts;

	// loop through array and add to field 'choices'
	if (is_array($choices)) {
		foreach ($choices as $choice) {
			$field['choices'][$choice] = $choice;
		}
	}
	// return the field
	return $field;
}
add_filter('acf/load_field/name=trip_title', 'acf_load_color_field_choices');

//ajax call for repeater field to remove old dates
add_action("wp_ajax_update_repeater_field_tripdates", "update_repeater_field_tripdates");
add_action("wp_ajax_nopriv_update_repeater_field_tripdates", "update_repeater_field_tripdates");

function update_repeater_field_tripdates() {
	$p_id = $_POST['postId'];

	if (have_rows('new_small_group_journey', $p_id)) {
		$new_repeater = array();
		while (have_rows('new_small_group_journey', $p_id)) {
			the_row();
			//$some_value = "09/20/2017 - 09/20/2017";
			//spliting into single date
			$rep_date = get_sub_field('new_start_dateend_date');
			$repe_date = explode(" - ", $rep_date);
			$repea_date = $repe_date['0'];
			$repeat_date = new DateTime($repea_date);
			//yesterday date for preventing delete for today's trip dates.
			$yesterday_date = date('Y/m/d', strtotime("-30 days"));
			$now = new DateTime($yesterday_date);
			// var_dump($repea_date);
			//var_dump($yesterday_date);
			//remove old dates logic
			//die;
			if ($repeat_date > $now) {
				//echo 'date is in the past';
				$new_repeater[] = array(
					'new_start_dateend_date' => get_sub_field('new_start_dateend_date'),
					'new_price' => get_sub_field('new_price'),
					'new_journey_discount' => get_sub_field('new_journey_discount'),
				);
			} else {
				//echo "present";
			}

		}
		update_field('new_small_group_journey', $new_repeater, $p_id);
	}
	if (have_rows('small_group_journey', $p_id)) {
		$new_repeater = array();
		while (have_rows('small_group_journey', $p_id)) {
			the_row();
			//spliting into single date
			$rep_date = get_sub_field('start_date/end_date');
			$repe_date = explode(" - ", $rep_date);
			$repea_date = $repe_date['0'];
			$repeat_date = new DateTime($repea_date);
			//yesterday date for preventing delete for today's trip dates.
			$yesterday_date = date('Y/m/d', strtotime("-30 days"));
			$now = new DateTime($yesterday_date);

			//    var_dump($repeat_date);
			//    var_dump($now);
			// echo '<br/>';
			//remove old dates logic
			//die;
			if ($repeat_date > $now) {
				// echo 'present';
				$new_repeater[] = array(
					'start_date/end_date' => get_sub_field('start_date/end_date'),
					'journey_price' => get_sub_field('journey_price'),
					'journey_discount' => get_sub_field('journey_discount'),
					'journey_status' => get_sub_field('journey_status'),
				);
			} else {
				//echo "present";
			}
			//    echo '<pre>';
			//    var_dump($repeat_date);
			//    var_dump($new_repeater);
			//    echo '</pre>';
		}
		update_field('small_group_journey', $new_repeater, $p_id);
		//echo "ajax works..";
		//return "done";
	}
	die();
}
// add_action('init','delete_afc_repeater_rows' );

function remove_old_dates($post_ID) {

	?>
       <script>
           jQuery(document).ready(function($){
               jQuery('.bulk-dates').append('<div class="remove-old-date">Remove old Dates</div>');

               $(document).on ('click','.remove-old-date',function(event) {

                   $(this).html('<span><img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin:0px 10px; width:20px;">Removing old dates...</span>');
                      var loc = location.search;
                      var post_id=loc.substring(loc.lastIndexOf("?")+1,loc.lastIndexOf("&"));
                      var postId = post_id.substring(5);
                       $.ajax({ url: ajaxurl,
                               method: "POST",
                                data: {action: 'update_repeater_field_tripdates',
                                           postId: postId ,

                                        success: function(data) {
                                             console.log(data);
                                             function remove_loading(){
                                               $('.remove-old-date').html('Trip dates Updating.Please Wait..');
                                             }
                                             function reload_page(){
                                                window.location.reload(true);
                                             }
                                             setTimeout(function(){ remove_loading(); }, 9000);
                                             setTimeout(function(){ reload_page(); }, 10000);
                                         }
                                       }

                    });
                       //check every row and find old dates
                        //function delete_old_dates(){
                       //     console.log('start');
                       //  //debugger;
                       //  var c_row = jQuery('.acf-row');

                       //  for(i=0;i<c_row.length;i++){
                       //     var dates_s=jQuery('.acf-row .static-date input').eq(i).val();
                       //     console.log(dates_s);
                       //     //var dates_s=jQuery('.acf-row .static-date input').first().val();
                       //         var dates=dates_s.split(" - ");
                       //         var now = new Date();
                       //         now.setHours(0,0,0,0);
                       //         var c_date = new Date(dates['0']);
                       //         if (c_date < now) {
                       //             //console.log('old');
                       //             var remove_row= jQuery('[data-id='+i+']');
                       //             remove_row.remove();
                       //         }
                       //     }
                       // //}
                       // //delete_old_dates();
                       // //console.log('output');
                       // function remove_loading(){
                       //     $('.remove-old-date').delay( 5000 ).html('Trip dates Updated.Reload to see changes');
                       // }
                       //     setTimeout(function(){ remove_loading(); }, 5000);
               });

               //remove one by one tripdate row
               jQuery('.acf-row .acf-field-true-false  input').click(function(){
                   var remove_row = jQuery(this).parent().parent().parent().parent().parent();
                   remove_row.css('display','block');
                   remove_row.css('opacity','0');
                   remove_row.remove();
               });
           });

       </script>
       <style>
       .remove-old-date {
            position: relative;
            float: right;
            background: #ea6060;
            padding: 10px;
            cursor: pointer;
            color: #fff;
            font-size: 14px;
            border-radius: 5px;
            margin: 10px;
            top: -20px;
            z-index: 999;
        }
        #idAll .acf-true-false label{
            position:relative;
        }
        #idAll .acf-true-false label::before {
            content: "Delete";
            position: absolute;
            top: 0px;
            left: 0;
            background: #ea3131;
            width: 40px;
            color: #fff;
            padding: 5px;
            border-radius: 3px;
            cursor:Pointer;
        }
   </style>
   <?php
}
add_action('admin_footer', 'remove_old_dates');
// add_filter( 'mce_buttons_3', 'remove_bootstrap_buttons', 999 );
// function remove_bootstrap_buttons($buttons) {
//     return array();
// }

add_filter('mce_buttons_3', '__return_false', 999);
add_filter('mce_buttons', 'remove_toggle_button', 999);

function remove_toggle_button($buttons) {
	$remove = array('css_components_toolbar_toggle');
	return array_diff($buttons, $remove);
}
//after submit booking form.
add_action('gform_after_submission_13', 'after_submission_13', 10, 2);
function after_submission_13($entry, $form) {
	//var_dump($entry);die();
	//$url = site_url().'/payment/?bookingID=';http://www.acethehimalaya.com/payment-process/?bookingID=988
	if($entry['56'] == "Bank Transfer"){
		$url = site_url() . '/payment/?bookingID=' . $entry["id"];
	}
	if($entry['56'] == "Pay By Card"){
		$url = site_url() . '/payment-process/?bookingID=' . $entry["id"];
	}
	wp_redirect($url);
	exit;
}
add_action('gform_after_submission_2', 'after_submission_2', 10, 2);
function after_submission_2($entry, $form) {
	//var_dump($entry["id"]);
	//$url = site_url().'/payment/?bookingID=';
	if($entry['52'] == "Bank Transfer"){
		$url = site_url() . '/payment/?bookingID=' . $entry["id"];
	}
	if($entry['52'] == "Pay By Card"){
		$url = site_url() . '/payment-process/?bookingID=' . $entry["id"];
	}
	wp_redirect($url);
	exit;
}
/**
 *Creat metabox for  saving payment details in gravity form entry.
 *
 */
add_filter('gform_entry_detail_meta_boxes', 'register_meta_box', 10, 3);

function register_meta_box($meta_boxes, $entry, $form) {
	if (!isset($meta_boxes['Payment'])) {
		$meta_boxes['Payment'] = array(
			'title' => esc_html__('Payment Details', 'gravityforms'),
			'callback' => 'add_details_meta_box',
			'context' => 'side',
			'callback_args' => array($entry, $form),
		);
	}

	return $meta_boxes;
}

function add_details_meta_box($args) {
	$form = $args['form'];
	$entry = $args['entry'];
	$bookingId = $entry['id'];
	$option_name = 'hbl_payment_result_' . $bookingId;
	$payment_details = get_option($option_name, $default = false);

	//00000001234567890301
	if ($payment_details) {
		$html = '<strong>Paid Amount : $</strong>' . $payment_details['0'] . '<br/>';
		$html .= '<strong>Invoice ID : </strong>' . $payment_details['1'] . '<br/>';
		$html .= '<strong>DateTime : </strong>' . date("d-m-Y", strtotime($payment_details['2'])) . '<br/>';
		$html .= '<strong>PaymentGatewayID : </strong>' . $payment_details['3'] . '<br/>';
		$html .= '<strong>ApprovalCode : </strong>' . $payment_details['4'] . '<br/>';
		$html .= '<strong>RespCode : </strong>' . $payment_details['5'] . '<br/>';
		$html .= '<strong>FraudCode : </strong>' . $payment_details['6'] . '<br/>';
		$html .= '<strong>Pan : </strong>' . $payment_details['7'] . '<br/>';
		$html .= '<strong>TranRef : </strong>' . $payment_details['8'] . '<br/>';

		//$html   .= '<strong>Note : </strong>'.$payment_details['9'].'<br/>';
	} else {
		$html = "Payment detail not available.";
	}
	echo $html;
}

function filter_plugin_updates($value) {
	unset($value->response['ajax-load-more/ajax-load-more.php']);
	unset($value->response['display-widgets/display-widgets.php']);
	unset($value->response['pdf-print/pdf-print.php']);
	return $value;
}
add_filter('site_transient_update_plugins', 'filter_plugin_updates');

/**
 * ajax mail for direct bank transfer has been removed.
 */


require get_stylesheet_directory() . '/lib/inc/home-page-customizer.php';
require get_stylesheet_directory() . '/lib/inc/home-page-section.php';

function acethehimalayachild_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Right Trip Advisor Widgets', 'acethehimalaya' ),
        'id'            => 'right-trip-advisor-widgets',
        'description'   => esc_html__( 'Add 6 widgets here.', 'acethehimalaya' ),
        'before_widget' => '<li>',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
     register_sidebar( array(
        'name'          => esc_html__( 'Left Trip Advisor Widget', 'acethehimalaya' ),
        'id'            => 'left-trip-advisor-widget',
        'description'   =>  esc_html__( 'Add one widget here.', 'acethehimalaya' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );     
}
add_action( 'widgets_init', 'acethehimalayachild_widgets_init' );

function acethehimalaya_customizer_js() {
    wp_enqueue_script( 'acethehimalaya-customizer-js', get_stylesheet_directory_uri() . '/lib/js/customizerwidget.js', array('jquery'), '20160523', true  );
}
add_action( 'customize_controls_enqueue_scripts', 'acethehimalaya_customizer_js' );



// Remove WP Version From Styles	
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}


/**
* url for new independent paymennt form 
*
**/
add_action('gform_after_submission_16', 'after_submission_16', 10, 2);
function after_submission_16($entry, $form) {
	//var_dump($entry["id"]);
	//$url = site_url().'/payment/?bookingID=';
	
	if($entry){
		$url = site_url() . '/direct-payment-process/?bookingID=' . $entry["id"];
	}
	wp_redirect($url);
	exit;
}


/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function cpt_representative_init() {
	$labels = array(
		'name'               => _x( 'Representatives', 'post type general name', 'acethehimalaya' ),
		'singular_name'      => _x( 'Representative', 'post type singular name', 'acethehimalaya' ),
		'menu_name'          => _x( 'Representatives', 'admin menu', 'acethehimalaya' ),
		'name_admin_bar'     => _x( 'representative', 'add new on admin bar', 'acethehimalaya' ),
		'add_new'            => _x( 'Add New', 'representative', 'acethehimalaya' ),
		'add_new_item'       => __( 'Add New representative', 'acethehimalaya' ),
		'new_item'           => __( 'New representative', 'acethehimalaya' ),
		'edit_item'          => __( 'Edit representative', 'acethehimalaya' ),
		'view_item'          => __( 'View representative', 'acethehimalaya' ),
		'all_items'          => __( 'All representatives', 'acethehimalaya' ),
		'search_items'       => __( 'Search representatives', 'acethehimalaya' ),
		'parent_item_colon'  => __( 'Parent representatives:', 'acethehimalaya' ),
		'not_found'          => __( 'No representatives found.', 'acethehimalaya' ),
		'not_found_in_trash' => __( 'No representatives found in Trash.', 'acethehimalaya' )
	);

	$args = array(
		'labels'             => $labels,
         'description'        => __( 'Description.', 'acethehimalaya' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'representative' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'representative', $args );
}
add_action( 'init', 'cpt_representative_init' );


/* *
 * Add custom field in ACF checkbox : acf/load_field
 *  
 * */

 function acf_load_representative_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();

    // check the post type 
    // $args = array(
    // 			'post_type'=>'representative',
    // 			);
	   //  $query = new WP_Query($args);
	   //  if($query->have_posts()){
	   //  	$value_array = array();
	   //  	while($query->have_posts()){
	   //  		$query->the_post();
	   //  		$value = get_the_ID();
	   //          $label = get_the_title();
	   //          $value_array[] = get_the_ID();
	   //          // append to choices
	   //          $field['choices'][ $value ] = $label;
	   //  	}
	   //  	 wp_reset_postdata();
	   //  }
	            //$field['default_value'] = $value_array;

		$args = array( 'post_type'=>'representative');

		$myposts = get_posts( $args );
		foreach ( $myposts as $post ) : setup_postdata( $post ); 
						$value = $post->ID;
						//var_dump($post);
			            $label = $post->post_title;
			            $value_array[] = $post->ID;
			            // append to choices
			            $field['choices'][ $value ] = $label;
			endforeach; 
		wp_reset_postdata();
		$field['default_value'] = $value_array;

           		

    // return the field
    return $field;
    
}

//use the field ID for specific checkbox only
add_filter('acf/load_field/key=field_5ab9cc840b7f5', 'acf_load_representative_field_choices');












