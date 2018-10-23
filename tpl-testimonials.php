 <?php
/**
 * Template Name: Testimonials
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
    <div class="container company">
    <div class="col-lg-9">
        <div class="row">

            <?php
            while (have_posts()) :
            the_post(); ?>
                <?php if (get_field('top_heading')) { ?>
                    <div class="hint-text"><?php the_field('top_heading'); ?></div>
                <?php } ?>
                <h1 class="border-btm"><?php the_title(); ?></h1>
                <div class="sticky-short-desc">
                    <div class="container">
                        <div class="col-lg-9">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>

                </div>
                <?php endwhile; // End of the loop.
            ?>

            <div class="testimonial-section review-wrap">
                <?php
                    echo do_shortcode('[ajax_load_more post_type="testimonial" posts_per_page="6" scroll="false" button_label="LOAD MORE REVIEWS" repeater="template_5"]');
                ?>
            </div><!-- .testimonial-section -->
            <?php wp_reset_query() ?>
            <div id="testimonial-form-wrap" style="display:none; max-width:900px;">
                <div class="add-testimonial">
                    <?php
                    echo do_shortcode('[gravityform id="10" title="true" description="false" ajax="true" tabindex="23"]'); ?>
                </div>
            </div>

        </div>
    </div><!-- .col-lg-9 -->
   </div><!-- container company -->

<?php
get_footer();
