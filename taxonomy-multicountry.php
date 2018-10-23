 <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
<?php
$current_date = date('Ymd');
    $categories = get_terms('destination');
    $args =  array(
            'post_type' => 'trip',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $slug,
                ),
                
            ),
        );
    $query = new WP_Query($args);

?>
        <?php if ($query->have_posts()): ?>

            <div class="package-list clearfix">

                <header class="section-header col-lg-12">

                    <span class="heading-title"><?php echo $cats->name; ?></span>

                </header>
                <div class="">

                    <?php while ($query->have_posts()): $query->the_post();
                        $featured_image = trim(wp_get_attachment_url(get_post_thumbnail_id(), 'home-trip'));

                        $end_date = get_field('offer_ends'); //Future date
                        ?>

                        <div class="col-lg-4 col-md-4 col-sm-6 ">
                            <div class="border-box">
                                <div class="figure"><?php the_post_thumbnail('home-trip'); ?>

                                    <div class="hover-show">
                                        <form method="post" action="/inquire-form" style="display: none;">
                                            <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
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
                                        <?php endif;
                                        if(get_field('trip_cost')){ ?>
                                            <div class="trip-price__meta">
                                                <span class="border-box--trip-days">Go on <?php the_field('total_days'); ?>
                                                    day trip
                                                    for
                                                </span>
                                                <?php
                                                $cost = get_field('trip_cost');


                                                ?>
                                                <?php if (get_field('discount_percentage')) {
                                                    $dcost = $cost - (get_field('discount_percentage') / 100) * $cost;
                                                    ?>
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
                                        <?php } ?>
                                    </div><!-- .clearfix -->
                                </div><!-- .border-box--content -->
                            </div><!-- .border-box -->
                        </div>

                        <?php
                    endwhile;
                    ?>

                    <div class="border-box hidden"></div>
                </div><!-- row -->
            </div><!--package-list-->
            <?php
                endif;
            ?>
        </div>
    </div>
    

