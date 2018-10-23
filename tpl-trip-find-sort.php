 <div id="enquiry-popup-form" style="display:none; max-width:900px;">
    <?php echo do_shortcode('[gravityform id="7" title="true" description="false" ajax="true" tabindex="23"]'); ?>
</div>
            
                <?php
               
                $data = findTripBy(
                        $destination = returnMethod('post', 'destination'),
                        $activities = returnMethod('post', 'activities'),
                        $costM = returnMethod('post', 'costM'),
                        $costMa = returnMethod('post', 'costMa'),
                        $month = returnMethod('post', 'month'),
                        $key = ''
                );

                $cost_sort = array();
                foreach ($data as $deta_id) {
                    if(!empty($deta_id)) {
                        $cost_sort[$deta_id] = get_field("trip_cost", $deta_id);
                    }
                }
                arsort($cost_sort);
                $num = 0;
                if (count($data) > 0) {
                    
                    foreach($cost_sort as $deta_id => $cost) {
               ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                               <div id="sort-list">
                                <div class="border-box" >
                                    <?php //$cost = get_field("trip_cost", $deta_id);
                                    $dis_per = get_field('discount_percentage', $deta_id);
                                    $des_cost = $cost - ($dis_per / 100) * $cost;

                                    $current_date = date('Y-m-d'); //current date or any date
                                    $end_date = get_field('offer_ends', $deta_id); //Future date
                                    ?>
                                    <figure>
                                        <?php if (has_post_thumbnail($deta_id)) { ?>
                                            <?php echo get_the_post_thumbnail($deta_id, 'small-thumb', array('class' => 'img-responsive')); ?>
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
                                            <form method="post" action="/inquire-form" style="display: none;">
                                                <input type="hidden" name="slug-name"
                                                       value="<?php echo get_the_title($deta_id); ?>">
                                                <input type="submit" class="btn btn-default" value="INQUIRE NOW"/>
                                            </form>
                                             <a href="#enquiry-popup-form" class="fancybox home-inq-btn btn btn-blue"  data-title="<?php the_title(); ?>"><strong>INQUIRE NOW </strong></a>
                                            <span class="learn-more"> or <a href="<?php the_permalink($deta_id); ?>">learn
                                                    more</a></span>
                                        </div>
                                    </figure>
                                    <div class="border-box--content">
                                        <h6>
                                            <a href="<?php the_permalink($deta_id); ?>"><?php echo get_the_title($deta_id); ?></a>
                                        </h6>
                                        <?php if(get_field('total_days', $deta_id) != '')  { ?>
                                        <div class="border-box--trip-days">Go
                                            on <?php the_field('total_days', $deta_id); ?> days trip
                                            at
                                        </div>
                                        <?php  } if ($dis_per) { ?>
                                            <div class="border-box--trip-cost"><span
                                                    class="initial-cost">US$ <?php echo $cost; ?></span>
                                                US$ <?php echo $des_cost; ?>
                                                Per
                                                Person
                                            </div>
                                        <?php } else { if($cost != '') { ?>
                                            <div class="border-box--trip-cost">US$ <?php echo $cost; ?> Per
                                                Person
                                            </div>

                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php $num++;
                        }
                    }
                ?>