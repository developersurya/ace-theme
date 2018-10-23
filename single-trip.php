<?php
    session_start();
    session_destroy();
    $_SESSION['slug-name'] ="";
    $_SESSION['trip_slug'] ="";

    get_header();
    $pid = get_the_ID();
    $current_date = date('Ymd'); //current date or any date
?>
    <div class="hero">

        <?php if(get_field('youtube_video_id')){ ?>
            <div class="video-container">
                <div class="video-poster" style="background: url(https://img.youtube.com/vi/<?php echo get_field('youtube_video_id'); ?>/maxresdefault.jpg) no-repeat center center; background-size: cover;"></div>
                <div id="module-video" class="module-video"></div>
                <div class="video-content">
                    <?php if(get_field('video_section_title')){ ?><h2><?php echo get_field('video_section_title'); ?></h2><?php } ?>
                    <?php if(get_field('youtube_video_description')){ ?><p><?php echo get_field('youtube_video_description'); ?></p><?php } ?>
                    <a href="https://www.youtube.com/embed/<?php echo get_field('youtube_video_id'); ?>?autoplay=1" class="fancybox-video">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="play-button"><g fill="#FFFFFF"><path d="M10 0C4.5 0 0 4.5 0 10 0 15.5 4.5 20 10 20 15.5 20 20 15.5 20 10 20 4.5 15.5 0 10 0L10 0ZM8 14.5L8 5.5 14 10 8 14.5 8 14.5Z"/></g></svg>
                    </a>
                </div>
            </div>
            <script>
                jQuery('#module-video').YTPlayer({
                    fitToBackground: false,
                    videoId: '<?php echo get_field('youtube_video_id'); ?>',
                    pauseOnScroll: false,
                    playerVars: {
                        modestbranding: 0,
                        autoplay: 1,
                        showinfo: 0,
                        branding: 0,
                        autohide: 0
                    }
                });
            </script>
        <?php }else{
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
                         alt="<?php the_title(); ?>">
                </picture>
            </figure>
            <?php
        } else { ?>
                <figure class="hero-image">
                    <img class="img-responsive"
                         src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-placeholder.png"
                         alt="slide placeholder">
                </figure>
            <?php }
        } ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <h1><?php the_title(); ?></h1>

                    <div class="hero--short-desc">
                        <?php
                           // global $post;

                            //$excerpt = apply_filters('the_content', $post->post_content);
                            if (has_excerpt()) {
                                echo get_the_excerpt() ;
                            } else {
                                echo wp_trim_words( get_the_excerpt(), 35, $more = '' ) ;
                            }

                        ?>
                    </div>


                </div><!-- .col-lg-8 -->
                <div class="col-lg-4">

                </div><!-- .col-lg-4 -->

            </div>
        </div><!--container-->
    </div><!--hero-->
    <div id="trip-container" class="trip-tab">
          <div class="trip-tab--heading">
                <div class="container">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-lg-push-10 col-md-push-10">
                        <div class="row">
                            <div class="relative-holder initial-hide">

                                 <!--Show price div only if it contain price-->
                                <?php  $cost = get_field("trip_cost");
                                if(!empty($cost)){?>
                                    <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                        <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                        <input type="hidden" name="trip_slug_name" value="<?php echo $post->post_name; ?>">
                                        <input type="hidden" name="post_id" value="<?php echo $pid; ?>">
                                        <?php if( have_rows('group_discount') ): ?>
                                        <input type="hidden" name="group_trip" value="group_trip">
                                        <?php endif; ?>
                                        <input type="submit" class="btn btn-success" value="BOOK NOW"/>
                                    </form>
                                    <?php }else{?>
                                        <div class="button-widget extra-button-widget">
                                            <a href="#enquiry-popup-form" class="fancybox enq-without-date btn btn-blue" data-title="<?php the_title(); ?>"><strong>INQUIRE NOW</strong></a>
                                       </div>
                                    <?php } ?>


                                <?php
                                $phone = get_field('main_phone_number', 'option');
                                $phone_number = preg_replace('/\D/', '', $phone); ?>
                                <a class="quick-contact-main" href="tel:<?php echo $phone_number; ?>"><span
                                        class="icon-phone"></span></a>
                            </div><!-- .relative-holder -->
                        </div><!-- .row -->
                    </div>
                    <ul class="nav nav-tabs col-lg-9 col-md-10 col-sm-12 col-lg-pull-2 col-md-pull-2 hidden-print" id="ajax-tab">
                        <li class="active">
                            <a href="#tab-overview" class="tab-overview" title="At a glance">
                                <div class="icon-overview"></div>
                                <span class="tab-title">Overview</span></a>
                        </li>
                        <?php if (have_rows('detail_itinerary',$pid)) { ?>
                            <li class="">
                                <a href="#tab-itinerary" class="tab-itinerary" title="The day-by-day plan">
                                    <div class="icon-itinerary"></div>
                                    <span class="tab-title">Itinerary</span></a>
                            </li>
                        <?php }
                        if (    have_rows('small_group_journey',$pid) ||
                            have_rows('group_size_info',$pid) ||
                            get_field('date_description', $pid) ||
                            get_field('small_group', $pid) ||
                            get_field('private_journey', $pid) ||
                            get_field('tailor_made_journey', $pid)

                        )  { ?>
                            <li class="">
                                <a href="#tab-dates" class="tab-dates" title="Price and trip availability dates">
                                    <div class="icon-dates"></div>
                                    <span class="tab-title">Departure</span></a>
                            </li>
                        <?php }
                        if ( have_rows('cost_includes', $pid) || have_rows('not_include',$pid) ) {
                            ?>
                            <li class="">
                                <a href="#tab-included" class="tab-included" title="What the price covers">
                                    <div class="icon-included"></div>
                                    <span class="tab-title">Included</span></a>
                            </li>
                            <?php
                        }
                        if (get_field('equipment_main_description', $pid) ||
                            have_rows('equipments', $pid) ||
                            get_field('equipment_extra_description', $pid)
                        ) {
                            ?>
                            <li class="">
                                <a href="#tab-equipment" class="tab-equipment" title="What to bring with you">
                                    <div class="icon-equipment"></div>
                                    <span class="tab-title">Equipment</span></a>
                            </li>
                            <?php
                        }
                        if(get_field("trip_gallery", $pid) || have_rows('videos_upload', $pid)) {
                            ?>
                            <li class="">
                                <a href="#tab-gallery" class="tab-gallery" title="Visual records of the trip">
                                    <div class="icon-gallery"></div>
                                    <span class="tab-title">Gallery</span></a>
                            </li>
                            <?php
                        }
                        if (have_rows('faqs_list', $pid)): ?>
                            <li class="">
                                <a href="#tab-faq" class="tab-faq" title="Get your queries answered">
                                    <div class="icon-faqs"></div>
                                    <span class="tab-title">FAQs</span></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div><!-- .trip-tab--heading -->
