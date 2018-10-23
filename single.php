<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package acethehimalaya
 */

get_header(); 
    $id = get_option('page_for_posts');
    $img = wp_get_attachment_image_src(get_post_thumbnail_id($id), "full");  ?>
    <figure class="hero-image">
        <img class="img-responsive" src="<?php echo $img[0]; ?>" alt="<?php the_title(); ?>">
    </figure>
    <div class="container">
        <div class="row">
            <div id="primary" class="content-area col-lg-9">
                <main id="main" class="site-main" role="main">
                    <div class="custom-breadcrumb">
                        <a href="<?php echo site_url(); ?>">Home</a> &gt;
                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Blog</a> &gt;
                        <span><?php the_title(); ?></span>
                    </div>
                    <?php
                    while (have_posts()) : the_post();

                        get_template_part('template-parts/content', get_post_format());

                        ?>
                        <div class="post-navigation clearfix">
                         <?php   $prev_post = get_adjacent_post('', '', true);
                            $next_post = get_adjacent_post('', '', false);
                        if(!empty($prev_post)) { ?>
                                <div class="alignleft">
                                    <?php previous_post_link( '%link', '' . ace_truncate_text(get_the_title($prev_post->ID), 35) );//'%title' ?>
                                </div>
                            <?php }  if(!empty($next_post)) { ?>
                                <div class="alignright">
                                    <?php next_post_link( '%link', ace_truncate_text(get_the_title($next_post->ID), 35) . '' );//'%title'; ?>
                                </div>
                            <?php } ?>
                        </div><!-- .post-navigation -->
                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
            <div class="col-lg-3">
                <div class="trip-sidebar">
                    <?php
                    $args=array(
                        'showposts'=>10,
                        'caller_get_posts'=>1
                    );
                    $my_query = new WP_Query($args);
                    if( $my_query->have_posts() ) { ?>
                        <div class="sidebar-item">
                            <?php
                            // the_widget('WP_Widget_Recent_Posts');
                            ?>
                            <div class="widget widget_recent_entries">
                                <h2 class="widgettitle">Recent Posts</h2>
                                <ul>
                                    <?php
                                    while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                            <small><?php the_time('F j, Y') ?></small>
                                        </li>
                                        <?php
                                    endwhile;
                                    ?>
                                </ul>
                            </div><!-- .widget -->
                        </div><!-- .sidebar-item -->
                    <?php  }
                    // Only show the widget if site has multiple categories.
                    if (acethehimalaya_categorized_blog()) :
                        ?>
                        <div class="sidebar-item">
                            <div class="widget widget_categories">
                                <h5 class="widget-title"><?php esc_html_e('Categories', 'acethehimalaya'); ?></h5>
                                <ul>
                                    <?php
                                    wp_list_categories(array(
                                        'orderby' => 'count',
                                        'order' => 'DESC',
                                        'show_count' => 0,
                                        'title_li' => '',
                                    ));
                                    ?>
                                </ul>
                            </div><!-- .widget -->
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div><!--container-->
<?php
get_footer();
