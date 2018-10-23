<?php
$pid = $_POST['post_id'];
$trip_code = get_field("trip_code", $pid);
$trip_days = get_field("total_days", $pid);
$trip_size = get_field("group_size", $pid);
$trip_cost = get_field("trip_cost", $pid);
$trip_level = get_field("trip_level", $pid);;
$trip_alt = get_field("max_altitude", $pid);
$trip_country = get_field("country_visited", $pid);
$trip_desti = get_field("destination", $pid);
$trip_season = get_field("best_season", $pid);
$trip_activityday = get_field("activity_per_day", $pid);
$trip_route = get_field("trip_route", $pid);
$trip_activity = get_field("activity", $pid);
$trip_category = get_field("destination", $pid);
$trip_discount = get_field("discount_percentage", $pid);
$trip_level_type = get_field("trip_level_type", $pid);
if($trip_discount) {
    $dcost = $trip_cost - ($trip_discount / 100) * $trip_cost;
}
?>

<?php if ($trip_code || $trip_days || $trip_size || $trip_discount || $trip_level || $trip_alt || $trip_country || $trip_activity || $trip_cost || get_field("starts_at", $pid) || get_field("ends_at", $pid)) { ?>
        <ul class="trip-facts clearfix">
            <?php if ($trip_code) { ?>
                <li class="trip-code odd col-lg-6"><span class="trip-facts__title"><i class="icon-tf_pen"></i>Trip Code: </span><span><?php echo $trip_code; ?></span></li>
            <?php } ?>
            <?php if ($trip_country) { ?>
                <li class="trip-visited even col-lg-6"><span class="trip-facts__title"><i class="icon-tf_country"></i>Country: </span><span><?php echo $trip_country ?></span></li>
            <?php } ?>
            <?php if ($trip_days) { ?>
                <li class="trip-days odd col-lg-6"><span class="trip-facts__title"><i class="icon-tf_clock"></i>Duration: </span><span><?php echo $trip_days; ?> Days</span></li>
            <?php } ?>
            <?php if ($trip_level) { ?>
                <li class="trip-level even col-lg-6<?php if($trip_level_type == 'Biking'){echo ' biking-type';}elseif($trip_level_type == 'Climbing'){echo ' climbing-type'; }else {echo ' tour-treks-type'; }
                if ($trip_level == 'Easy') {
                    echo ' Easy';
                } elseif ($trip_level == 'Beginners') {
                    echo ' Beginners';
                }
                elseif ($trip_level == 'Advanced Beginners') {
                    echo ' advanced-beginners';
                }
                elseif($trip_level_type == 'Biking' && $trip_level == 'Moderate'){
                    echo ' Moderate';
                }
                elseif ($trip_level == 'Moderate') {
                    echo ' Moderate';
                } elseif ($trip_level == 'Demanding') {
                    echo ' Demanding';
                }
                elseif($trip_level_type == 'Biking' && $trip_level == 'Strenuous'){
                    echo ' Strenuous';
                }
                elseif ($trip_level == 'Strenuous') {
                    echo ' Strenuous';
                } elseif ($trip_level == 'Challenging') {
                    echo ' Challenging';
                }
                elseif ($trip_level == 'Tough') {
                    echo ' Tough';
                }
                elseif ($trip_level == 'Very Strenuous') {
                    echo ' very-strenuous';
                }
                elseif ($trip_level == 'Intermediate') {
                    echo ' Intermediate';
                }
                elseif ($trip_level == 'Advanced') {
                    echo ' Advanced';
                }?>"><span class="trip-facts__title"><i class="icon-<?php if($trip_level_type == 'Biking'){echo 'biking';}elseif($trip_level_type == 'Climbing'){echo 'climbing'; }else {echo 'tf_level'; } ?>"></i>Trip Level: </span><div class="tooltip-wrap"><?php echo $trip_level; ?>

                    <?php if ($trip_level == 'Easy') { ?>
                        <?php if (get_field('trip_level_easy_discription', 'option')) { ?>
                            <div
                                class="tour-level Easy"><?php the_field('trip_level_easy_discription', 'option'); ?></div>
                        <?php }
                    } elseif ($trip_level == 'Beginners') {
                        if (get_field('trip_level_beginners_discription', 'option')) { ?>
                            <div
                                class="tour-level Beginners"><?php the_field('trip_level_beginners_discription', 'option'); ?></div>
                        <?php }
                    }  elseif ($trip_level_type == 'Biking' && $trip_level == 'Moderate') {
                        if (get_field('bikes_moderate_trip_level_description', 'option')) { ?>
                            <div
                                class="tour-level Moderate"><?php the_field('bikes_moderate_trip_level_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Moderate') {
                        if (get_field('trip_level_moderate_discription', 'option')) { ?>
                            <div
                                class="tour-level Moderate"><?php the_field('trip_level_moderate_discription', 'option'); ?></div>
                        <?php }
                    } elseif ($trip_level == 'Demanding') {
                        if (get_field('trip_level_demanding_discription', 'option')) { ?>
                            <div
                                class="tour-level Demanding"><?php the_field('trip_level_demanding_discription', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level_type == 'Biking' && $trip_level == 'Strenuous') {
                        if (get_field('bikes_strenuous_trip_level_description', 'option')) { ?>
                            <div
                                class="tour-level Strenuous"><?php the_field('bikes_strenuous_trip_level_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Strenuous') {
                        if (get_field('trip_level_strenuous_discription', 'option')) { ?>
                            <div
                                class="tour-level Strenuous"><?php the_field('trip_level_strenuous_discription', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Very Strenuous') {
                        if (get_field('trip_level_very_strenuous_description', 'option')) { ?>
                            <div
                                class="tour-level very-strenuous"><?php the_field('trip_level_very_strenuous_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Challenging') {
                        if (get_field('trip_level_challenging_discription', 'option')) { ?>
                            <div
                                class="tour-level Challenging"><?php the_field('trip_level_challenging_discription', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Tough') {
                        if (get_field('trip_level_tough_description', 'option')) { ?>
                        <div
                            class="tour-level Tough"><?php the_field('trip_level_tough_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Beginners') {
                        if (get_field('trip_level_beginners_description', 'option')) { ?>
                        <div
                            class="tour-level Beginners"><?php the_field('trip_level_beginners_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Advanced Beginners') {
                        if (get_field('trip_level_advanced_beginners_description', 'option')) { ?>
                        <div
                            class="tour-level advanced-beginners"><?php the_field('trip_level_advanced_beginners_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Intermediate') {
                        if (get_field('trip_level_intermediate_description', 'option')) { ?>
                        <div
                            class="tour-level Intermediate"><?php the_field('trip_level_intermediate_description', 'option'); ?></div>
                        <?php }
                    }
                    elseif ($trip_level == 'Advanced') {
                        if (get_field('trip_level_advanced_description', 'option')) { ?>
                        <div
                            class="tour-level Advanced"><?php the_field('trip_level_advanced_description', 'option'); ?></div>
                        <?php }
                    } ?>

                    </div></li>

            <?php } ?>
            <?php if ($trip_alt) { ?>
                <li class="trip-altitude odd col-lg-6 equal-box"><span class="trip-facts__title"><i class="icon-tf_altitude"></i>Max Altitude: </span><span><?php echo $trip_alt ?></span></li>
            <?php } ?>
              <?php  if($trip_activity) {
                ?>
                <li class="trip-activity even col-lg-6 equal-box">
                    <span class="trip-facts__title"><i class="icon-tf_activity"></i>Activity: </span><span><?php echo $trip_activity; ?></span></li>
           <?php  } ?>

            <?php if (get_field("starts_at", $pid)) { ?>
                <li class="trip-starts-at odd col-lg-6"><span class="trip-facts__title"><i class="icon-tf_trip-start"></i>Starts at: </span><span><?php the_field("starts_at", $pid); ?></span></li>
            <?php } ?>
            <?php if (get_field("ends_at", $pid)) { ?>
                <li class="trip-ends-at even col-lg-6"><span class="trip-facts__title"><i class="icon-tf_trip-end"></i>Ends at: </span><span><?php the_field("ends_at", $pid); ?></span></li>
            <?php } ?>

        </ul>
 <?php } ?>

<?php if($trip_season || $trip_route){ ?>
    <ul class="trip-facts full-width clearfix">
         <?php if($trip_route) { ?>
                <li class="trip-route col-lg-12"><span class="trip-facts__title"><i class="icon-tf_trip-route"></i>Trip Route:</span><span><?php echo $trip_route; ?></span>
                </li>
                <?php
            }
         if($trip_season) { ?>
            <li class="trip-season col-lg-12"><span class="trip-facts__title"><i class="icon-tf_season"></i>Best Season: </span><span> <?php echo $trip_season; ?></span>
            </li>
            <?php } ?>

    </ul>

<?php }
global $post;
if($post->post_content != '' || get_field('basic_itinerary', $pid) || get_field('trip_highlight', $pid)!='') {
?>

    <div class="row">
        <?php if(get_field('trip_highlight', $pid)!=''){ ?>
        <div class="col-lg-12 trip-highlight">
            <h4 class="section__heading">Trip Highlights</h4>
            <?php echo apply_filters('the_content', get_field('trip_highlight', $pid)); ?>
        </div>
    <?php } if($post->post_content != '') {
    ?>
    <div class="trip-info col-lg-12">
        <h4 class="section__heading">Trip Information</h4>
        <!--Display the page trip page content-->
        <?php echo apply_filters('the_content', $post->post_content); ?>
    </div>
    <?php
    }
    if(get_field('basic_itinerary', $pid)) {
    ?>
    <div class="trip-short-itinerary col-lg-12">
        <h4 class="section__heading">Itinerary</h4>
        <?php echo apply_filters('the_content', get_field('basic_itinerary', $pid)); ?>
    </div>
    <?php
    }
    ?>
</div>
<?php } ?>