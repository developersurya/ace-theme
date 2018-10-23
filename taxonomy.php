<?php
/**
 * Created by PhpStorm.
 * User: Dennis Karki
 * Date: 1/19/2016
 * Time: 2:34 PM
 */
get_header();
$current_date = date('Ymd');
$queried_object = get_queried_object();
$taxonomy = $queried_object->taxonomy;
$slug = $queried_object->name;
$term_id = $queried_object->term_id;

?>
 <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hint-text">Destination</div>
                <h1 class="border-btm"><?php echo $slug; ?></h1>

                <div class="clearfix taxonomy-description">
                    <?php the_field('taxonomy_description', 'activity' . '_' . $term_id);
                    ?>
                </div>
            </div>
<?php
$categories = get_terms('activity');
    $args = array(
        'post_type' => 'trip',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $slug,
            ),
            array(
                'taxonomy' => 'activity',
                'field' => 'slug',
                'terms' => $categories->name,
            )
        ),
    );

?>
            <?php while (have_posts()) :
            the_post();
            ?>
            <div class="package-list clearfix">

                <header class="section-header col-lg-12">

                    <span class="heading-title"><?php echo $slug; ?></span>

                </header>
                <div class="row">

                        <?php
                        $featured_image = trim(wp_get_attachment_url(get_post_thumbnail_id(), 'home-trip'));

                        $end_date = get_field('offer_ends'); //Future date
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 ">
                            <div class="border-box">
                                <div class="figure"><?php the_post_thumbnail('home-trip'); ?>

                                    <div class="hover-show">
                                        <form method="post" action="/inquire-form" style="display: none;">
                                            <input type="hidden" name="slug-name" value="<?php the_title(); ?>" >
                                            <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                        </form>
                                        <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW </strong></a>
                                                <span class="learn-more"> or <a href="<?php the_permalink(); ?>">learn
                                                        more</a></span>
                                    </div>
                                </div>

                                <div class="border-box--content">
                                    <?php if(date("Ymd", strtotime($current_date)) <= date("Ymd", strtotime($end_date))){ ?>
                                        <span class="offer_time">Ends in: <?php echo daysDiff($current_date, $end_date); ?></span>
                                    <?php } ?>
                                    <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                    <div class="clearfix">
                                        <?php if (get_field('discount_percentage')): ?>
                                            <div class="discount-block">
                                                <span class="discount-block__title">Discount</span>
                                                <span class="discount-block__value"><?php echo get_field('discount_percentage'); ?> % OFF</span>

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
                                                        <span class="initial-cost">$<?php echo number_format($cost); ?></span>
                                                        <span> $<?php echo number_format($dcost); ?> </span>
                                                        PP
                                                    </span>
                                            <?php } else {
                                                if($cost){ ?>
                                                    <span class="border-box--trip-cost">
                                                        <span>$ <?php echo number_format($cost); ?></span> PP
                                                    </span>

                                                <?php } } ?>
                                        </div><!-- .trip-price__meta -->
                                    </div><!-- .clearfix -->
                                </div><!-- .border-box--content -->
                            </div><!-- .border-box -->
                        </div>
                    <div class="border-box hidden"></div>
                </div><!-- row -->
            </div><!--package-list-->
            <?php
            endwhile;
            ?>
        </div>
    </div>

<?php get_footer();