<!--            <div class="hidden-space"></div>-->
          <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="tab-content clearfix">
                        <div id="tab-overview" class="tab-pane fade in active">
                            <?php
                            include(get_template_directory() . '/template-parts/tab-trip-detail/tab-overview.php');
                            ?>
                        </div>
                        <?php if (have_rows('detail_itinerary',$pid)) { ?>
                            <div id="tab-itinerary" class="tab-pane fade itinerary">
                                <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-itinerary.php'); ?>
                            </div>
                        <?php }
                        if (    have_rows('small_group_journey',$pid) ||
                            have_rows('group_size_info',$pid) ||
                            get_field('date_description', $pid) ||
                            get_field('small_group', $pid) ||
                            get_field('private_journey', $pid) ||
                            get_field('tailor_made_journey', $pid)

                        )  {

                            ?>
                            <div id="tab-dates" class="tab-pane fade">
                                <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-dates.php'); ?>
                            </div>
                        <?php } ?>
                        <div id="tab-included" class="tab-pane fade ">
                            <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-included.php'); ?>
                        </div>
                        <?php
                        if (get_field('equipment_main_description', $pid) || have_rows('equipments', $pid) || get_field('equipment_extra_description', $pid)) {
                            ?>
                            <div id="tab-equipment" class="tab-pane fade">
                                <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-equipment.php'); ?>
                            </div>
                            <?php
                        }
                        if(get_field("trip_gallery", $pid) || have_rows('videos_upload', $pid)) {
                            ?>
                            <div id="tab-gallery" class="tab-pane fade">
                                <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-gallery.php'); ?>
                            </div>
                            <?php
                        }
                        if (have_rows('faqs_list', $pid)) {
                            ?>
                            <div id="tab-faq" class="tab-pane fade">
                                <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-faq.php'); ?>
                            </div>
                            <?php
                        }
                        ?>

                    </div><!-- .tab-content -->
                </div><!-- .col-lg-8 -->
                <div class="col-lg-4">
                    <div class="trip-sidebar">
                    <!--<div class="sticky-widget">-->
                    <!--Show price div only if it contain price-->
                        <?php  $cost = get_field("trip_cost");
                        if(!empty($cost)){?>
                            <div class="hero--trip-meta<?php if(get_field('discount_percentage') == ''){ echo " no-discount-per"; } ?>">
                                <?php $end_date = get_field('offer_ends', $pid); //Future date
                                $dis_per = get_field('discount_percentage');
                                if($dis_per){ ?>
                                    <span class="offer_time"><strong><?php echo get_field('discount_percentage'); ?>% Off</strong>
                                        <?php if(date("Ymd", strtotime($current_date)) <= date("Ymd", strtotime($end_date))){  ?><span>Ends in: <?php echo daysDiff($current_date, $end_date); ?></span><?php } ?>
                                </span>
                                <?php }
                                if(get_field("trip_cost")){ ?> <div class="hero--trip-days">Go on <?php if(get_field('total_days', $post_id) == 1) { echo 'a day'; } else { echo get_field('total_days', $post_id) . ' day'; } ?> trip for</div><?php  } ?>

                                <?php
                               
                                $dis_per = get_field('discount_percentage');
                                ?>
                                <?php if ($dis_per) {
                                    $des_cost = $cost - ($dis_per / 100) * $cost;
                                    ?>
                                    <div class="clearfix">
                                        <span class="hero--cost">USD <?php echo number_format($cost); ?></span>
                                        <span class="hero-dis-cost">USD <?php echo number_format($des_cost); ?> <sup>per person</sup></span>
                                    </div>
                                <?php } else { if ($cost) : ?>
                                    <span class="hero--cost hero--no-dis">USD <?php echo number_format($cost); ?> <sup>per person</sup></span>
                                <?php endif; }
                                $saved_cost = $cost - $des_cost; ?>
                                <span class="save-cost">You Save <i class="saved-amount">USD <?php echo $saved_cost; ?></i> </span>

                                <?php if( have_rows('group_discount') ): ?>
                                    <span class="group-discount">See Group Discount</span>
                                    <div class="discount-list">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>No. of people</th>
                                                <th>Price per person</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        <?php while( have_rows('group_discount') ): the_row();
                                            $group_range = get_sub_field('group_range');
                                            $group_price = get_sub_field('group_price'); ?>
                                            <tr>
                                                <td><?php echo $group_range; ?></td>
                                                <td><?php echo 'USD '.$group_price; ?></td>
                                            </tr>
                                        <?php endwhile; ?>

                                          </tbody>
                                        </table>
                                    </div>
                                <?php endif;
                                if (    have_rows('small_group_journey',$pid) ||
                                have_rows('group_size_info',$pid) ||
                                get_field('date_description', $pid) ||
                                get_field('small_group', $pid) ||
                                get_field('private_journey', $pid) ||
                                get_field('tailor_made_journey', $pid)

                                )  {

                                ?>
                                <a href="#" class="btn btn-large check-availability">Check Availability</a>
                                <?php } ?>
                            </div><!-- .hero-trip-meta -->
                        <?php } ?>

                        <!--</div> .sticky-widget -->

                        <div class="sidebar-item button-widget clearfix">
                            <?php   $post_id = get_the_ID();?>
                        <!--Show price div only if it contain price-->
                            <?php  $cost = get_field("trip_cost");
                            if(!empty($cost)){?>
                                <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                    <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                    <input type="hidden" name="trip_slug_name" value="<?php echo $post->post_name; ?>">
                                    <?php if( have_rows('group_discount') ): ?>
                                    <input type="hidden" name="group_trip" value="group_trip">
                                    <?php endif; ?>
                                    <input type="submit" class="btn btn-success" value="BOOK NOW"/>
                                </form>
                            <?php } ?>
                             <a href="#enquiry-popup-form" class="fancybox enq-without-date btn btn-blue <?php if(empty($cost)){echo "no-price-avl";}?>" data-title="<?php the_title(); ?>"><strong>INQUIRE NOW</strong></a>
                                   <div id="enquiry-popup-form" style="display:none; max-width:900px;">
                                    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
                                    </div>
                        </div>
                        <?php if( have_rows('checklist', 'option') ): ?>
                            <ul class="info-list text-center clearfix">
                                <?php while( have_rows('checklist', 'option') ): the_row();
                                    $item = get_sub_field('checklist_item');                    ?>
                                    <li>
                                        <?php echo $item; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>

                        <?php endif; ?>
                            <?php
                                $post_id = $_POST['post_id'];
                                $post_data = get_post($post->post_parent);
                                ?>
                                <?php
                                    //for specific post rating calculation
                                    $arg=array(
                                        'post_type' => 'testimonial',
                                        'posts_per_page' => -1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'testimonial-category',
                                                'field' => 'slug',
                                                'terms' => $post_data->post_name,
                                            ),
                                        ),
                                    );
                                    $query = new WP_Query($arg);
                                    $rating_arr = array();
                                    if($query->have_posts()):while($query->have_posts()):$query->the_post();
                                        $ratings = get_field('rating_overall');
                                        switch ($ratings) {
                                            case "Five":
                                                $rating_number = 5;
                                                break;
                                            case "Four":
                                                $rating_number = 4;
                                                break;
                                            case "Three":
                                                $rating_number = 3;
                                                break;
                                            case "Two":
                                                $rating_number = 2;
                                                break;
                                            case "One":
                                                $rating_number = 1;
                                                break;
                                            default:
                                                $rating_number = 0;
                                        }
                                        $rating_arr[] = $rating_number;
                                    endwhile;
                                        wp_reset_postdata();
                                    endif;
                                    $num_rating = count($rating_arr);
                                    if(count($rating_arr) !=0){
                                        $av_rating =  round((array_sum($rating_arr))/(count($rating_arr)));
                                        //echo "<br/>Total review:".$num_rating ;
                                       // echo "<br/>Total average review:".$av_rating;
                                        if($av_rating == 5){
                                            $av_rating_text = 'Five';
                                            $av_rating_msg = 'Excellent';
                                        }
                                        if($av_rating == 4){
                                            $av_rating_text = 'Four';
                                            $av_rating_msg = 'Good';
                                        }
                                        if($av_rating == 3){
                                            $av_rating_text = 'Three';
                                            $av_rating_msg = 'Average';
                                        }
                                        if($av_rating == 2){
                                            $av_rating_text = 'Two';
                                            $av_rating_msg = 'Poor';
                                        }
                                        if($av_rating == 1){
                                            $av_rating_text = 'One';
                                            $av_rating_msg = 'Very Poor';
                                        }
                                        echo '<div class="overall-rating">
                                                <span class="rating-msg large">'.$av_rating.' - '.$av_rating_msg.'</span>
                                                <div class="rating-list large">
                                                    <ul class="'.$av_rating_text.'">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                    </ul>
                                                </div>
                                            <span class="review-count"> - Based on <a href="#" class="link-to-review">'.$num_rating.' reviews</a></span>

                                            </div>';
                                    }else{

                                        //for general rating calculations
                                        $arg=array(
                                            'post_type' => 'testimonial',
                                            'posts_per_page' => -1,
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'testimonial-category',
                                                    'field' => 'slug',
                                                    'terms' => 'general',
                                                ),
                                            ),
                                        );
                                        $query = new WP_Query($arg);
                                        $rating_arr = array();
                                        if($query->have_posts()):while($query->have_posts()):$query->the_post();
                                            $ratings = get_field('rating_overall');
                                            switch ($ratings) {
                                                case "Five":
                                                    $rating_number = 5;
                                                    break;
                                                case "Four":
                                                    $rating_number = 4;
                                                    break;
                                                case "Three":
                                                    $rating_number = 3;
                                                    break;
                                                case "Two":
                                                    $rating_number = 2;
                                                    break;
                                                case "One":
                                                    $rating_number = 1;
                                                    break;
                                                default:
                                                    $rating_number = 0;
                                            }
                                            $rating_arr[] = $rating_number;
                                        endwhile;
                                            wp_reset_postdata();
                                        endif;
                                        $num_rating = count($rating_arr);
                                        $av_rating =  round((array_sum($rating_arr))/(count($rating_arr)));
                                        //echo "<br/>Total review:".$num_rating ;
                                        //echo "<br/>Total average review:".$av_rating;
                                        if($av_rating == 5){
                                            $av_rating_text = 'Five';
                                            $av_rating_msg = 'Excellent';
                                        }
                                        if($av_rating == 4){
                                            $av_rating_text = 'Four';
                                            $av_rating_msg = 'Good';
                                        }
                                        if($av_rating == 3){
                                            $av_rating_text = 'Three';
                                            $av_rating_msg = 'Average';
                                        }
                                        if($av_rating == 2){
                                            $av_rating_text = 'Two';
                                            $av_rating_msg = 'Poor';
                                        }
                                        if($av_rating == 1){
                                            $av_rating_text = 'One';
                                            $av_rating_msg = 'Very Poor';
                                        }
                                        echo '<div class="overall-rating">
                                                <span class="rating-msg large">'.$av_rating.' - '.$av_rating_msg.'</span>
                                                <div class="rating-list large">
                                                    <ul class="'.$av_rating_text.'">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                    </ul>
                                                </div>
                                            <span class="review-count"> - Based on <a href="#" class="link-to-review">'.$num_rating.' reviews</a></span>

                                            </div> ';

                                    }

                        ?>
                        <div id="TA_selfserveprop283" class="TA_selfserveprop"><ul id="uQvHml9AyoaK" class="TA_links nKQJUmYwRH6"><li id="ONWJoTyW" class="Ehfz0mJVtv3k"><a target="_blank" href="https://www.tripadvisor.com/"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png"alt="TripAdvisor"/></a></li></ul></div><script src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=283&amp;locationId=1957215&amp;lang=en_US&amp;rating=true&amp;nreviews=5&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=false&amp;border=true&amp;display_version=2"></script>
                        <div class="sidebar-item trip__social-block">
                            <h5 class="sidebar-item-title">
                                <strong>Share:</strong>
                                <span class='st_facebook' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
                                <span st_via='@acethehimalaya' st_username='acethehimalaya' class='st_twitter' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
