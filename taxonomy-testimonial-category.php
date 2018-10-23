<?php
/**
 * Template Name: Testimonials
 */
get_header();
$queried_object = get_queried_object();
$taxonomy = $queried_object->taxonomy;
$slug = $queried_object->slug;
?>

    <div class="container company">
        <div class="col-lg-9">
            <div class="row">
                <h1 class="border-btm"><?php echo $_POST['trip_title']; ?></h1>
                <?php
                while (have_posts()) :
                    the_post(); ?>
                    <?php if (get_field('top_heading')) { ?>
                    <div class="hint-text"><?php the_field('top_heading'); ?></div>
                <?php } ?>
                <?php endwhile; // End of the loop.
                ?>
                <?php

                $args = array(
                    'posts_per_page' => 10,
                    'post_type' => 'testimonial',
                    'paged' => $_GET['page'],
                    'tax_query' => array(
                        array('taxonomy' => $taxonomy,
                            'field' => 'slug',
                            'terms' => $slug,
                        )

                    )) ;
                $wp_query = new WP_Query($args);
                ?>
                <div class="testimonial-section review-wrap">
                    <?php while($wp_query->have_posts()) :
                        $wp_query->the_post();
                        $post_id = get_the_ID();
                        ?>
                        <div class="clearfix mrgn-btm-3">
                            <div class="col-md-3 nopadding-left">
                                <div class="title-part">
                                    <span class="post-date"><?php echo date('j F, Y'), strtotime(get_the_date(date('F j, Y'), $post_id)); ?></span>
                                    <div class="rating-list">
                                        <span class="rating-title">Overall rating</span>
                                        <ul class="<?php echo get_field('rating_overall', $post_id); ?>">
                                            <li class="icon-star-outline  icon-star star-one"></li>
                                           <li class="icon-star-outline  icon-star star-two"></li>
                                            <li class="icon-star-outline  icon-star star-three"></li>
                                            <li class="icon-star-outline  icon-star star-four"></li>
                                            <li class="icon-star-outline  icon-star star-five"></li>
                                        </ul>
                                    </div>
                                    <h6><?php echo get_field('testimony_name');//echo get_the_title($post_id); ?></h6>
                                    <?php if(get_field('address', $post_id) || get_field('country', $post_id)){ ?><span class="author-address"><?php if(get_field('address', $post_id)){ ?><?php echo get_field('address', $post_id).', '; ?><?php } ?><?php echo get_field('country', $post_id); ?></span><?php } ?>
                                    <?php if(has_post_thumbnail()){
                                        the_post_thumbnail('medium');
                                    }else{ ?>
                                        <img src="<?php echo site_url(); ?>/wp-content/themes/acethehimalaya/images/avatar.jpg" alt="avatar">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-9">

                                <div class="content-box">
                                    <h6><?php echo get_the_title($post_id); ?></h6>
                                    <div class="rating-list">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="rating-title">Staff</span>
                                                <ul class="<?php echo get_field('rating_overall', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="rating-title">Value for money</span>
                                                <ul class="<?php echo get_field('rating_money', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="rating-title">Meals</span>
                                                <ul class="<?php echo get_field('rating_meals', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="rating-title">Accomodation</span>
                                                <ul class="<?php echo get_field('rating_accomodation', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="rating-title">Transportation</span>
                                                <ul class="<?php echo get_field('rating_transportation', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="rating-title">Guide</span>
                                                <ul class="<?php echo get_field('rating_guide', $post_id); ?>">
                                                    <li class="icon-star-outline  icon-star star-one"></li>
                                                    <li class="icon-star-outline  icon-star star-two"></li>
                                                    <li class="icon-star-outline  icon-star star-three"></li>
                                                    <li class="icon-star-outline  icon-star star-four"></li>
                                                    <li class="icon-star-outline  icon-star star-five"></li>
                                                </ul>
                                            </div>
                                        </div><!-- .row -->
                                    </div><!-- .rating-list -->
                                    <?php
                                    $content_post = get_post($post_id);
                                    $content = $content_post->post_content;
                                    $content = apply_filters('the_content', $content);
                                    echo $content;
                                    //trip images
                                    if(have_rows('picture')) : ?>
                                        <div class="user-trip-photo clearfix">
                                    <?php while(have_rows('picture')) :
                                            the_row();
                                            $tripImage = get_sub_field('trip_image');
                                            $tripImages = wp_get_attachment_image_src($tripImage['ID'], 'small-thumb');
                                            ?>
                                            <a class="fancybox" rel="gallery-<?php echo $post_id; ?>" href="<?php echo $tripImage['url']; ?>">
                                                <img src="<?php echo $tripImages[0]; ?>">
                                            </a>
                                            <?php
                                        endwhile; ?>
                                        </div>
                                        <?php
                                    endif;

                                    //video

                                    if(get_field('video_code', $post_id)) {
                                        echo "<div class='video-embed'>";
                                        echo '<iframe width="500" height="315" src="https://www.youtube.com/embed/' . get_field('video_code', $post_id) . '" frameborder="0" allowfullscreen></iframe>';
                                        echo "</div>";
                                    }
                                    ?>
                                </div><!-- .content-box -->
                            </div>
                        </div><!-- .clearfix -->
                        <?php
                    endwhile;
                    ?>
                </div><!-- .testimonial-section -->
                <div class="post-navigation clearfix">

                        <?php
                            $argsPaginate = array(
                                'post_type' => 'testimonial',
                                'tax_query' => array(
                                    array('taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $slug,
                                    )

                                )) ;
                            $cntQuery = new WP_Query($argsPaginate);
                            tax_paginate($cntQuery, $_GET['page'], $slug);
                        ?>

                <?php wp_reset_query() ?>
        </div><!-- .col-lg-9 -->
            </div>
        </div>
    </div><!-- container company -->

<?php
get_footer();
