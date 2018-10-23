<?php
/**
 * Template Name: Payment Form
 */
get_header();
?>
<?php
//query url for booking id
session_start();
if (!isset($_SESSION['post_id']) || !isset($_SESSION['slug-name'])):
	$_SESSION['post_id'] = $pid;
	$_SESSION['slug-name'] = $trip_title;
	/*$_SESSION['start_date'] = $start_date;
        $_SESSION['end_date'] = $end_date;*/
endif;
$url = $_SERVER['QUERY_STRING'];
$url_arr = explode('bookingID=', $url);
$bookingId = $url_arr[1];

if ($bookingId) {
	$bookingData = GFAPI::get_entry($bookingId);
	if ($bookingData['form_id'] == 13) {
		 //var_dump($bookingData);
		// die;
		$bookingData_user_name = $bookingData['20'];
		$bookingData_trip_name = $bookingData['35'];
		$bookingData_trip_date_imp = $bookingData['46'];
		$bookingData_trip_date_extra = $bookingData['38'];
		$bookingData_trip_email = $bookingData['12'];
		$bookingData_trip_country = $bookingData['33'];
		$bookingData_trip_pax = $bookingData['42'];
		$bookingData_trip_paymethod = $bookingData['43'];
		$bookingData_trip_calprice = $bookingData['45'];
		$bookingData_trip_perprice = $bookingData['50'];
		$bookingData_trip_remainingprice = $bookingData['53'];

		
	}
	if ($bookingData['form_id'] == 2) {
		$bookingData_user_name = $bookingData['20'];
		$bookingData_trip_name = $bookingData['35'];
		$bookingData_trip_date_imp = $bookingData['37'];
		$bookingData_trip_email = $bookingData['12'];
		$bookingData_trip_country = $bookingData['33'];
		$bookingData_trip_pax = $bookingData['42'];
		$bookingData_trip_paymethod = $bookingData['44'];
		$bookingData_trip_calprice = $bookingData['43'];
		$bookingData_trip_perprice = $bookingData['45'];
		$bookingData_trip_remainingprice = $bookingData['48'];

	}
	//var_dump($bookingData_trip_remainingprice);
	//var_dump($bookingData_trip_paymethod);
	$args = array('post_type' => 'trip',
		'posts_per_page' => 1,
		//'post_name__in'  => [$trip_slug]
		'p' => $bookingData_ID,
	);

	$the_query = new WP_Query($args);?>
    <?php if ($the_query->have_posts()): ?>
        <?php while ($the_query->have_posts()): $the_query->the_post();?>
								        <h2><?php
	$cost = get_field("trip_cost");
		$dcost = $cost - (get_field('discount_percentage') / 100) * $cost;
		$dis_per = get_field('discount_percentage');
		//var_dump($cost);
		//var_dump($dcost);
		?></h2>
								        <?php endwhile;?>
        <?php wp_reset_postdata();
	endif;

}

if (has_post_thumbnail()) {
	$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-mobile');
	$image_medium = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-tab');
	$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image');
	?>
    <figure
        class="hero-image style1">

        <picture>
            <!--[if IE 9]>
            <video style="display: none;"><![endif]-->
            <source srcset="<?php echo $image[0]; ?>" media="(min-width: 1200px)">
            <source srcset="<?php echo $image_medium[0]; ?>"
                    media="(min-width: 768px)">
            <source srcset="<?php echo $image_thumb[0]; ?>"
                    media="(min-width: 320px)">
            <!--[if IE 9]></video><![endif]-->
            <img srcset="<?php echo $image[0]; ?>"
                 alt="<?php the_title();?>">
        </picture>
    </figure>

<?php }?>
			<div class="container">
				<div class="row  contact-us">

						<div class="col-lg-12">
							<?php
							if (have_posts()) {
								while (have_posts()) {
									the_post();
									?>
									<div class="header-block">
										<h1 class="page-heading">Wire Transfer Success<?php //the_title(); ?></h1>
										<?php 

										$wire_tranfer = get_field('wire_transfer_success_notification', 'option');
										if($wire_tranfer){
											echo $wire_tranfer;
										}else{
											the_content();
										}
										?>

									</div>
									<?php
										} // end while
								} // end if
						?>
						</div>
		</div>
	</div>


        
    <?php 

    ?>
<?php
get_footer();