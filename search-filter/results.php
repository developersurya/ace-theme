<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2015 Designs & Code
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 *
 */
if ($query->have_posts()) {
    ?>
 <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>

<h3 class="col-lg-12"><small id="total-trip">Found <?php echo $query->found_posts; ?> Results</small></h3>


    <?php $i = 0; $j = 0;
    while ($query->have_posts()) {
        $query->the_post();

        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12<?php if($i % 3 == 0){ echo ' clear-left'; } ?><?php if($j % 2 == 0){ echo ' clear-left-2-col'; } ?>">
            <div class="border-box">
                <div class="figure">
                    <?php $trip_image = get_field('trip_image');
                    if($trip_image){ ?>
                        <img src="<?php echo $trip_image['url']; ?>" alt="<?php echo $trip_image['alt']; ?>" />
                    <?php } else{ ?>
                        <img src="/wp-content/uploads/2016/05/trip-460x305.png" alt="Default Placeholder Image" />
                    <?php } ?>

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

                    <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                    <div class="clearfix">
                        <div class="trip-price__meta">
                            <?php
                            $cost = get_field('trip_cost');
                            if($cost) {
                            ?>
                                                <span class="border-box--trip-days">Go on <?php if(get_field('total_days') == 1) { echo 'a day'; } else { echo get_field('total_days') . ' day'; } ?>
                                                    trip
                                                    for
                                                </span>
                            <?php } ?>
                            <?php if (get_field('discount_percentage')) {
                                $dcost = $cost - (get_field('discount_percentage') / 100) * $cost;

                                ?>
                                <span class="border-box--trip-cost">
                                                        <span class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                        <span>USD <?php echo number_format($dcost); ?> </span>
                                                        PP
                                                    </span>
                            <?php } else {
                                if($cost){
                                    ?>
                                    <span class="border-box--trip-cost">
                                                        <span>USD <?php echo number_format($cost); ?></span> PP
                                                    </span>

                                <?php } }?>
                        </div><!-- .trip-price__meta -->
                    </div><!-- .clearfix -->
                </div><!-- .border-box--content -->
            </div><!-- .border-box -->


        </div>

        <?php $i++; $j++;
        if($i == 4){
            $i = 1;
        }
        if($j == 3){
            $j = 1;
        }
    }
    ?>
    <div class="col-lg-12 clear-left text-center">
        Page <?php echo $query->query['paged']; ?> of <?php echo $query->max_num_pages; ?>
    </div>

    <div class="col-lg-12 post-navigation clearfix">

        <div class="alignright"><?php next_posts_link('next', $query->max_num_pages); ?></div>
        <div class="alignleft"><?php previous_posts_link('previous'); ?></div>
        <?php
        /* example code for using the wp_pagenavi plugin */
        if (function_exists('wp_pagenavi')) {
            echo "<br />";
            wp_pagenavi(array('query' => $query));
        }
        ?>
    </div>
    <?php
} else {
    echo "No Results Found";
}
?>