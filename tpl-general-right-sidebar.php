<?php
/**
 * Template Name: General - Right Sidebar
 */

get_header();
$id_current_page = get_the_ID(); ?>
<?php if(get_field('youtube_video_id')){ ?>
    <div class="video-container">
        <div class="video-poster" style="background: url(https://img.youtube.com/vi/<?php echo get_field('youtube_video_id'); ?>/maxresdefault.jpg) no-repeat center center; background-size: cover;"></div>
        <div id="module-video" class="module-video"></div>
        <div class="video-content">
            <?php if(get_field('video_section_title')){ ?><h2><?php echo get_field('video_section_title'); ?></h2><?php } ?>
            <?php if(get_field('youtube_video_description')){ ?><p><?php echo get_field('youtube_video_description'); ?></p><?php } ?>
            <a href="https://www.youtube.com/embed/<?php echo get_field('youtube_video_id'); ?>?autoplay=1" class="fancybox-video">
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
<?php }else{
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
        <?php
    }
} ?>
    <div id="primary" class="content-area container">
    
    <main id="main" class="site-main col-lg-9 col-md-8" role="main">

        <?php
        while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('content-area-inner'); ?>>
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
    <div class="col-lg-3 col-md-4">

        <aside id="secondary" class="widget-area" role="complementary">
            <?php if ($post->post_parent)	{
                $ancestors=get_post_ancestors($post->ID);
                $root=count($ancestors)-1;
                 $parent_id = $ancestors[$root];
            } else {
                 $parent_id = $post->ID;
            }
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => $parent_id,
                'order'          => 'ASC',
                'orderby'        => 'title'
            );


            $parent = new WP_Query( $args );

            if ( $parent->have_posts() ) : ?>
            <section id="sticky-menu-container" class="widget widget_nav_menu">
                <div class="widget-wrap">
                    <h5 class="widget-title"><?php echo get_the_title($parent_id); ?></h5>
                    <div class="menu-about-ath-container">
                        <ul id="menu-about-ath" class="menu sub-menu-widget">

                            <?php while ( $parent->have_posts() ) : $parent->the_post();
                                $id_loop_page = get_the_ID();
                                 ?>
                                <li<?php if($id_current_page == $id_loop_page){ echo ' class="page_item"'; } ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

                            <?php endwhile; ?>

                        </ul>
                    </div>
                </div>
            </section>
            <?php endif; wp_reset_query(); ?>
        </aside>
    </div>
    </div><!-- #primary -->

<?php
get_footer();
