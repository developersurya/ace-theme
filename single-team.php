<?php
/**
 * Single Team
 */
get_header();
$banner = get_field('team_banner_image');
?>
<?php
if ($banner) {
    ?>
    <figure
        class="hero-image style1">

        <picture>
            <!--[if IE 9]>
            <video style="display: none;"><![endif]-->
            <source srcset="<?php echo $banner['sizes']['banner-image']; ?>" media="(min-width: 1200px)">
            <source srcset="<?php echo $banner['sizes']['banner-image-tab']; ?>"
                    media="(min-width: 768px)">
            <source srcset="<?php echo $banner['sizes']['banner-image-mobile']; ?>"
                    media="(min-width: 320px)">
            <!--[if IE 9]></video><![endif]-->
            <img srcset="<?php echo $banner['sizes']['banner-image']; ?>"
                 alt="<?php echo $banner['alt']; ?>">
        </picture>
    </figure>

<?php } ?>
    <div class="container team">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="border-btm"><?php the_title(); ?>
                    <div class="member-designation">
                    <?php echo get_field('designation'); ?>
                    </div>
                </h1>
            </div>
            <div class="col-lg-4  col-lg-push-8">
                <span class="hero-text"><?php echo get_field('highlighted_text'); ?></span>
            </div>
            <div class="col-lg-8 col-lg-pull-4">
                <div class="inner-wrap">
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <?php if(get_field('bottom_content')){ ?>
                <div class="bottom-content-wrap">
                    <?php echo get_field('bottom_content'); ?>
                </div>
           <?php } ?>
        </div><!--row-->
    </div>
<?php
get_footer();
