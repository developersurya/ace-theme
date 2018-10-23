<?php
/**
 * Template Name: Team
 */
get_header();
$terms = get_terms('team-category');

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
    <div class="container team">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-heading border-btm"><?php the_title(); ?></h1>
            </div>
            <?php if(has_excerpt()) { ?>
            <div class="col-lg-4  col-lg-push-8">
                    <span class="hero-text"><?php the_excerpt(); ?></span>
            </div>
            <?php } ?>
            <div class="<?php if(has_excerpt()) { echo 'col-lg-8 col-lg-pull-4'; } else{ echo 'col-lg-12'; }?>">
                <div class="inner-wrap">
                    <?php if (have_posts()) : while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    endif;
                    ?>
                </div>
            </div>
            <div class="team-tab clearfix">
                <div class="col-lg-3 col-md-4">
                    <ul class="nav nav-tabs" id="team-tab">
                        <?php
                            $count = 0;
                            foreach ($terms as $term) {
                        ?>
                            <li class="<?php if ($count == 0): echo 'active'; endif; ?>"><a
                                    href="#tab<?php echo $count; ?> "><?php echo $term->name; ?></a></li>

                        <?php
                            $count++;
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="tab-content">
                        <?php
                            $counti = 0;
                            foreach ($terms as $term) {
                                $args = array(
                                   'post_type' => 'team',
                                   'tax_query' => array(
                                       array(
                                            'taxonomy' => 'team-category',
                                            'field' => 'slug',
                                            'terms' => $term->slug
                                            )
                                    ),
                                   'posts_per_page' => -1,
                                );

                                $the_query = new WP_Query( $args );

                                if ($the_query->have_posts()) {
                        ?>
                            <div id="tab<?php echo $counti; ?>" class="tab-pane fade <?php if ($counti == 0): echo 'in active'; endif; ?> ">
                                <h4><?php echo $term->name; ?></h4>
                                <div class="row">
                                    <?php
                                        while($the_query->have_posts()) { $the_query->the_post();?>
                                            <div class="member-wrap clearfix">
                                                <div class="col-lg-4 col-md-5">
                                                   <?php the_post_thumbnail(); ?>
                                                    <h5 class="member-name"><?php the_title(); ?></h5>
                                                    <div class="member-designation">
                                                        <?php echo get_field('designation'); ?>
                                                    </div>

                                                </div>
                                                <div class="col-lg-8 col-md-7">
                                                	<p><?php echo wp_trim_words(get_the_content(), 100); ?></p>
                                                		<a href=" <?php the_permalink(); ?> " class="btn btn-border">Read More</a>
                                                </div>
                                            </div><!--member-wrap-->
                                            <?php

                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                                $counti++;
                                }
                                wp_reset_query();
                             }
                            ?>

                    </div>
                </div>
            </div>
        </div><!--row-->
    </div>
<?php
get_footer();
