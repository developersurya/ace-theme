<?php
/**
 * Template Name: General - Repeater Content
 */

get_header();
?>

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
    <div class="container company">
        <div class="row">
            <div class="col-lg-12">
                <?php if (get_field('top_heading')) { ?>
                    <div class="hint-text"><?php the_field('top_heading'); ?></div>
                <?php } ?>
                <h1 class="page-heading"><?php the_title(); ?></h1>
            </div>
            <div class="col-lg-12">
                <div class="inner-wrap">
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <?php  if( have_rows('content_repeater') ): ?>
            <div class="col-lg-12 page-link-box">
                <div class="row">


                    <?php 
                        while ( have_rows('content_repeater') ) : the_row();
                            $image = get_sub_field('image');
                            $content = get_sub_field('content');
                            $link = get_sub_field('link');
                            $title = get_sub_field('title'); 
                    ?>
                         <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="border-box border-box-bg no-effect">
                                    <?php if( $image ): ?>
                                           <figure>
                                                <a href="<?php echo $link; ?>">
                                                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>">
                                                </a>
                                            </figure>
                                            
                                        <?php endif; ?>
                                
                                <div class="border-box--content">
                                <?php if( $title ): ?>
                                    <h3>
                                        <a href="<?php echo site_url() . $link; ?>">
                                            <?php echo $title; ?>
                                        </a>
                                    </h3>
                                 <?php endif; ?>
                                    <div class="border-box--text">
                                        <?php echo $content; ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <?php  endwhile; ?>

                </div>
            </div><!--page-lin-box-->
        <?php endif; ?>
        </div>
    </div>
<?php get_footer();
