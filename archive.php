<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
            <div id="primary" class="content-area col-lg-9 ">
                <main id="main" class="site-main" role="main">
                    <div class="custom-breadcrumb">
                        <a href="<?php echo site_url(); ?>">Home</a> &gt;
                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Blog</a> &gt;
                        <span><?php single_cat_title(); ?></span>
                    </div>
                    <h1 class="border-btm">Category: <?php single_cat_title(); ?></h1>
                    <?php
                    if (have_posts()) {

                        /* Start the Loop */
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('template-parts/content', get_post_format());

                        endwhile;
                        $prev_link = get_previous_posts_link('previous');
                        $next_link = get_next_posts_link('next');
                        if ($prev_link || $next_link){ ?>
                            <div class="post-navigation clearfix">
                                <div class="alignleft"><?php previous_posts_link('previous'); ?></div>
                                <div class="alignright"><?php next_posts_link('next'); ?></div>
                            </div>
                        <?php }
                    }else{
                        get_template_part('template-parts/content', 'none');

                    }
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

    </div>
<?php
get_footer();