<!--                                <span st_title='--><?php //the_title(); ?><!--' st_url='--><?php //the_permalink(); ?><!--' class='st_googleplus_hcount'></span>-->
                            </h5>
                            <a class="btn btn-dossier" target="_blank" href="<?php the_permalink(); ?>?print=print&id=<?php echo $post->ID; ?>"><i class="file"></i>View Dossier Online</a>

                        </div>
                        <?php
                        $image = get_field("trip_map");
                        if ($image):
                            ?>
                            <div class="trip-map">
                                <h5 class="trip-map-title">Trip Map</h5>

                                <div class="sidebar-item">
                                    <a href="<?php echo $image['url']; ?>" class="fancybox  zoom-map center-icon"><i
                                            class="icon-zoom-in"></i></a>
                                    <a href="<?php echo $image['url']; ?>" class="download-icon center-icon"
                                       download="<?php the_title(); ?> Map"><i class="icon-arrow-down2"></i></a>
                                    <img class="img-responsive" src="<?php echo $image['url']; ?>"
                                         alt="<?php echo $image['alt']; ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php wp_reset_query(); 
                        $trip_id = get_the_ID();
                        if( have_rows('sidebar_before_booking_a_trip', $trip_id) ){ ?>
                            <div class="sidebar-item before-booking-item">
                                <h5 class="sidebar-item-title">Before Booking a Trip</h5>
                                <ul>

                                    <?php  while ( have_rows('sidebar_before_booking_a_trip', $trip_id) ) : the_row();

                                        $page_title = get_sub_field('page_title', $trip_id);
                                        $page_link = get_sub_field('page_url', $trip_id); ?>
                                        <li><a href="<?php echo site_url() . $page_link ?>" title="Link to <?php echo $page_title; ?>"><?php echo $page_title; ?></a></li>

                                    <?php endwhile;  ?>
                                </ul>
                            </div>
                        <?php } ?>
