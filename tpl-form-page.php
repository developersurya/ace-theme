<?php
/**
 * Template Name: Form Template
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
    <div class="container booking-form">
        <div class="row">
            <div class="col-lg-6">
                <span class="hint-text">Trip Booking for</span>

                <h1 class="border-btm">  <?php if (isset($_POST['name'])) {
                        echo $_POST['name'];
                    } ?></h1>

                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();

                        echo the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php
get_footer();