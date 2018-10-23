<?php
$pid = $_POST['post_id'];
//dates description
$journey = getJourney('date_description', $pid = get_the_ID());
echo $journey->date_description;
?>
 <!-- //check the slug of new date post -->
    <?php
        //check the slug of new date post
        $post_slug = get_post_field( 'post_name', get_post() ); 
        //var_dump($post_slug);
        $args = array(
            'post_type' => 'tripdates',
             'name' =>$post_slug,
        );
        $trip_posts = array();
        $loop = new WP_Query($args);
        while($loop->have_posts()): $loop->the_post();
            $p_id = get_the_ID();
         wp_reset_postdata();
        endwhile;
        //var_dump($p_id);
    ?>
    <div style="display: none;"><?php //echo $p_id;?></div>
<div class="tab-date-content">
    <div id="date-row"></div>
    <section class="tab-journey-type">
        <ul class="nav nav-tabs">
            <?php 
                $class = "active";
                if (    have_rows('small_group_journey', $pid) ||
                        have_rows('group_size_info', $pid) ||
                        get_field('small_group', $pid)
                    )
                {
                    $tab_small = "active";
            ?> 
            <li class="<?php echo $class; ?>"><a href="#small-group" data-toggle="tab">Small Group Journey</a></li>
            <?php $class=''; } ?>

           <?php if(get_field('private_journey', $pid)) { ?> 
                <li class="<?php echo $class; ?>">
                <a href="#private-journey" data-toggle="tab">Private Journey</a></li>
            <?php 
                $class='';
                if (    !have_rows('small_group_journey', $pid) &&
                        !have_rows('group_size_info', $pid) && 
                        !get_field('small_group', $pid)
                    )
                {
                    $tab_private="active"; 
                }
            } ?>
            <?php if(get_field('tailor_made_journey', $pid)) { ?> 
                <li class="<?php echo $class; ?>"><a href="#tailor-made" data-toggle="tab">Tailor made Journey</a></li>
            <?php 
                $class='';  
                 if (   !have_rows('small_group_journey', $pid) &&
                        !have_rows('group_size_info', $pid) && 
                        !get_field('small_group', $pid) &&
                        !get_field('private_journey', $pid)
                    )
                {
                    $tab_tailor="active"; 
                }

            } ?>
        </ul>
        <ul class="tab-content clearfix">
            <div style="display: none;">
                    <?php  if (have_rows('new_small_group_journey', $p_id)) {
                          $arr_dateS = array();
                            while (have_rows('new_small_group_journey', $p_id)):the_row();
                            $dateS =  explode('-', get_sub_field('new_start_dateend_date'));
                            $arr_dateS[] = $dateS;
                            endwhile;
                            echo "1 ";
                           var_dump($arr_dateS); // 
                        }else{
                        if(have_rows('small_group_journey', $pid)){?> 
                        <?php 
                          $arr_dateS = array();
                            while (have_rows('small_group_journey', $pid)):the_row();
                            $dateS =  explode('-', get_sub_field('start_date/end_date'));
                            $arr_dateS[] = $dateS;
                            endwhile;
                           var_dump($arr_dates); // 
                        }
                    }?> 
            </div>

            <?php if (have_rows('small_group_journey', $pid) || have_rows('group_size_info', $pid)) { ?>
                <li class="tab-pane <?php echo $tab_small; ?>" id="small-group">
                    <?php
                    //small journey
                    $journey = getJourney('small_group', $pid);
                    echo $journey->small_group;
                    ?>
                <?php if (have_rows('small_group_journey', $pid)) { ?>
                <div class="available-dates clearfix">
                    <table border=0 cellspacing=2 cellpadding=2 style="display: none;">
                        <form method="post" action="#tab-dates">
                            <tr>
                                <td><span>Check Availabile Dates:</span></td>
                                <?php
                                $current_year = date("Y");
                                $next_year = date('Y', strtotime('+1 year'));
                                ?>
                                <td>
                                    <select class="search-trip" name="yr" id="yr">
                                        <option value="0">Select Year</option>

                                    <?php 
                                    $end_year = end($arr_dateS);
                                    $end_yr = $end_year['0'];
                                    $nyear = date('Y', strtotime($end_yr));
                                    //var_dump($nyear);
                                    $current_years = date("Y");
                                    $diff_yr = $nyear - $current_years;
                                    //var_dump($diff_yr);
                                    for($i=0;$i<=$diff_yr;$i++){
                                    echo $current_years+$i;?>
                                    <option value="<?php echo $current_years+$i; ?>" <?php if (isset($_POST['yr']) && $_POST['yr'] == $current_years+$i) { ?> selected="selected" <?php } ?> selected="selected"><?php echo $current_years+$i; ?></option>
                                    <?php }?>
                                        <!-- <option
                                            value="<?php echo $current_year; ?>" <?php if (isset($_POST['yr']) && $_POST['yr'] == $current_year) { ?> selected="selected" <?php } ?> selected="selected"><?php echo $current_year; ?></option>
                                        <option
                                            value="<?php echo $next_year; ?>" <?php if (isset($_POST['yr']) && $_POST['yr'] == $next_year) { ?> selected="selected" <?php } ?>><?php echo $next_year; ?></option>
                                            <option
                                            value="<?php echo $next_two_year; ?>" <?php if (isset($_POST['yr']) && $_POST['yr'] == $next_two_year) { ?> selected="selected" <?php } ?>><?php echo $next_two_year; ?></option> -->
                                    </select>&nbsp;
                                    <select class="search-trip" id="mnth" name="mnth"> <!-- onchange="this.form.submit()"-->
                                        <option value="0">Select Month</option>
                                        <?php
                                        $months = selectMonthId();
                                        foreach ($months as $month => $val) {
                                            ?>

                                            <option
                                                value="<?php echo $val; ?>" <?php if (isset($_POST['mnth']) && $_POST['mnth'] == $val) { ?> selected="selected" <?php } ?>><?php echo $month; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>&nbsp;
                                    <!-- <input type="submit" value="Filter" name="sub_date" class="btn btn-secondary"> -->
                                </td>
                            </tr>
                        </form>
                    </table>
                    <?php //echo do_shortcode('[gravityform id="5" title="false" description="false" ajax="true"]');  ?>
                    <script type="text/javascript">
                        $('#mnth').add('#yr').change(function(event) {
                            $('#update').html('<span><img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" style="margin-top:50px; margin-left:100px;">Loading...</span>');
                                $.post('<?php echo get_template_directory_uri(); ?>/template-parts/tab-trip-detail/tab-date-search.php', {
                                        mn: $("#mnth").val(),
                                        yr: $("#yr").val(),
                                        pid: <?php echo $pid; ?> ,
                                        title: "<?php the_title(); ?>" },
                                    function (data) {
                                        //console.log(data);
                                        $('#update').html(data);
                                    }
                                );
                        }); 
                    </script>
                </div>
                <?php } ?>

                    <?php if( have_rows('group_discount') ): ?>
                        <div class="clearfix discount-list-wrap<?php if (have_rows('small_group_journey', $pid)) { echo ' hide-list'; } ?>">
                            <h3 class="group-discount">See Group Discount</h3>
                            <div class="discount-list">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>No. of people</th>
                                        <th>Price per person</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while( have_rows('group_discount') ): the_row();
                                        $group_range = get_sub_field('group_range');
                                        $group_price = get_sub_field('group_price'); ?>
                                        <tr>
                                            <td><?php echo $group_range; ?></td>
                                            <td><?php echo 'USD '.number_format($group_price); ?></td>
                                        </tr>
                                    <?php endwhile; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (have_rows('small_group_journey', $pid)) {   ?>
                     <!--new sm search ajax-->
                            <div class="search-ajax-wrp">
                                <div class="search-ajax-title">Check Availabile Dates:</div>
                                <div class="search-ajax-year">
                                    <select id="search-ajax-year">
                                        <option value="yearlist0">Select Year</option>
                                        <option value="yearlist2018">2018</option>
                                        <option value="yearlist2019">2019</option>
                                        <option value="yearlist2020">2020</option>
                                        <option value="yearlist2021">2021</option>
                                    </select>
                                </div>
                                <div class="search-ajax-month">
                                     <select id="search-ajax-month">
                                     <option value="monthlist0">Select Month</option>
                                      <option value="monthlist1">Jan</option>
                                      <option value="monthlist2">Feb</option>
                                      <option value="monthlist3">Mar</option>
                                      <option value="monthlist4">Apr</option>
                                      <option value="monthlist5">May</option>
                                      <option value="monthlist6">Jun</option>
                                      <option value="monthlist7">Jul</option>
                                      <option value="monthlist8">Aug</option>
                                      <option value="monthlist9">Sep</option>
                                      <option value="monthlist10">Oct</option>
                                      <option value="monthlist11">Nov</option>
                                      <option value="monthlist12">Dec</option>
                                    </select>
                                </div>
                            </div>
                            <!--/new sm search ajax-->

                        <div id="custom-scroller">
                            <div class="date-list">
                        <?php if (have_rows('new_small_group_journey', $p_id)) { ?>
                            <!-- new -->
                            <!--new query from trip date post type-->

                            <table id="booking-dates" class="tablesorter table table-hover" >
                                <thead>
                                <tr class="active">
                                    <th>Date (Start - End)</th>
                                    <th>Price (Per Person)</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="update">
                                <?php
                                $today = strtotime(date('Y-m-d'));
                                $universalDiscount = get_field('discount_percentage');
                                //var_dump($universalDiscount);
                                $mnth_check = returnMethod('post', 'mnth');
                                //if (!isset($mnth_check)) {
                                if (have_rows('new_small_group_journey', $p_id)):
                                    while (have_rows('new_small_group_journey', $p_id)):the_row();
                                        if (!empty(get_sub_field('new_start_dateend_date'))) {
                                            $dis_per = get_sub_field('new_discount');
                                            $dateS = explode('-', get_sub_field('new_start_dateend_date'));
                                            //replaced date('Y') by 2020
                                            $data_arr = array('2018','2019','2020','2021','2022');
                                            foreach($data_arr as $data_array){
                                                if (strstr(get_sub_field('new_start_dateend_date'), $data_array)) {
                                                    $str = explode("/",$dateS[0]);
                                                    $yearlist = $str[count($str)-1];
                                                    $monthlist = $str[count($str)-3];
                                                    if (strtotime($dateS[0]) >= $today) {
                                                    $cost = get_sub_field("new_price");
                                                    $journey_status = get_sub_field("new_status");
                                                    //var_dump($journey_status);
                                                    ?>


                                                    <tr class="yearlist<?php echo $yearlist;?> monthlist<?php echo (int)$monthlist;?> ">
                                                        <td><?php echo date('D, j M ', strtotime($dateS[0])); //? date('F j, Y', get_sub_field('start_date') ) : ''; //$sdate->format('F j, Y'); ?> - <?php echo date('D, j M ', strtotime($dateS[1])); //? date('F j, Y', get_sub_field('end_date') ) : ''; ?></td>

                                                        <?php  if ($dis_per != '' &&  $dis_per != 0)  {
                                                            $dprice = $cost - ($dis_per / 100) * $cost;

                                                            ?>
                                                            <td><span
                                                                    class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                                <small><?php
                                                                    echo $dis_per;
                                                                    ?>% off &nbsp;</small>
                                                                $<?php
                                                                echo number_format($dprice);
                                                                ?>
                                                            </td>
                                                        <?php }
                                                        else if ($dis_per == '' ||  $dis_per == 0) {
                                                            if( $universalDiscount != '' && $universalDiscount != 0 ) {
                                                                $udprice = $cost - ($universalDiscount / 100) * $cost;
                                                                ?>
                                                                <td><span
                                                                        class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                                    <small><?php
                                                                        echo $universalDiscount;
                                                                        ?>% off &nbsp;</small>
                                                                    USD <?php
                                                                    echo number_format($udprice);
                                                                    ?>
                                                                </td>
                                                            <?php } else { ?> <td>USD <?php echo number_format($cost); ?></td> <?php } } else { ?>
                                                            <td>USD <?php echo number_format($cost); ?></td>
                                                        <?php } ?>
                                                        <td class="<?php if ($journey_status == 'guaranteed') {
                                                            echo 'guaranteed';
                                                        } elseif ($journey_status == 'limited') {
                                                            echo 'limited';
                                                        } elseif ($journey_status == 'closed') {
                                                            echo 'closed';
                                                        } ?>" <?php if ($journey_status == 'guaranteed') { ?>
                                                            style="color: #43894e; text-transform: capitalize;"
                                                        <?php } elseif ($journey_status == 'limited') { ?>
                                                            style="color: #c09853; text-transform: capitalize;"
                                                        <?php } elseif ($journey_status == 'closed') { ?>
                                                            style="color: #b94a48; text-transform: capitalize;"
                                                        <?php } ?>><?php //the_sub_field("new_status"); ?>
                                                            <?php if ($journey_status == 'closed') { ?>
                                                                <!-- <div class="closed">This date is available and open for
                                                                    bookings.
                                                                    This
                                                                    trip
                                                                    is guaranteed to depart. Go for it!
                                                                </div> -->

                                                            <?php } elseif ($journey_status == 'guaranteed') { ?>
                                                                <!-- <div class="guaranteed">This date is available and open
                                                                    for
                                                                    bookings.
                                                                    This
                                                                    trip is guaranteed to depart. Go for it!
                                                                </div> -->
                                                            <?php } elseif ($journey_status == 'limited') { ?>
                                                                <!-- <div class="limited">This date is available and open for
                                                                    bookings.
                                                                    This
                                                                    trip is guaranteed to depart. Go for it!
                                                                </div> -->
                                                                <?php
                                                            } ?>

                                                            <?php if($journey_status =="guaranteed"){ ?>
                                                            <!--Do redirect to booking-->
                                                            <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                                                <input type="hidden" name="slug-name"
                                                                       value="<?php the_title(); ?>">
                                                                <input type="hidden" name="post_id" value="<?php echo $pid;?>">
                                                                <input type="hidden" name="bookSlug" value="bookSlug">
                                                                <input type="hidden" name="start_date"
                                                                       value="<?php echo date(' F j, Y ', strtotime($dateS[0])); ?>">
                                                                <input type="hidden" name="end_date"
                                                                       value="<?php echo date(' F j, Y ', strtotime($dateS[1])); ?>">
                                                                <input type="submit" class="btn btn-secondary"
                                                                       value="BOOK NOW"/>
                                                            </form>
                                                            <?php } ?>
                                                            <?php if($journey_status =="limited"){ ?>
                                                            <!--Do popoup enquiry-->
                                                            <a href="#enquiry-popup-form" class="fancybox btn btn-secondary btn-inquire enq-with-date">INQUIRE NOW</a>
                                                            <?php } ?>
                                                            <?php if($journey_status =="closed"){ ?>
                                                            <!--Do nothing-->
                                                            <form >
                                                                <input type="submit" class="btn btn-secondary btn-close"
                                                                       value="CLOSED" disabled/>
                                                            </form>
                                                            <?php } ?>

                                                        </td>

                                                    </tr>
                                                    <?php
                                                    }
                                                }
                                            }

                                        }
                                    endwhile;
                                endif;
                                //}
                                //if (isset($mnth_check)) {
                                //require(dirname(__FILE__) . '/tab-dates-search.php');
                                //}

                                ?>
                                </tbody>

                            </table>

                        <?php }else{ ?>
                            <!-- ori -->
                            <table id="booking-dates" class="tablesorter table table-hover">
                                <thead>
                                <tr class="active">
                                    <th>Date (Start - End)</th>
                                    <th>Price (Per Person)</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody id="update">
                                <?php
                                $today = strtotime(date('Y-m-d'));
                                $universalDiscount = get_field('discount_percentage');
                                $mnth_check = returnMethod('post', 'mnth');

                                //if (!isset($mnth_check)) {
                                if (have_rows('small_group_journey', $pid)):
                                    while (have_rows('small_group_journey', $pid)):the_row();
                                        if (!empty(get_sub_field('start_date/end_date'))) {
                                            $dis_per = get_sub_field('journey_discount');
                                            $dateS = explode('-', get_sub_field('start_date/end_date'));
                                            $data_arr = array('2018','2019','2020','2021','2022');
                                            foreach($data_arr as $data_array){
                                                if (strstr(get_sub_field('start_date/end_date'), $data_array)) {
                                                    //var_dump($dateS[0]);
                                                    $str = explode("/",$dateS[0]);
                                                    $yearlist = $str[count($str)-1];
                                                    $monthlist = $str[count($str)-3];
                                                    //echo $yearlist;
                                                    //echo $monthlist;
                                                    if (strtotime($dateS[0]) >= $today) {
                                                    $cost = get_sub_field("journey_price");
                                                    $journey_status = get_sub_field("journey_status");
                                                    ?>

                                                    <tr class="yearlist<?php echo $yearlist;?> monthlist<?php echo (int)$monthlist;?> ">
                                                        <td><?php echo date('D, j M ', strtotime($dateS[0])); //? date('F j, Y', get_sub_field('start_date') ) : ''; //$sdate->format('F j, Y'); ?> - <?php echo date('D, j M ', strtotime($dateS[1])); //? date('F j, Y', get_sub_field('end_date') ) : ''; ?></td>

                                                        <?php  if ($dis_per != '' &&  $dis_per != 0)  {
                                                            $dprice = $cost - ($dis_per / 100) * $cost;

                                                            ?>
                                                            <td><span
                                                                    class="initial-cost">$<?php echo number_format($cost); ?></span>
                                                                <small><?php
                                                                    echo $dis_per;
                                                                    ?>% off &nbsp;</small>
                                                                USD <?php
                                                                echo number_format($dprice);
                                                                ?>
                                                            </td>
                                                        <?php }
                                                        else if ($dis_per == '' ||  $dis_per == 0) {
                                                            if( $universalDiscount != '' && $universalDiscount != 0 ) {
                                                                $udprice = $cost - ($universalDiscount / 100) * $cost;
                                                                ?>
                                                                <td><span
                                                                        class="initial-cost">USD <?php echo number_format($cost); ?></span>
                                                                    <small><?php
                                                                        echo $universalDiscount;
                                                                        ?>% off &nbsp;</small>
                                                                    USD <?php
                                                                    echo number_format($udprice);
                                                                    ?>
                                                                </td>
                                                            <?php } else { ?> <td>USD <?php echo number_format($cost); ?></td> <?php } } else { ?>
                                                            <td>USD <?php echo number_format($cost); ?></td>
                                                        <?php } ?>
                                                        <td class="<?php if ($journey_status == 'guaranteed') {
                                                            echo 'guaranteed';
                                                        } elseif ($journey_status == 'limited') {
                                                            echo 'limited';
                                                        } elseif ($journey_status == 'closed') {
                                                            echo 'closed';
                                                        } ?>" <?php if ($journey_status == 'guaranteed') { ?>
                                                            style="color: #43894e; text-transform: capitalize;"
                                                        <?php } elseif ($journey_status == 'limited') { ?>
                                                            style="color: #c09853; text-transform: capitalize;"
                                                        <?php } elseif ($journey_status == 'closed') { ?>
                                                            style="color: #b94a48; text-transform: capitalize;"
                                                        <?php } ?>><?php //the_sub_field("journey_status"); ?>
                                                            <?php if ($journey_status == 'closed') { ?>
                                                                <!-- <div class="closed">This date is available and open for
                                                                    bookings.
                                                                    This
                                                                    trip
                                                                    is guaranteed to depart. Go for it!
                                                                </div> -->

                                                            <?php } elseif ($journey_status == 'guaranteed') { ?>
                                                               <!--  <div class="guaranteed">This date is available and open
                                                                    for
                                                                    bookings.
                                                                    This
                                                                    trip is guaranteed to depart. Go for it!
                                                                </div> -->
                                                            <?php } elseif ($journey_status == 'limited') { ?>
                                                                <!-- <div class="limited">This date is available and open for
                                                                    bookings.
                                                                    This
                                                                    trip is guaranteed to depart. Go for it!
                                                                </div> -->
                                                                <?php
                                                            } ?>

                                                            <?php if($journey_status =="guaranteed"){ ?>
                                                            <!--Do redirect to booking-->
                                                            <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                                                <input type="hidden" name="slug-name"
                                                                       value="<?php the_title(); ?>">
                                                                <input type="hidden" name="post_id" value="<?php echo $pid;?>">
                                                                <input type="hidden" name="bookSlug" value="bookSlug">
                                                                <input type="hidden" name="start_date"
                                                                       value="<?php echo date(' F j, Y ', strtotime($dateS[0])); ?>">
                                                                <input type="hidden" name="end_date"
                                                                       value="<?php echo date(' F j, Y ', strtotime($dateS[1])); ?>">
                                                                <input type="submit" class="btn btn-secondary"
                                                                       value="BOOK NOW"/>
                                                            </form>
                                                            <?php } ?>
                                                            <?php if($journey_status =="limited"){ ?>
                                                            <!--Do popoup enquiry-->
                                                            <a href="#enquiry-popup-form" class="fancybox btn btn-secondary btn-inquire enq-with-date">INQUIRE NOW</a>
                                                            <?php } ?>
                                                            <?php if($journey_status =="closed"){ ?>
                                                            <!--Do nothing-->
                                                            <form >
                                                                <input type="submit" class="btn btn-secondary btn-close"
                                                                       value="CLOSED" disabled/>
                                                            </form>
                                                            <?php } ?>


                                                        </td>

                                                    </tr>
                                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    endwhile;
                                endif;
                                //}
                                //if (isset($mnth_check)) {
                                //    require(dirname(__FILE__) . '/tab-dates-search.php');
                                // }

                                ?>
                                </tbody>

                            </table>
                        <?php } ?>
                        </div>
                    </div><!-- .custom-scroller -->
                    <?php } ?>




            </li>
            <?php } ?>
            <li class="tab-pane <?php echo $tab_private; ?>" id="private-journey">
                <?php
                $list_date = array();
                $journey = getJourney('private_journey', $pid);
                echo $journey->private_journey;
                $trip_title = get_the_title(get_the_ID());
                ?>
                <?php echo do_shortcode('[gravityform id="3" title="false" description="false" ajax="true" tabindex="79" field_values="trip_name='.$trip_title.'"]'); ?>
            </li>
            <li class="tab-pane <?php echo $tab_tailor; ?>" id="tailor-made">
                <?php
                $journey = getJourney('tailor_made_journey', $pid);
                echo $journey->tailor_made_journey;
                ?>
                <?php echo do_shortcode('[gravityform id="4" title="false" description="false" ajax="true" tabindex="69" field_values="trip_name='.$trip_title.'"]'); ?>
            </li>

        </ul>
    </section>

</div>
<script>


//new js for default date in dropdown search
jQuery(document).ready(function(){
    var first_yr = jQuery('.search-trip option').eq(1).val();
    jQuery('.sbSelector').first().html(first_yr);

    //add month title div

    //loop the condition for year,monthlist
    for(var i=1;i<13;i++){
        var month = new Array();
        month[1] = "Jan";
        month[2] = "Feb";
        month[3] = "Mar";
        month[4] = "Apr";
        month[5] = "May";
        month[6] = "Jun";
        month[7] = "Jul";
        month[8] = "Aug";
        month[9] = "Sep";
        month[10] = "Oct";
        month[11] = "Nov";
        month[12] = "Dec";
        //for(var j=2017;j<2022;j++){
            $('.yearlist2017.monthlist'+i).first().before('<tr class="grp-list"><td>'+month[i]+', 2017</td><td></td><td></td></tr>');
            // $('.yearlist2018 .monthlist'+i).first().before('<tr class="grp-list"><td>'+month[i]+',2017</td></tr>'); 
            // $('.yearlist2019 .monthlist'+i).first().before('<tr class="grp-list"><td>'+month[i]+',2017</td></tr>'); 
            // $('.yearlist2020 .monthlist'+i).first().before('<tr class="grp-list"><td>'+month[i]+',2017</td></tr>'); 
        //}
    }
    for(var i=1;i<13;i++){
        var month = new Array();
        month[1] = "Jan";
        month[2] = "Feb";
        month[3] = "Mar";
        month[4] = "Apr";
        month[5] = "May";
        month[6] = "Jun";
        month[7] = "Jul";
        month[8] = "Aug";
        month[9] = "Sep";
        month[10] = "Oct";
        month[11] = "Nov";
        month[12] = "Dec";
        $('.yearlist2018.monthlist'+i).first().before('<tr class="grp-list y2018-'+[i]+'"><td>'+month[i]+', 2018</td><td></td><td></td></tr>');
    }
    for(var i=1;i<13;i++){
        var month = new Array();
        month[1] = "Jan";
        month[2] = "Feb";
        month[3] = "Mar";
        month[4] = "Apr";
        month[5] = "May";
        month[6] = "Jun";
        month[7] = "Jul";
        month[8] = "Aug";
        month[9] = "Sep";
        month[10] = "Oct";
        month[11] = "Nov";
        month[12] = "Dec";
        $('.yearlist2019.monthlist'+i).first().before('<tr class="grp-list y2019-'+[i]+'"><td>'+month[i]+', 2019</td><td></td><td></td></tr>');
    }
    for(var i=1;i<13;i++){
        var month = new Array();
        month[1] = "Jan";
        month[2] = "Feb";
        month[3] = "Mar";
        month[4] = "Apr";
        month[5] = "May";
        month[6] = "Jun";
        month[7] = "Jul";
        month[8] = "Aug";
        month[9] = "Sep";
        month[10] = "Oct";
        month[11] = "Nov";
        month[12] = "Dec";
        $('.yearlist2020.monthlist'+i).first().before('<tr class="grp-list y2020-'+[i]+'"><td>'+month[i]+', 2020</td><td></td><td></td></tr>');
    }
    for(var i=1;i<13;i++){
        var month = new Array();
        month[1] = "Jan";
        month[2] = "Feb";
        month[3] = "Mar";
        month[4] = "Apr";
        month[5] = "May";
        month[6] = "Jun";
        month[7] = "Jul";
        month[8] = "Aug";
        month[9] = "Sep";
        month[10] = "Oct";
        month[11] = "Nov";
        month[12] = "Dec";
        $('.yearlist2021.monthlist'+i).first().before('<tr class="grp-list y2021-'+[i]+'"><td>'+month[i]+', 2021</td><td></td><td></td></tr>');
    }


    //new sm logic for searching by drop down

    //hide all tr with data/year
    //$('#booking-dates tbody tr').hide();

    //Choose the current year by default
    var yr = new Date();
    var cur_yr = $("#search-ajax-year option:contains("+yr.getFullYear()+")");
    cur_yr.attr('selected',true);

    //get the last year and remove form select dropdown
    //debugger;
    if($('.grp-list').length>0){
        var lastdate = $('.grp-list').last().attr('class').split(' ');
        var lastdat = lastdate['1'];
        var date_option = $('#search-ajax-year option');
        date_option.each(function(index){
            console.log($(this).html());
            if($(this).html() > lastdat.substring(1, 5)){
                $(this).hide();
            }
        });
    }
    //show in change in dropdown
    $('.search-ajax-wrp').change(function(){
        var  select_yr = $('#search-ajax-year').val();
        var  select_mn = $('#search-ajax-month').val();
       
        //debugger;
        $('#booking-dates').append('<div class="overlay-table"><div class="searching">Searching <div class="lds-facebook"><div></div><div></div><div></div></div></div></div>');
        $('#booking-dates tbody tr').css('display','none');
        if(select_mn !== "monthlist0"){
            $('.'+select_yr+'.'+select_mn).css('display','table-row');
            $('.y'+select_yr.replace('yearlist','')+'-'+select_mn.replace('monthlist','')).css('display','table-row');
            $('.overlay-table,.no-record-table').delay('3000').fadeOut();
            if($('.'+select_yr+'.'+select_mn).length==0){
                $('#booking-dates').delay('3000').append('<tr class="no-record-table"><td>No record found.</td><td></td><td></td></div>');
            }
        }else{
            $('.'+select_yr).css('display','table-row');
            for(j=1;j<=12;j++){
                $('.y'+select_yr.replace('yearlist','')+'-'+j).css('display','table-row');
            }
            $('.overlay-table,.no-record-table').delay('3000').fadeOut();
            if($('.'+select_yr).length==0){
                $('#booking-dates').delay('3000').append('<tr class="no-record-table"><td>No record found.</td><td></td><td></td></div>');
            }
        }
       
    });
}); 
</script>
