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
<?php $current_date = date('Ymd');
if($_GET['destination'] != '' && isset($_GET['destination'])){
    if($_GET['destination'] == 'Nepal'){
        $term_id = 1;
    }
    elseif($_GET['destination'] == 'Bhutan'){
        $term_id = 11;
    }
    elseif($_GET['destination'] == 'India'){
        $term_id = 14;
    }
    else{
        $term_id = 13;
    }
    $queried_object = get_queried_object();
    $taxonomy = $queried_object->taxonomy;
    $slug = $queried_object->name;
    $slug_name = $queried_object->slug;

}else{
$queried_object = get_queried_object();

$taxonomy = $queried_object->taxonomy;
$slug = $queried_object->name;
$activity = $queried_object->slug;
$term_id = $queried_object->term_id;
}

?>


    <div class="hero">
        <?php
//            if($_GET['destination'] != ''){
//                $term_obj = get_term( $term_id, 'destination');
//            }else{
//                $term_obj = get_term( $term_id, $taxonomy);
//            }

            if(isset($_GET['destination'])) {
                $slugD = strtolower($_GET['destination']) . '-' . $slug_name;
                $post_id = getActivityBanner($slugD);
                if($post_id != '') {
                    $post_image = get_the_post_thumbnail($post_id, 'banner-image');
                }
            } else{
                $term_obj = get_term( $term_id, $taxonomy);
                $cat_image = get_field('banner_image',  $term_obj);
            }
           //
       // echo $term_id;
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

        <?php } elseif ($post_image != '') { ?>
             <figure class="hero-image">
                 <?php echo $post_image; ?>
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
                <div class="hint-text"><?php echo $_GET['destination']; ?></div>
                <h1 class="border-btm"><?php echo $slug; ?></h1>
                <?php if(!isset($_GET['destination'])) { ?>
                    <div class="clearfix taxonomy-description">
                        <?php the_field('taxonomy_description', $term_obj);
                        ?>
                    </div>
                <?php } else {  if($post_id != '') { ?>
                    <div class="clearfix taxonomy-description">
                        <?php

                                $content_post = get_post($post_id);
                                $content = $content_post->post_content;
                                $content = apply_filters('the_content', $content);
                                echo $content;

                        ?>
                    </div>
                <?php  } } ?>
            </div><!-- .col-lg-12 -->
<?php if(isset($_GET['destination'])) { ?>
            <div class="package-list clearfix">

                <header class="section-header col-lg-12">

                    <span class="heading-title"><?php echo $slug; ?></span>

                </header>
                <div class="clearfix">
                    <?php
                        echo do_shortcode('[ajax_load_more post_type="trip" posts_per_page="6" order="ASC" orderby="menu_order" scroll="false" button_label="LOAD MORE ' . $slug . ' PACKAGES" repeater="template_2" taxonomy="destination:activity" taxonomy_terms="' . $_GET['destination'] . ':' . $activity . '" taxonomy_operator="IN:IN"]');
                    ?>
                    <div class="border-box hidden"></div>
                </div><!-- clearfix -->
            </div><!--package-list-->
<?php } else {



//    while (have_posts()) :
//        the_post();
//        if (get_post_type(get_the_ID()) == 'trip') {
//            $c_list = wp_get_post_terms(get_the_ID(), 'destination', array("fields" => "names"));
//
//            $country[$c_list[0]][] = array(
//                'id' => get_the_ID()
//            );
//        }
//
//    endwhile;
//    if (!empty($country)) {
//        $postCountry = '';
        ?>
        <div class="package-list clearfix">
            <?php //if ($postCountry != $post_country) { ?>
            <header class="section-header col-lg-12">

                <span class="heading-title"><?php echo $slug; ?></span>

            </header>
            <?php //} ?>
            <div class="clearfix">

                <?php
                    echo do_shortcode('[ajax_load_more post_type="trip" posts_per_page="6" order="ASC" orderby="menu_order" scroll="false" button_label="LOAD MORE ' . $slug . ' PACKAGES" repeater="template_2" taxonomy="activity" taxonomy_terms="' . $activity . '" taxonomy_operator="IN:IN"]');
                 ?>


                        <?php
                //} ?>
            </div><!-- .clearfix -->
        </div><!-- .package-list -->
        <?php //$postCountry = $post_country;

   // }
} ?>

       </div><!-- .row -->
    </div><!-- .container -->


<?php get_footer();