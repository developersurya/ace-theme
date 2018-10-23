<?php
/**
 * The main front page file.
 * @link https://codex.wordpress.org/Template_Hierarchy
 *Template Name: Home
 * @package acethehimalaya
 */
get_header(); ?>
 <div id="enquiry-popup-form" style="display:none; max-width:900px;">
                        <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
                        </div>

<?php $current_date = date('Ymd'); //current date or any date
    $args = array(
    'post_type' => 'trip',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'home_slider',
            'value' => '1',
            'compare' => '=='
        )
    )
);

// query
$posts = new WP_Query($args);

if ($posts) {

    ?>
    <div id="homeslider" class="carousel carousel-fade slide " data-ride="carousel">

        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <?php $count = 0; ?>
            <?php while ($posts->have_posts()): $posts->the_post();
                ?>
                <li data-target="#homeslider" data-slide-to="<?php echo $count; ?>" class="<?php if ($count == 0) {
                    echo 'active';
                } ?>"></li>
                <?php
                $count++;
            endwhile;
            ?>
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">

            <?php $count = 0;
            while ($posts->have_posts()): $posts->the_post();
                $end_date = get_field('offer_ends', $posts->ID); //Future date
                ?>
                <div class="item slider-content <?php if ($count == 0) {
                    echo 'active';
                } ?>">
                    <?php
                    if (has_post_thumbnail($post->ID)) {
                        $image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'banner-image-mobile');
                        $image_medium = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'banner-image-tab');
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'banner-image');
                        ?>
                        <figure
                            class="slider-img">

                            <picture>
                                <!--[if IE 9]><video style="display: none;"><![endif]-->
                                <source srcset="<?php echo $image[0]; ?>" media="(min-width: 1200px)">
                                <source srcset="<?php echo $image_medium[0]; ?>"
                                        media="(min-width: 768px)">
                                <source srcset="<?php echo $image_thumb[0]; ?>"
                                        media="(min-width: 320px)">
                                <!--[if IE 9]></video><![endif]-->
                                <img srcset="<?php echo $image[0]; ?>"
                                     alt="<?php echo $post->post_title; ?>">
                            </picture>
                        </figure>

                    <?php } else { ?>
                        <figure class="slider-img">
                            <img class="img-responsive"
                                 src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-placeholder.png"
                                 alt="slide placeholder">
                        </figure>
                    <?php } ?>
                    <div class="container">
                        <div class="row">
                            <?php if (get_the_title() || get_the_excerpt()):
                                    if(date("Ymd", strtotime($current_date)) <= date("Ymd", strtotime($end_date))){
                                ?>
                                <span class="col-lg-12 offer_time"><strong><?php echo get_field('discount_percentage'); ?>% OFF</strong> Ends in: <?php echo daysDiff($current_date, $end_date); ?></span>
                                <?php } if (get_the_title()): ?>
                                    <h1 class="col-lg-12"><?php the_title(); ?></h1>
                                <?php endif; ?>
                                <div class="col-lg-7">

                                    <?php if (has_excerpt()) { ?>
                                        <div class="sc--short-desc"><?php echo get_the_excerpt() ; ?></div>
                                    <?php } else { ?>
                                        <div class="sc--short-desc"><?php  echo wp_trim_words( get_the_excerpt(), 35, $more = '' ) ; ?></div>
                                    <?php } ?>
                                    <span class="learn-more"><a href="<?php the_permalink(); ?>">learn more</a></span>
                                </div>
                            <?php endif; ?>
                            <div class="col-lg-5 trip__meta-wrap">
                                <div class="row">
                                    <ul class="col-lg-7  col-md-4  col-sm-12 col-lg-push-5 trip-info">
                                    <?php if(get_field('max_altitude')) { ?>
                                        <li class="sc--altitude"><i
                                                class="icon-altitude"></i><span><?php the_field('max_altitude'); ?></span>
                                        </li>
                                    <?php
                                    }   $trip_level_type = get_field("trip_level_type");
                                        $trip_level = get_field('trip_level');
                                        if($trip_level) {
                                    ?>
                                        <li class="sc--activity-level <?php
                                        if ($trip_level == 'Easy') {
                                            echo 'Easy';
                                        } elseif ($trip_level == 'Beginners') {
                                            echo 'Beginners';
                                        } elseif ($trip_level == 'Moderate') {
                                            echo 'Moderate';
                                        } elseif ($trip_level == 'Demanding') {
                                            echo 'Demanding';
                                        } elseif ($trip_level == 'Strenuous') {
                                            echo 'Strenuous';
                                        } elseif ($trip_level == 'Very Strenuous') {
                                            echo 'Very Strenuous';
                                        } elseif ($trip_level == 'Challenging') {
                                            echo 'Challenging';
                                        } elseif ($trip_level == 'Tough') {
                                            echo 'Tough';
                                        } elseif ($trip_level == 'Advanced') {
                                            echo 'Advanced';
                                        } elseif ($trip_level == 'Advanced Beginners') {
                                            echo 'Advanced Beginners';
                                        } elseif ($trip_level == 'Intermediate') {
                                            echo 'Intermediate';
                                        }

                                        ?>"><i
                                                class="ico-<?php echo $trip_level; ?>"></i><span><?php echo $trip_level; ?></span>

                                            <?php if ($trip_level == 'Easy') { ?>
                                                <?php if (get_field('trip_level_easy_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Easy"><?php the_field('trip_level_easy_discription', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Beginners') {
                                                if (get_field('trip_level_beginners_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Beginners"><?php the_field('trip_level_beginners_discription', 'option'); ?></div>
                                                <?php }
                                            }  elseif ($trip_level_type == 'Biking' && $trip_level == 'Moderate') {
                                                if (get_field('bikes_moderate_trip_level_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Moderate"><?php the_field('bikes_moderate_trip_level_description', 'option'); ?></div>
                                                <?php }
                                            }elseif ($trip_level == 'Moderate') {
                                                if (get_field('trip_level_moderate_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Moderate"><?php the_field('trip_level_moderate_discription', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Demanding') {
                                                if (get_field('trip_level_demanding_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Demanding"><?php the_field('trip_level_demanding_discription', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level_type == 'Biking' && $trip_level == 'Strenuous') {
                                                if (get_field('bikes_strenuous_trip_level_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Strenuous"><?php the_field('bikes_strenuous_trip_level_description', 'option'); ?></div>
                                                <?php }
                                            }
                                            elseif ($trip_level == 'Strenuous') {
                                                if (get_field('trip_level_strenuous_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Strenuous"><?php the_field('trip_level_strenuous_discription', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Challenging') {
                                                if (get_field('trip_level_challenging_discription', 'option')) { ?>
                                                    <div
                                                        class="tour-level Challenging"><?php the_field('trip_level_challenging_discription', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Tough') {
                                                if (get_field('trip_level_tough_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Tough"><?php the_field('trip_level_tough_description', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Advanced') {
                                                if (get_field('trip_level_advanced_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Advanced"><?php the_field('trip_level_advanced_description', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Advanced Beginners') {
                                                if (get_field('trip_level_advanced_beginners_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Advanced Beginners"><?php the_field('trip_level_advanced_beginners_description', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Intermediate') {
                                                if (get_field('trip_level_intermediate_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Intermediate"><?php the_field('trip_level_intermediate_description', 'option'); ?></div>
                                                <?php }
                                            } elseif ($trip_level == 'Very Strenuous') {
                                                if (get_field('trip_level_very_strenuous_description', 'option')) { ?>
                                                    <div
                                                        class="tour-level Very Strenuous"><?php the_field('trip_level_very_strenuous_description', 'option'); ?></div>
                                                <?php }
                                            }
                                            ?>


                                        </li>
                                        <?php } ?>

                                    </ul>
                                    <div class="col-lg-5 col-md-7 col-sm-12 col-lg-pull-7">
                                        <div class="col-lg-12 col-md-6 col-sm-6">
                                            <div class="row">
                                                <?php
                                                 $cost = get_field("trip_cost");
                                                 if ($cost) : ?>
                                                    <span class="sc--trip-days">Go on <?php if(get_field('total_days') == 1) { echo 'a day'; } else { echo get_field('total_days') . ' day'; } ?>
                                                          trip for</span>
                                                <?php endif; ?>
                                                <?php 
                                                $dis_per = get_field('discount_percentage');
                                                ?>
                                                <?php if ($dis_per) {
                                                    $des_cost = $cost - ($dis_per / 100) * $cost;
                                                    ?>
                                                    <div class="clearfix">
                                                        <span class="sc--initial-cost">USD <?php echo number_format($cost); ?></span>
                                                        <span class="sc--dis-cost">USD <?php echo number_format($des_cost); ?> PP</span>
                                                    </div>
                                                <?php } else { if ($cost) : ?>
                                                    <span class="sc--cost">USD <?php echo number_format($cost); ?> PP</span>
                                                <?php endif; } ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-6 col-sm-6">
                                            <div class="row">
                                                <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                                    <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                                    <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code'); ?>">
                                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                                </form>
                                                    <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW </strong></a>
                                                    

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $count++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

    </div>
<?php }
$args = array(
    'post_type' => 'trip',
    'posts_per_page' => 5,
    'meta_query' => array(
        array(
            'key' => 'best_seller_trips',
            'value' => '1',
            'compare' => '=='
        )
    )
);

// query
$posts = get_posts($args);
$first = $posts[0];
$second = $posts[1];
$third = $posts[2];
$fourth = $posts[3];
$fifth = $posts[4];

if ($posts) {

    ?>
    <section class="bestseller">
        <div class="container">
            <header class="section-header col-lg-12">
                <div class="row">
                    <span
                        class="heading-title"><?php the_field('our_best_sellers_title'); ?> for <?php echo date('Y'); ?></span>
                </div>
            </header>
            <div class="row">
                <ul class="col-lg-6 col-1">
                    <li class="col-lg-12">
                        <?php
                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($first->ID, 'square'));
                        ?>
                        <figure>
                            <div class="transparent-holder"
                                 style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: cover; "></div>
                        </figure>
                        <div class="bestseller--package-content">
                            <div class="hover-hdden">
                                <h5><?php echo $first->post_title; ?></h5>
                                <span class="bestseller--trip-days">Go on <?php if(get_field('total_days', $first->ID) == 1) { echo 'a day'; } else { echo get_field('total_days', $first->ID) . ' Day'; } ?>
                                     Trip for</span>
                                <?php $cost = get_field('trip_cost', $first->ID);
                                if(get_field('discount_percentage', $first->ID)) {
                                    $dcost = $cost - (get_field('discount_percentage', $first->ID) / 100) * $cost;
                                    $dis_per = get_field('discount_percentage', $first->ID);
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
                            <div class="hover-show large">
                                <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                    <input type="hidden" name="slug-name" value="<?php echo $first->post_title; ?>">
                                    <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code', $first->ID); ?>">
                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                </form>
                                <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php  echo $first->post_title;  ?>"><strong>INQUIRE NOW</strong></a>
                                                    
                                <span class="learn-more"> or <a href="<?php echo get_the_permalink($first->ID); ?>">learn
                                        more</a></span>
                            </div>
                        </div>
                    </li>
                    <li class="col-lg-12">

                        <?php
                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($second->ID, 'square'));
                        ?>
                        <figure>
                            <div class="transparent-holder"
                                 style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: cover; "></div>
                        </figure>
                        <div class="bestseller--package-content">
                            <div class="hover-hdden">
                                <h5><?php echo $second->post_title; ?></h5>
                                <span class="bestseller--trip-days">Go on <?php if(get_field('total_days', $second->ID) == 1) { echo 'a day'; } else { echo get_field('total_days', $second->ID) . ' Day'; } ?>
                                     Trip for</span>
                                <?php $cost2 = get_field('trip_cost', $second->ID);
                                if(get_field('discount_percentage', $second->ID)) {
                                    $dcost2 = $cost2 - (get_field('discount_percentage', $second->ID) / 100) * $cost2;
                                    $dis_per = get_field('discount_percentage', $second->ID);
                                }
                                ?>
                                <?php if ($dcost2 == $cost2) { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost2); ?> PP</span>
                                <?php } elseif ($dcost2) { ?>
                                    <span class="bestseller--cost"><span
                                            class="initial-cost">USD <?php echo number_format($cost2); ?></span>USD <?php echo $dcost2; ?>
                                        PP</span>
                                <?php } else { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost2); ?> PP</span>
                                <?php } ?>
                            </div>
                            <div class="hover-show">
                                <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                    <input type="hidden" name="slug-name" value="<?php echo $second->post_title; ?>">
                                    <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code', $second->ID); ?>">
                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                </form>
                                <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php echo $second->post_title; ?>"><strong>INQUIRE NOW</strong></a>
                                                    
                                <span class="learn-more"> or <a href="<?php echo get_the_permalink($second->ID); ?>">learn
                                        more</a></span>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="col-lg-6 col-2 col-md-12 ">
                    <li class="col-lg-12">

                        <?php
                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($third->ID, 'square'));
                        ?>
                        <figure>
                            <div class="transparent-holder"
                                 style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: cover; "></div>
                        </figure>
                        <div class="bestseller--package-content">
                            <div class="hover-hdden">
                                <h5><?php echo $third->post_title; ?></h5>
                                <span class="bestseller--trip-days">Go on <?php if(get_field('total_days', $third->ID) == 1) { echo 'a day'; } else { echo get_field('total_days', $third->ID) . ' Day'; } ?>
                                     Trip for</span>
                                <?php $cost3 = get_field('trip_cost', $third->ID);
                                if(get_field('discount_percentage', $third->ID)) {
                                    $dcost3 = $cost3 - (get_field('discount_percentage', $third->ID) / 100) * $cost3;
                                    $dis_per = get_field('discount_percentage', $third->ID);
                                }
                                ?>
                                <?php if ($dcost3 == $cost3) { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost3); ?> PP</span>
                                <?php } elseif ($dcost3) { ?>
                                    <span class="bestseller--cost"><span
                                            class="initial-cost">USD <?php echo number_format($cost3); ?></span>USD <?php echo $dcost3; ?>
                                        PP</span>
                                <?php } else { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost3); ?> PP</span>
                                <?php } ?>
                            </div>
                            <div class="hover-show">
                                <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                    <input type="hidden" name="slug-name" value="<?php echo $third->post_title; ?>">
                                    <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code', $third->ID); ?>">
                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                </form>
                                <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php echo $third->post_title; ?>"><strong>INQUIRE NOW</strong></a>
                                                    
                                <span class="learn-more"> or <a href="<?php echo get_the_permalink($third->ID); ?>">learn
                                        more</a></span>
                            </div>
                        </div>
                    </li>

                    <li class="col-lg-12 ">

                        <?php
                        $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($fourth->ID, 'square'));
                        ?>
                        <figure>
                            <div class="transparent-holder"
                                 style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: cover; "></div>
                        </figure>
                        <div class="bestseller--package-content">
                            <div class="hover-hdden">
                                <h5><?php echo $fourth->post_title; ?></h5>
                                <span class="bestseller--trip-days">Go on <?php if(get_field('total_days', $fourth->ID) == 1) { echo 'a day'; } else { echo get_field('total_days', $fourth->ID) . ' Day'; } ?>
                                     Trip for</span>
                                <?php $cost4 = get_field('trip_cost', $fourth->ID);
                                if(get_field('discount_percentage', $fourth->ID)) {
                                    $dcost4 = $cost4 - (get_field('discount_percentage', $fourth->ID) / 100) * $cost4;
                                    $dis_per = get_field('discount_percentage', $fourth->ID);
                                }?>
                                <?php if ($dcost4 == $cost4) { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost4); ?> PP</span>
                                <?php } elseif ($dcost4) { ?>
                                    <span class="bestseller--cost"><span
                                            class="initial-cost">USD <?php echo number_format($cost4); ?></span>USD <?php echo number_format($dcost4); ?>
                                        PP</span>
                                <?php } else { ?>
                                    <span class="bestseller--cost">USD <?php echo number_format($cost4); ?> PP</span>
                                <?php } ?>
                            </div>
                            <div class="hover-show large">
                                <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                    <input type="hidden" name="slug-name" value="<?php echo $fourth->post_title; ?>">
                                    <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code', $fourth->ID); ?>">
                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                </form>
                                <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php echo $fourth->post_title; ?>"><strong>INQUIRE NOW</strong></a>
                                                    
                                <span class="learn-more"> or <a href="<?php echo get_the_permalink($fourth->ID); ?>">learn
                                        more</a></span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </section>

<!--about section-->
    <section class="about-testimonial">
        <div class="container">

            <div class="row">
            <?php 
                $about_us = get_post($page_id = 3203);  // about us page id
                if(!empty($about_us->post_content)) {
                    $content = $about_us->post_content;
                    $content = apply_filters('the_content', $content);
            ?>
                <div class="col-lg-6">
                    <span class="site-name">Ace the Himalaya</span>
                    <!--Display page content of about us by passing page id -->
                    <p><?php 
                            echo wp_trim_words($content, 88);
                        ?>
                    </p>
                    <!--Display page permalink of about us by passing page id -->
                    <a href="<?php echo get_permalink(3203); ?>" class="btn btn-border">
                        READ MORE
                    </a>
                </div>
            <?php 
                } // end of about us if
                    $args = array(
                        'post_type' => 'testimonial',
                        'posts_per_page' => 5,
                        'meta_query' => array(
                            array(
                                'key' => 'featured_testimonial',
                                'value' => '1',
                                'compare' => '=='
                            )
                        
                    )
                );

                // query
                $posts = new WP_Query($args);

                if ($posts->post_count != 0) { ?>

                    <div class="col-lg-5 col-lg-offset-1 text-center">
                        <div id="testimonial-slider" class="carousel slide">
                            <!-- Carousel indicators -->
                            <ol class="carousel-indicators">
                                <?php $count = 0; ?>
                                <?php while ($posts->have_posts()): $posts->the_post();
                                    ?>
                                    <li data-target="#testimonial-slider" data-slide-to="<?php echo $count; ?>"
                                        class="<?php if ($count == 0) {
                                            echo 'active';
                                        } ?>"></li>
                                    <?php
                                    $count++;
                                endwhile;
                                ?>
                            </ol>
                            <!-- Carousel items -->
                              <div class="carousel-inner">
                                <?php $count = 0;
                                while ($posts->have_posts()): $posts->the_post(); ?>
                                    <div class="item <?php if ($count == 0) {
                                        echo 'active';
                                    } ?> testimonial">
                                        <h4 class="testimonial--title"><?php the_title(); ?></h4>
                                        <p class="testimonial--content"><?php echo wp_trim_words(get_the_excerpt(), 35, $more = ''); ?></p>
                                        <?php if(get_field('testimony_name', $post->ID)){ ?><span class="testimonial--author"><?php echo get_field('testimony_name', $post->ID); ?></span><?php } ?>
                                        <div class="testimonial--author-address">
                                            <?php the_field('address', $post->ID); ?>
                                            <?php if (get_field('address', $post->ID)) { ?>, <?php } ?><?php the_field('country', $post->ID); ?></div>
                                       </div>
                                    <?php
                                    $count++;
                                endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>
                        <a href="<?php echo site_url(); ?>/company/reviews" class="btn btn-border uppercase">Read all our testimonials</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<!--end about section-->
<!--video section -->
<?php if(get_field('youtube_video_id')){
        $video_img = get_field('youtube_video_image');
        ?>
    <div class="video-container">
        <div class="video-poster" style="background: url(<?php echo $video_img['url']; ?>) no-repeat center center; background-size: cover;"></div>
        <div id="module-video" class="module-video"></div>
        <div class="video-content">
            <?php if(get_field('video_section_title')){ ?><h2><?php echo get_field('video_section_title'); ?></h2><?php } ?>
            <?php if(get_field('youtube_video_description')){ ?><p><?php echo get_field('youtube_video_description'); ?></p><?php } ?>
            <a href="https://www.youtube.com/embed/<?php echo get_field('youtube_video_id'); ?>?autoplay=0" class="fancybox-video">
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
<?php } ?>
<!--end of video section -->

<!--Trip advisor-->      
   <?php       
           
       do_action( 'acethehimalaya_custom_info_section' );      
       do_action( 'acethehimalaya_custom_tripadvisor_section' );       
   ?>      
 <!--End of Trip advisor--> 

<?php }
             $current_date = date('Ymd'); //current date or any date
             $args = array(
                    'post_type' => 'trip',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'discount_percentage',
                            'value' => array(1, 50),
                            'type'      => 'NUMERIC',
                            'compare' => 'BETWEEN'
                        ),
                        array(
                            'key' => 'discount_percentage',
                            'value' => '',
                            'compare' => '!='
                        )
                    )
                );

                // query
                $query = new WP_Query($args);
                if ($query->have_posts()) {
 ?>
    <!--Discount trip starts-->
    <section class="discount-trip">
        <div class="container">
            <header class="section-header col-lg-12 ">
                <div class="row">
                    <span class="heading-title"><?php the_field('upto_50%_off_title'); ?></span>
                </div>
            </header>
            <div class="row">
                
                    <?php while ($query->have_posts()): $query->the_post();

                        $end_date = get_field('offer_ends'); //Future date
                        $dis_per = get_field('discount_percentage');

                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 ">
                            <div class="border-box">
                                <div class="figure">
                                    <?php $trip_image = get_field('trip_image');
                                    if($trip_image){ ?>
                                        <img src="<?php echo $trip_image['url']; ?>" alt="<?php echo $trip_image['alt']; ?>" />
                                    <?php } else{ ?>
                                        <img src="/wp-content/uploads/2016/05/trip-460x305.png" alt="Default Placeholder Image" />
                                    <?php } ?>
                                    <div class="hover-show">
                                        <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                            <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                            <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code'); ?>">
                                            <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                        </form>
                                        <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW</strong></a>
                                                    
                                                <span class="learn-more"> or <a href="<?php the_permalink(); ?>">learn
                                                        more</a></span>
                                    </div>
                                </div>

                                <div class="border-box--content">
                                    <?php  if(date("Ymd", strtotime($current_date)) <= date("Ymd", strtotime($end_date))){ ?>
                                        <span class="offer_time">Ends in: <?php echo daysDiff($current_date, $end_date); ?></span>
                                    <?php } ?>
                                    <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                    <div class="clearfix">
                                        <?php if (get_field('discount_percentage')): ?>
                                            <div class="discount-block">
                                                <span class="discount-block__title">Discount</span>
                                                <span class="discount-block__value"><?php echo $dis_per; ?> % OFF</span>

                                            </div>
                                        <?php endif; ?>
                                        <div class="trip-price__meta">
                                                <span class="border-box--trip-days">Go on <?php if(get_field('total_days') == 1) { echo 'a day'; } else { echo get_field('total_days') . ' day'; } ?>
                                                    trip
                                                    for
                                                </span>
                                            <?php
                                            $cost = get_field('trip_cost');
                                            $dcost = $cost - (get_field('discount_percentage') / 100) * $cost;

                                            ?>
                                            <?php if (get_field('discount_percentage')) { ?>
                                                <span class="border-box--trip-cost">
                                                        <span class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                        <span>USD <?php echo number_format($dcost); ?> </span>
                                                        PP
                                                    </span>
                                            <?php } else { ?>
                                                <span class="border-box--trip-cost">
                                                        <span>USD <?php echo number_format($cost); ?></span> PP
                                                    </span>

                                            <?php } ?>
                                        </div><!-- .trip-price__meta -->
                                    </div><!-- .clearfix -->
                                </div><!-- .border-box--content -->
                            </div><!-- .border-box -->
                        </div>
                        <?php
                        //} 
                        endwhile;
               
                wp_reset_postdata();
                ?>
                <div class="border-box hidden"></div>
            </div>

    </section>
    <?php } ?>
    <!--Feature trip section starts from here-->
    <section class="featured-trips">
        <div class="container">
            <header class="section-header col-lg-12">
                <div class="row">
                    <span class="heading-title"><?php echo get_field('featured_trips_title'); ?></span>
                </div>
            </header>
            <div class="row">
                <?php $args = array(
                    'post_type' => 'trip',
                    'posts_per_page' => 12,
                    'meta_query' => array(
                        array(
                            'key' => 'featured_trips',
                            'value' => '1',
                            'compare' => '=='
                        )
                    )
                );

                // query
                $posts = new WP_Query($args);
                if ($posts) {
                    while ($posts->have_posts()): $posts->the_post();   ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 ">
                                <div class="border-box">
                                    <div class="figure">
                                        <?php $trip_image = get_field('trip_image');
                                        if($trip_image){ ?>
                                            <img src="<?php echo $trip_image['url']; ?>" alt="<?php echo $trip_image['alt']; ?>" />
                                        <?php } else{ ?>
                                            <img src="/wp-content/uploads/2016/05/trip-460x305.png" alt="Default Placeholder Image" />
                                        <?php } ?>
                                        <div class="hover-show">
                                            <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display: none;">
                                                <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                                <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code'); ?>">
                                                <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                            </form>
                                            <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue" data-title="<?php the_title(); ?>"><strong>INQUIRE NOW</strong></a>
                                                   
                                                <span class="learn-more"> or <a href="<?php the_permalink(); ?>">learn
                                                        more</a></span>
                                        </div>
                                    </div>

                                    <div class="border-box--content">

                                        <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                        <div class="clearfix">
                                            <?php if (get_field('discount_percentage')): ?>
                                                <div class="discount-block">
                                                    <span class="discount-block__title">Discount</span>
                                                    <span class="discount-block__value"><?php echo get_field('discount_percentage'); ?> % OFF</span>

                                                </div>
                                            <?php endif; ?>
                                            <div class="trip-price__meta">
                                                <span class="border-box--trip-days">Go on <?php if(get_field('total_days') == 1) { echo 'a day'; } else { echo get_field('total_days') . ' day'; } ?>
                                                    trip
                                                    for
                                                </span>
                                                <?php $cost = get_field('trip_cost'); ?>
                                                <?php if (get_field('discount_percentage')) {
                                                    $dcost = $cost - (get_field('discount_percentage') / 100) * $cost;
                                                    ?>
                                                    <span class="border-box--trip-cost">
                                                        <span class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                        <span>USD <?php echo number_format($dcost); ?> </span>
                                                        PP
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="border-box--trip-cost">
                                                        <span>USD <?php echo number_format($cost); ?></span> PP
                                                    </span>

                                                <?php } ?>
                                            </div><!-- .trip-price__meta -->
                                        </div><!-- .clearfix -->
                                    </div><!-- .border-box--content -->
                                </div>
                            </div>
                        <?php
                    endwhile;
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>

    </section>
<?php $args = array(
    'post_type' => 'trip',
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'trip_of_the_month',
            'value' => '1',
            'compare' => '=='
        )
    )
);
$trip_title = get_field('trip_title');
// query
$posts = new WP_Query($args);
if ($posts) { ?>
    <?php while ($posts->have_posts()): $posts->the_post(); ?>
        <section class="monthly-trip">
            <div class="container">
                <div class="ribbon"><span><?php echo $trip_title; ?></span></div>
                <div class="col-lg-12">
                    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                </div>
                <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                    <?php
                    //                    $featured_image = trim(wp_get_attachment_url(get_post_thumbnail_id($query->ID), 'full'));
                    $featuredImage = (wp_get_attachment_url(get_post_thumbnail_id($query->ID), 'square'));
                    ?>
                    <a href="<?php the_permalink(); ?>"><figure class="monthly-trip--image"
                            style="background: url('<?php echo $featuredImage; ?>') no-repeat center; background-size: auto 100%; ">
                        <!-- <img class="img-responsive"
                             src="<?php /*echo $featured_image; */ ?>" alt="">-->
                        <!--                        --><?php //the_post_thumbnail('full', array('class' => 'img-responsive')); ?>

                    </figure></a>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-11 col-xs-11">
                    <!--mt stands for monthly trip -->
                    <p class="big-paragraph"><?php echo wp_trim_words(get_the_content(), 25) ?> <span class="learn-more"><a href="<?php the_permalink(); ?>">learn more</a></span></p>

                    <div class="mt-trip-detail">
       <?php if(get_field('max_altitude')) { ?> 
            <span class="mt--altitude"><i class="icon-altitude"></i><?php the_field('max_altitude'); ?></span> 
        <?php } ?>
        <?php if(get_field('trip_level')) { ?> 
        <div class="mt--activity-level"><i
                class="ico-<?php the_field('trip_level'); ?>"></i><span><?php the_field('trip_level'); ?></span>

            <div class="mt--activity-level-hidden">

                <?php if (get_field('trip_level') == 'Easy') { ?>
                    <?php if (get_field('trip_level_easy_discription', 'option')) { ?>
                        <div
                            class="tour-level Easy"><?php the_field('trip_level_easy_discription', 'option'); ?></div>
                    <?php }
                } elseif (get_field('trip_level') == 'Beginners') {
                    if (get_field('trip_level_beginners_discription', 'option')) { ?>
                        <div
                            class="tour-level Beginners"><?php the_field('trip_level_beginners_discription', 'option'); ?></div>
                    <?php }
                }  elseif ($trip_level_type == 'Biking' && $trip_level == 'Moderate') {
                    if (get_field('bikes_moderate_trip_level_description', 'option')) { ?>
                        <div
                            class="tour-level Moderate"><?php the_field('bikes_moderate_trip_level_description', 'option'); ?></div>
                    <?php }
                }  elseif (get_field('trip_level') == 'Moderate') {
                    if (get_field('trip_level_moderate_discription', 'option')) { ?>
                        <div
                            class="tour-level Moderate"><?php the_field('trip_level_moderate_discription', 'option'); ?></div>
                    <?php }
                } elseif (get_field('trip_level') == 'Demanding') {
                    if (get_field('trip_level_demanding_discription', 'option')) { ?>
                        <div
                            class="tour-level Demanding"><?php the_field('trip_level_demanding_discription', 'option'); ?></div>
                    <?php }
                }elseif ($trip_level_type == 'Biking' && $trip_level == 'Strenuous') {
                    if (get_field('bikes_strenuous_trip_level_description', 'option')) { ?>
                        <div
                            class="tour-level Strenuous"><?php the_field('bikes_strenuous_trip_level_description', 'option'); ?></div>
                    <?php }
                } elseif (get_field('trip_level') == 'Strenuous') {
                    if (get_field('trip_level_strenuous_discription', 'option')) { ?>
                        <div
                            class="tour-level Strenuous"><?php the_field('trip_level_strenuous_discription', 'option'); ?></div>
                    <?php }
                } elseif (get_field('trip_level') == 'Challenging') {
                    if (get_field('trip_level_challenging_discription', 'option')) { ?>
                        <div
                            class="tour-level Challenging"><?php the_field('trip_level_challenging_discription', 'option'); ?></div>
                    <?php }
                } elseif ($trip_level == 'Tough') {
                    if (get_field('trip_level_tough_description', 'option')) { ?>
                        <div
                            class="tour-level Tough"><?php the_field('trip_level_tough_description', 'option'); ?></div>
                    <?php }
                } elseif ($trip_level == 'Advanced') {
                    if (get_field('trip_level_advanced_description', 'option')) { ?>
                        <div
                            class="tour-level Advanced"><?php the_field('trip_level_advanced_description', 'option'); ?></div>
                    <?php }
                } elseif ($trip_level == 'Advanced Beginners') {
                    if (get_field('trip_level_advanced_beginners_description', 'option')) { ?>
                        <div
                            class="tour-level Advanced Beginners"><?php the_field('trip_level_advanced_beginners_description', 'option'); ?></div>
                    <?php }
                } elseif ($trip_level == 'Intermediate') {
                    if (get_field('trip_level_intermediate_description', 'option')) { ?>
                        <div
                            class="tour-level Intermediate"><?php the_field('trip_level_intermediate_description', 'option'); ?></div>
                    <?php }
                } elseif ($trip_level == 'Very Strenuous') {
                    if (get_field('trip_level_very_strenuous_description', 'option')) { ?>
                        <div
                            class="tour-level Very Strenuous"><?php the_field('trip_level_very_strenuous_description', 'option'); ?></div>
                    <?php }
                } ?>

            </div><!-- .mt-activity-level-hidden -->
        </div>
        <?php } ?>

        <?php if(get_field('total_days') && get_field('trip_cost')) { ?>

                        <span class="mt--trip-days">Go on <?php if(get_field('total_days') == 1) { echo 'a day'; } else { echo get_field('total_days') . ' day'; } ?> trip for
                            <?php $cost = get_field('trip_cost');
                            $dis_per = get_field('discount_percentage');
                            ?>
                            <?php if ($dis_per) {
                                $des_cost = $cost - ($dis_per / 100) * $cost;
                            ?>
                            <span class="mt--cost">
                                <span class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                <span class="sc--dis-cost">USD <?php echo number_format($des_cost); ?> PP</span>
                            </span>
            <?php } else { if ($cost) : ?>
                <span class="mt--cost">USD <?php echo number_format($cost); ?> PP</span>
            <?php endif; } ?>
        <?php } ?>
                        <form method="post" action="<?php echo site_url(); ?>/inquire-form" style="display:none;">
                            <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                            <input type="hidden" name="trip-code" value="<?php echo get_field('trip_code'); ?>">
                            <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                        </form>
                        <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW</strong></a>
                       
                    </div>
                </div>

            </div>
        </section>
        <?php
    endwhile;
}
    
?>
<!--latest blog section-->
<?php $args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
);
// query
$posts = new WP_Query($args);
if ($posts) { ?>
    <section class="latest-blog">
        <div class="container">
            <header class="section-header col-lg-12">
                <div class="row">
                    <span class="heading-title">LATEST FROM OUR BLOG</span>
                </div>
            </header>
            <div class="row">
                <?php while ($posts->have_posts()):
                    $posts->the_post(); ?>
                    <div class="col-lg-3 col-md-3 col-sm-6 primary-box">
                            <?php if (has_post_thumbnail()) {
                                ?>
                                <figure>
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('footer-blog-thumb'); ?></a>
                                </figure>
                                <?php
                            } ?>
                            <div class="primary-box--content">
                                <h5><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h5>

                                <div class="primary-box--meta"><?php the_time(' F jS, Y');

                            if(get_the_category_list()) {
                                        $category = ' under ' . get_the_category_list(__(', ', 'acethehimalaya')) ;
                                    }

                                        echo $category;
                                     ?>
                                </div>
                                <div class="primary-box--info">
                                    <?php echo wp_trim_words(get_the_content(), 20) ?>
                                    <!--                                    --><?php //echo apply_filters('the_content', substr(get_the_excerpt(),90,'...'));
                                    ?>
                                </div>
                            </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php } ?>
<!--end of latest blog section-->

<?php get_footer();