<!--representative section-->

                        <?php  
                            $hide_representative = get_field('hide_representative', $trip_id);
                            $choose_representative = get_field('choose_representative', $trip_id);
                            if($hide_representative == "No"){?>
                            <div class="sidebar-item expert-listing">
                                <h5 class="sidebar-item-title">Speak to an Expert? </h5>
                                <?php if($choose_representative){?>
                                <ul class="trip-expert">
                                    <?php foreach($choose_representative as $representative){

                                        $post_info = get_post( $representative);
                                        
                                        $featured_img_url = get_the_post_thumbnail_url($representative,'full'); 
                                        ?>
                                        <li class="trip-expert__item">
                                            <div class="trip-expert__image">
                                                <img src="<?php echo $featured_img_url;?>">
                                            </div>
                                            <div class="trip-expert__detail">
                                                <div class="trip-expert__name"><?php echo $post_info->post_title;?></div>
                                                 <div class="trip-expert__phone">Phone: <?php echo $post_info->post_content;?></div>
                                            </div>
                                        </li>
                                    <?php 
                                    wp_reset_query();
                                     }?>
                                </ul>
                                <?php } ?>
                            </div>
                            <?php } ?>                 

<!--end of representative section-->

                            <?php //dynamic_sidebar( 'trip-sidebar' ); ?>

                    </div>
                </div><!-- .col-lg-4 -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!--trip-tab-->
