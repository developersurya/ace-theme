<?php
/**
 * Template Name: Up to 50% off trips
 */
get_header(); ?>

<?php
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

<?php } ?>
<div class="container common-inner">
     <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
    <div class="row">
        <div class="col-lg-12">
            <?php if (get_field('top_heading')) { ?>
                <div class="hint-text"><?php the_field('top_heading'); ?></div>
            <?php } ?>
            <h1 class="border-btm"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
        <section class="discount-trip">
            <div class="container">
             <?php
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
                    $posts = new WP_Query($args);
                     if ($posts->have_posts()) { ?>
                <header class="section-header col-lg-12 ">
                    <div class="row">
                        <span class="heading-title">UP TO 50% OFF TRIPS</span>
                    </div>
                </header>
                <div class="row">

                        <?php while ($posts->have_posts()): $posts->the_post();
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
                                                    <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                                </form>
                                                 <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW </strong></a>
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
                                                <span class="border-box--trip-days">Go on <?php the_field('total_days'); ?>
                                                    day trip
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
                        endwhile;
                    }
                    wp_reset_postdata();
                    ?>
                    <div class="border-box hidden"></div>
                </div>

        </section>
    </div>
</div>
<?php get_footer(); ?>
