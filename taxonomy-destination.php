<?php
/**
 * Created by PhpStorm.
 * User: Dennis Karki
 * Date: 1/19/2016
 * Time: 2:34 PM
 */
get_header(); ?>
<div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
<?php
$current_date = date('Ymd');
$queried_object = get_queried_object();
$taxonomy = $queried_object->taxonomy;
$slug = $queried_object->name;
$term_id = $queried_object->term_id;

?>
    <div class="hero">

        <?php


        $cat_image = get_field('banner_image', 'destination' . '_' . $term_id);
         if ($cat_image != '') {
             $image_thumb = $cat_image['sizes']['banner-image-mobile'];
             $image_medium = $cat_image['sizes']['banner-image-tab'];
             $image = $cat_image['sizes']['banner-image'];
            ?>
            <figure
                class="hero-image">
                <picture>
                    <!--[if IE 9]>
                    <video style="display: none;"><![endif]-->
                    <source srcset="<?php echo $image; ?>" media="(min-width: 1200px)">
                    <source srcset="<?php echo $image_medium; ?>"
                            media="(min-width: 768px)">
                    <source srcset="<?php echo $image_thumb; ?>"
                            media="(min-width: 320px)">
                    <!--[if IE 9]></video><![endif]-->
                    <img srcset="<?php echo $image[0]; ?>"
                         alt="<?php the_title(); ?>">
                </picture>
            </figure>

        <?php } else { ?>
            <figure class="hero-image">
                <img class="img-responsive"
                     src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-placeholder.png"
                     alt="slide placeholder">
            </figure>
        <?php } ?>
        
    </div><!--hero-->

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hint-text">Destination</div>
                <h1 class="border-btm"><?php echo $slug; ?></h1>

                <div class="clearfix taxonomy-description">
                    <?php the_field('taxonomy_description', 'destination' . '_' . $term_id);
                    ?>
                </div>
            </div>

            <?php
                $categories = get_terms('activity');

                foreach ($categories as $cats) {

                    $args = array(
                        'post_type' => 'trip',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'slug',
                                'terms' => $slug,
                            ),
                            array(
                                'taxonomy' => 'activity',
                                'field' => 'slug',
                                'terms' => $cats->slug,
                            )
                        ),
                    );


                $query = new WP_Query($args);
                ?>
                <?php if ($query->have_posts()):
                    ?>

                    <div class="package-list clearfix">


                        <header class="section-header col-lg-12">

                            <span class="heading-title"><?php echo $cats->name; ?></span>

                        </header>

                        <div class="clearfix">
                            <?php
                                echo do_shortcode('[ajax_load_more post_type="trip" posts_per_page="6" order="ASC" orderby="menu_order" scroll="false" button_label="LOAD MORE ' . $cats->name . ' PACKAGES" repeater="template_1" taxonomy="destination:activity" taxonomy_terms="' . $slug . ':' . $cats->slug . '" taxonomy_operator="IN:IN"]');
                            ?>
                            <div class="border-box hidden"></div>
                        </div><!-- row -->
                    </div><!--package-list-->
                    <?php
                endif;
            }
            ?>
        </div>
    </div>
<?php get_footer(); ?>
