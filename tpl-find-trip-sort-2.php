<?php 
// print_r($departure_args);
// $args = array(
//                             'post_type' => 'trip',
//                             'posts_per_page' => -1,
//                             'meta_query' => array(
//                                 'relation' => 'AND',
//                                 array(
//                                     'key' => 'trip_cost',
//                                     'value' => array($cost['min'], $cost['max']),
//                                     'type' => 'numeric',
//                                     'compare' => 'BETWEEN',
//                                 ),
//                                 array(
//                                     'key' => 'total_days',
//                                     'value' => array($duration['min'], $duration['max']),
//                                     'type' => 'numeric',
//                                     'compare' => 'BETWEEN',
//                                 ),
//                                 $departure_args
//                             ),
//                             'tax_query' => array(
//                                 $tax_query_args,
//                             ),
//                         );
//                         $trips = new WP_Query($args);
                            
                        $trips = find_trip_get(
                                                    $activity, $destination, $departure_date, 
                                                    $cost['min'], $cost['max'], $duration['min'], 
                                                    $duration['max'] 
                        );
                           
                        if(!isset($_GET['departure'])) {
                            $num = count($trips);
                        } else {
                            $num = 0;
                        }
                       
                        $cost_sorts = array();
                       
                        foreach($trips as $trip) {
                            $cost_sorts[$trip->ID] = get_field("trip_cost", $trip->ID);
                        }
                        arsort($cost_sorts);
                        foreach($cost_sorts as $data_id => $costy) {

                             $cnt = countDeparture($departure_date, $data_id);
                             if($cnt > 0) {
                                  if(isset($_GET['departure'])) {  $num++; }
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
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
                                               <?php  if (daysDiff($current_date, $end_date)!='') { ?>
                                                    <span><?php echo daysDiff($current_date, $end_date); ?></span>
                                                <?php } ?>
                                            </figcaption>
                                        <?php } ?>
                                        <div class="hover-show">
                                            <form method="post" action="/inquire-form">
                                                <input type="hidden" name="slug-name" value="<?php the_title(); ?>">
                                                <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                            </form>
                                                <span class="learn-more"> or <a href="<?php the_permalink($data_id); ?>">learn
                                                        more</a></span>
                                        </div>
                                    </figure>
                                    <div class="border-box--content">
                                        <h6><a href="<?php the_permalink($data_id); ?>"><?php echo get_the_title($data_id); ?></a></h6>
                                         <?php if(get_field('total_days', $data_id) != '')  { ?>
                                        <div class="border-box--trip-days">Go on <?php echo get_field('total_days', $data_id); ?> day
                                            trip
                                            for
                                        </div>
                                        <?php } if ($dis_per) { ?>
                                            <div class="border-box--trip-cost"><span
                                                    class="initial-cost">US$ <?php echo $costy; ?></span>
                                                US$ <?php echo $des_cost; ?>
                                                Per
                                                Person
                                            </div>
                                        <?php } else { if($cost != '') { ?>
                                            <div class="border-box--trip-cost">US$ <?php echo $costy; ?> Per
                                                Person
                                            </div>

                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
  }
?>
