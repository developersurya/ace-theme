<?php
/**
 * Template Name: Contact
 */
get_header();
?>
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
    <div class="container contact-us">
        <div class="row">

                <div class="col-lg-12">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            ?>
                            <div class="header-block">
                                <h1 class="page-heading"><?php the_title(); ?></h1>
                                <?php the_content(); ?>
                            </div>
                            <?php
                        } // end while
                    } // end if
                     if(get_field('working_hours')){ ?>
                    <h6>Working Hours:</h6>
                    <p class="office-hr"><?php the_field('working_hours'); ?></p>
                     <?php } ?>
                </div>

            <div class="col-lg-12 clearfix">
                <h6>Head Office</h6>

                <div class="row footer-contact--row col-md-6 col-sm-12 col-lg-12">
                    <div class="row">

                        <div class="col-lg-4">
                            <?php the_field('head_office', 'option'); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php the_field('north_america_office', 'option'); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php the_field('europe_office', 'option'); ?>
                        </div>
                    </div>
                </div>
                <div class="row footer-contact--row col-md-6 col-sm-12 col-lg-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <?php the_field('south_africa_office', 'option'); ?>
                        </div>
                        <div class="col-lg-4">
                            <?php the_field('indonesia_office', 'option'); ?>
                        </div>
                        <div class="col-lg-4">

                            <?php the_field('russia_and_east_europe_office', 'option'); ?>
                        </div>
                    </div>

                </div>
                <?php if(get_field('b2b_email')){ ?>
                    <span class="b2b-email"> <?php echo get_field('b2b_email'); ?></span>
                <?php } ?>
            </div>
            <div class="contact-form col-lg-6 clearfix">
                <?php echo do_shortcode('[gravityform id="6" title="false" description="true" ajax="true" tabindex="23"]'); ?>
            </div>
            <div class="col-lg-6">
                <div class="contact-map">
                    <?php echo get_field('google_map'); ?>
                    <?php if(get_field('map_url')){ ?>
                        <a href="<?php echo get_field('map_url'); ?>" target="_blank">View Large Map</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();