<div class="bottom-block-content">
    <?php if (get_field('trip_note')) { ?>
        <div class="extra-info show">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <?php the_field('trip_note'); ?>
                    </div>
                </div>
            </div>
        </div><!--extra-info-->
    <?php } ?>
    <?php if (get_field('trip_distinct_features')) { ?>
        <div class="trip-speciality">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <?php the_field('trip_distinct_features'); ?>
                    </div>
                </div>
            </div>
        </div><!--tirp-soul-->
    <?php } ?>
    <div class="trip-review">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="brown-title">Customer Reviews</h4>
                    <?php include(get_template_directory() . '/template-parts/tab-trip-detail/tab-review.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="related-block">
    <?php

    $related_trips = get_field('related_trips');

    if( $related_trips ): ?>
        <div class="related-trips">
            <div class="container">
                <header class="section-header col-lg-12">
                    <div class="row">
                        <span class="heading-title">RELATED TRIPS</span>
                    </div>
                </header>
                <section class="related-trip-slider slider">
                    <?php foreach( $related_trips as $related_trip ):
                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($related_trip->ID, 'square')); ?>
                        <div>

                                <figure>
                                    <div class="transparent-holder" style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: cover; "></div>
                                </figure>
                                <div class="related-trip-content">
                                    <div class="hover-hdden">
                                        <h5><a href="<?php echo get_permalink( $related_trip->ID ); ?>"> <?php echo get_the_title($related_trip->ID); ?> </a></h5>
                                        <span class="bestseller--trip-days">Go on <?php if(get_field('total_days', $related_trip->ID) == 1) { echo 'a day'; } else { echo get_field('total_days', $related_trip->ID) . ' Day'; } ?>
                                            Trip for</span>
                                        <?php $cost = get_field('trip_cost', $related_trip->ID);
                                        if(get_field('discount_percentage', $related_trip->ID)) {
                                            $dcost = $cost - (get_field('discount_percentage', $related_trip->ID) / 100) * $cost;
                                            $dis_per = get_field('discount_percentage', $related_trip->ID);
                                        }
                                        ?>
                                        <?php if ($dcost == $cost) { ?>
                                            <span class="bestseller--cost">USD <?php echo number_format($cost); ?> PP</span>
                                        <?php } elseif ($dcost) { ?>
                                            <span class="bestseller--cost"><span
                                                    class="initial-cost">USD <?php echo number_format($cost); ?></span>USD <?php echo $dcost; ?>
                                                PP</span>
                                        <?php } else { ?>
                                            <span class="bestseller--cost">USD <?php echo number_format($cost); ?> PP</span>
                                        <?php } ?>
                                    </div>
                                </div>

                        </div>
                     <?php endforeach; ?>
                </section>
            </div>

        </div>

    <?php endif;

        $posts = get_field('related_article');

        if( $posts ): ?>
            <section class="latest-blog">
                <div class="container">
                    <header class="section-header col-lg-12">
                        <div class="row">
                            <span class="heading-title">RELATED ARTICLES</span>
                        </div>
                    </header>
                    <div class="row">
                        <?php foreach( $posts as $p ): // variable must NOT be called $post (IMPORTANT) ?>
                            <div class="col-lg-3 col-md-3 col-sm-6 primary-box">
                                <?php if (has_post_thumbnail($p->ID)) {
                                    ?>
                                    <figure>
                                        <a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_post_thumbnail( $p->ID, 'footer-blog-thumb'); ?></a>
                                    </figure>
                                    <?php
                                } ?>
                                <div class="primary-box--content">
                                    <h5><a href="<?php echo get_permalink( $p->ID ); ?>"> <?php echo get_the_title($p->ID); ?> </a></h5>

                                    <div class="primary-box--info">
                                        <?php echo wp_trim_words($p->post_content, 20) ?>
                                        <!--                                    --><?php //echo apply_filters('the_content', substr(get_the_excerpt(),90,'...'));
                                        ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif;  ?>

    </div>
</div><!-- .bottom-content-wrap -->
<script>
    //add title in enquery form
    var post_title= '<?php echo get_the_title();?>';
    $('#input_7_10').val(post_title);
    $('#input_7_10').before('<h1 class="border-btm">'+post_title+'</h1>');

    $(".enq-without-date").click(function() {
        //debugger;
        $('#input_7_17').val('Not available');
        $('#input_7_17').parent().parent().hide();
     
    });
    
    $(".enq-with-date").click(function() {
        //debugger;
       if($(this)[0].innerHTML =="INQUIRE NOW") {
        $('#input_7_17').parent().parent().show();
        $('#input_7_17').val($(this).parent().parent().children().eq(0).html());
       }
     
    });

</script>
<?php
get_footer();
