<?php
// echo "Dest" . $_GET['dest'] . "Act" . $_GET['activity'] . "depart" . $_GET['departure'] . "cost" . $_GET['cost_min'] . $_GET['cost_max'] . "duration" . $_GET['duration_min'] . $_GET['duration_max'] ;
// exit();
            
                require ( "../../../wp-config.php");
                if(isset($_GET['departure']) && $_GET['departure'] != '0') {
                    $departure_date = '%' . substr($_GET['departure'], 4, 2) .  '/%/' . substr($_GET['departure'], 0, 4) . ' -%';
                } else {
                    $departure_date = '';
                }
                if(isset($_GET['activity'])) {
                   $activity = $_GET['activity'];
                } else {
                    $activity = '';
                }
                if(isset($_GET['dest'])) {
                   $destination = $_GET['dest'];
                } else {
                    $destination = '';
                }
                $cost_min = $_GET['cost_min'];
                $cost_max = $_GET['cost_max'];

                $duration_min = $_GET['duration_min'];
                $duration_max = $_GET['duration_max'];

               $trips = find_trip_get(
                                        $activity, $destination, $departure_date, 
                                        $cost_min, $cost_max, $duration_min, 
                                        $duration_max
                );
                   
                
               //$num = count($trips);
               //echo "Count" . $num;
               
                $cost_sorts = array();
                $num = 0;
                foreach($trips as $trip) {
                    $cost_sorts[$trip->ID] = get_field("trip_cost", $trip->ID);
                }
                
                
                asort($cost_sorts);

                $filter_start_date = array();
                foreach ($cost_sorts as $data_id => $costy) {

                        $cnt = countDeparture($departure_date, $data_id);
                        if($cnt > 0) {
                            $num++; 
                           
                   
                    ?>
                     <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="border-box">
                            <?php //$cost = get_field("trip_cost");
                            $dis_per = get_field('discount_percentage', $data_id);
                            $des_cost = $costy - ($dis_per / 100) * $costy;

                            $current_date = date('Y-m-d'); //current date or any date
                            $end_date = get_field('offer_ends', $data_id); //Future date
                            ?>
                            <figure>
                                <?php if (has_post_thumbnail($data_id)) { ?>
                                    <?php echo get_the_post_thumbnail($data_id, 'small-thumb', array('class' => 'img-responsive')); ?>
                                <?php } ?>
                                <?php if ($dis_per != '') { ?>
                                    <figcaption class="primary-badge">

                                        <span><?php echo $dis_per; ?> % OFF</span>

                                        <?php if (daysDiff($current_date, $end_date) != '') { ?>
                                            <span><?php echo daysDiff($current_date, $end_date); ?></span>
                                        <?php } ?>
                                    </figcaption>
                                <?php } ?>
                                <div class="hover-show">
                                    <form method="post" action="/inquire-form" style="display: none;">
                                        <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                        <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                    </form>
                                    <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW </strong></a>
                                        <span class="learn-more"> or <a
                                                href="<?php the_permalink($data_id); ?>">learn
                                                more</a></span>
                                </div>
                            </figure>
                            <div class="border-box--content">
                                <h6>
                                    <a href="<?php the_permalink($data_id); ?>"><?php echo get_the_title($data_id); ?></a>
                                </h6>
                                <?php if(get_field('total_days', $data_id) != '') { ?>
                                <div class="border-box--trip-days">Go
                                    on <?php echo get_field('total_days', $data_id); ?> days
                                    trip
                                    at
                                </div>
                                <?php } if ($dis_per) { ?>
                                    <div class="border-box--trip-cost"><span
                                            class="initial-cost">US$ <?php echo $costy; ?></span>
                                        US$ <?php echo $des_cost; ?>
                                        Per
                                        Person
                                    </div>
                                <?php } else { if($costy != '') { ?>
                                    <div class="border-box--trip-cost">US$ <span class="t-sort"><?php echo $costy; ?></span> Per
                                        Person
                                    </div>

                                <?php } } ?>
                            </div>
                        </div>
                    </div>
                <?php }
               } //end of count departure
            
        wp_reset_postdata();

?>

<script type="text/javascript">
        var cnt = <?php echo $num; ?>;
        $('#total-trip').html(cnt + ' Matches Found');
        $('.border-box').matchHeight({
            byRow: true
        });
        // var $divs = $("#update .col-lg-4.col-md-4.col-sm-6.col-xs-12");

    // $('.btn-sort').on('click', function() {
            
    //       $(this).toggleClass('.ctrl-down');
    //       var numericallyOrderedDivs = $divs.sort(function(a, b) {
    //         if ($(a).find(".border-box--trip-cost .t-sort").text() < $(b).find(".border-box--trip-cost .t-sort").text()) {
    //           return $(a).find(".border-box--trip-cost .t-sort").text() < $(b).find(".border-box--trip-cost .t-sort").text();
    //         }else{
    //         return $(a).find(".border-box--trip-cost .t-sort").text() >$(b).find(".border-box--trip-cost .t-sort").text();
    //        }
    //   });
    //         $("#update").html(numericallyOrderedDivs);

    // });


</script>