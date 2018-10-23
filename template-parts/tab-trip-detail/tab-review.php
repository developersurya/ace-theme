<?php
$post_id = $_POST['post_id'];
$post_data = get_post($post->post_parent);
?>
<?php
//for specific post rating calculation
$arg=array(
    'post_type' => 'testimonial',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'testimonial-category',
            'field' => 'slug',
            'terms' => $post_data->post_name,
        ),
    ),
);
$query = new WP_Query($arg);
$rating_arr = array();
if($query->have_posts()):while($query->have_posts()):$query->the_post();
    $ratings = get_field('rating_overall');
    switch ($ratings) {
        case "Five":
            $rating_number = 5;
            break;
        case "Four":
            $rating_number = 4;
            break;
        case "Three":
            $rating_number = 3;
            break;
        case "Two":
            $rating_number = 2;
            break;
        case "One":
            $rating_number = 1;
            break;
        default:
            $rating_number = 0;
    }
    $rating_arr[] = $rating_number;
endwhile;
    wp_reset_postdata();
endif;
$num_rating = count($rating_arr);
if(count($rating_arr) !=0){
    $av_rating =  round((array_sum($rating_arr))/(count($rating_arr)));
    //echo "<br/>Total review:".$num_rating ;
   // echo "<br/>Total average review:".$av_rating;
    if($av_rating == 5){
        $av_rating_text = 'Five';
        $av_rating_msg = 'Excellent';
    }
    if($av_rating == 4){
        $av_rating_text = 'Four';
        $av_rating_msg = 'Good';
    }
    if($av_rating == 3){
        $av_rating_text = 'Three';
        $av_rating_msg = 'Average';
    }
    if($av_rating == 2){
        $av_rating_text = 'Two';
        $av_rating_msg = 'Poor';
    }
    if($av_rating == 1){
        $av_rating_text = 'One';
        $av_rating_msg = 'Very Poor';
    }
    echo '<div class="overall-rating">
            <div class="rating-list large">
                <ul class="'.$av_rating_text.'">
                <li class="icon-star-outline  icon-star star-one"></li>
                <li class="icon-star-outline  icon-star star-two"></li>
                <li class="icon-star-outline  icon-star star-three"></li>
                <li class="icon-star-outline  icon-star star-four"></li>
                <li class="icon-star-outline  icon-star star-five"></li>
                </ul>
            </div>
            <span class="rating-msg large">'.$av_rating.' - '.$av_rating_msg.'</span>
            <span class="review-count">Based on '.$num_rating.' reviews</span>
        </div> ';
}else{

    //for general rating calculations
    $arg=array(
        'post_type' => 'testimonial',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'testimonial-category',
                'field' => 'slug',
                'terms' => 'general',
            ),
        ),
    );
    $query = new WP_Query($arg);
    $rating_arr = array();
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
        $ratings = get_field('rating_overall');
        switch ($ratings) {
            case "Five":
                $rating_number = 5;
                break;
            case "Four":
                $rating_number = 4;
                break;
            case "Three":
                $rating_number = 3;
                break;
            case "Two":
                $rating_number = 2;
                break;
            case "One":
                $rating_number = 1;
                break;
            default:
                $rating_number = 0;
        }
        $rating_arr[] = $rating_number;
    endwhile;
        wp_reset_postdata();
    endif;
    $num_rating = count($rating_arr);
    $av_rating =  round((array_sum($rating_arr))/(count($rating_arr)));
    //echo "<br/>Total review:".$num_rating ;
    //echo "<br/>Total average review:".$av_rating;
    if($av_rating == 5){
        $av_rating_text = 'Five';
        $av_rating_msg = 'Excellent';
    }
    if($av_rating == 4){
        $av_rating_text = 'Four';
        $av_rating_msg = 'Good';
    }
    if($av_rating == 3){
        $av_rating_text = 'Three';
        $av_rating_msg = 'Average';
    }
    if($av_rating == 2){
        $av_rating_text = 'Two';
        $av_rating_msg = 'Poor';
    }
    if($av_rating == 1){
        $av_rating_text = 'One';
        $av_rating_msg = 'Very Poor';
    }
    echo '<div class="overall-rating">
            <div class="rating-list large">
                <ul class="'.$av_rating_text.'">
                <li class="icon-star-outline  icon-star star-one"></li>
                <li class="icon-star-outline  icon-star star-two"></li>
                <li class="icon-star-outline  icon-star star-three"></li>
                <li class="icon-star-outline  icon-star star-four"></li>
                <li class="icon-star-outline  icon-star star-five"></li>
                </ul>
            </div>
            <span class="rating-msg large">'.$av_rating.' - '.$av_rating_msg.'</span>
            <span class="review-count">Based on '.$num_rating.' reviews</span>
        </div> ';
}

?>
<div>
    <?php if(get_field('review_tab_description','options')){ ?><p class="intro-text"><?php echo get_field('review_tab_description','options'); ?></p> <?php } ?>
    <a href="#share-story-form" class="fancybox"><strong>Share your story with us.</strong></a>

       <div id="share-story-form" style="display:none; max-width:900px;"><?php echo do_shortcode('[gravityform id="10" title="true" description="false" ajax="true" tabindex="23"]'); ?></div>
</div>

<div class="review-wrap">




    <?php

    $args = array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'testimonial-category',
                            'field' => 'slug',
                            'terms' => $post_data->post_name,
                        ),

                    ),

    );
    $loop = new WP_Query($args);
    if($loop->have_posts()) {
        echo do_shortcode('[ajax_load_more post_type="testimonial" taxonomy="testimonial-category" taxonomy_terms="' . $post_data->post_name . '" taxonomy_operator="IN" posts_per_page="6" scroll="false" button_label="LOAD MORE REVIEWS" repeater="template_6"]');
//        while ($loop->have_posts()) : $loop->the_post();
//
//            if (checkStatus($post_id) == TRUE) {
                ?>

                <?php
                // }
            //}
        //endwhile;
    } else {

        echo do_shortcode('[ajax_load_more post_type="testimonial" taxonomy="testimonial-category" taxonomy_terms="general" taxonomy_operator="IN" posts_per_page="6" scroll="false" button_label="LOAD MORE REVIEWS" repeater="template_6"]');

    } ?>


</div>


