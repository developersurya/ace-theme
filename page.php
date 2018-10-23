<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package acethehimalaya
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
    <div id="primary" class="content-area section-seperator container">
    <?php if( $post->post_excerpt ) { ?>
		<div class="row">
            <div class="col-lg-12">
                <?php if (get_field('top_heading')) { ?>
                    <div class="hint-text"><?php the_field('top_heading'); ?></div>
                <?php } ?>
                <h1 class="border-btm style1"><?php the_title(); ?></h1>
            </div>
<!--            <div class="col-lg-4  col-lg-push-8">-->
<!--                <span class="hero-text">--><?php //the_excerpt(); ?><!--</span>-->
<!--            </div>-->
            <div class="col-lg-10">
            	<div class="content-area-inner"><?php if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                endwhile;
                endif;
                ?>
                </div><!-- .content-area-inner -->
            </div>

        </div><!-- .row -->
    <?php }else{ ?>
    <main id="main" class="site-main col-lg-9" role="main">

        <?php
        while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                   the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'acethehimalaya'),
                        'after' => '</div>',
                    ));
                    ?>
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
        <?php endwhile; // End of the loop.
        ?>

    </main><!-- #main -->
    <?php } ?>

 </div><!-- #primary -->
<?php
get_footer();
