<?php

require("../../../../../wp-config.php");
$year = $_POST['yr'];
$mnth = $_POST['mn'];
$pid = $_POST['pid'];
$today = strtotime(date('Y-m-d'));

$post_id = $_POST['pid']; //specify post id here
$post = get_post($post_id); 
$slug = $post->post_name;
echo $slug;

if( ($mnth == 0) && ($year == 0) ) {
    $search_by = '';
} else {
    if ($mnth == 0) {
        $search_by = $year;
    } else if ($year == 0) {
        $search_by = $mnth;
    }
    else {
        $search_by = $year . $mnth;
    }
}
$count = 0;

//new date search queries 

//check slugs and ids for new date posts 
$args = array(
        'post_type' => 'tripdates',
         'name' =>$slug,
        );
    $trip_posts = array();
    $loop = new WP_Query($args);
    while($loop->have_posts()): $loop->the_post();
       $p_id = get_the_ID();
     wp_reset_postdata();
    endwhile;
    //new date ajax search queries start
    if($p_id){
        if (have_rows('new_small_group_journey', $p_id)):
            while (have_rows('new_small_group_journey', $p_id)):the_row();
         
                $dateS =  explode('-', get_sub_field('new_start_dateend_date'));
                //echo $dateS;
                if( ($mnth == 0) && ($year == 0) ) {
                    $new_Date = '';
                } else {
                    if ($mnth == 0) {
                        $new_Date = substr($dateS[0], 6, 4);
                    } else if ($year == 0) {
                        $new_Date = substr($dateS[0], 0, 2);
                    } else {
                        //                    if($search_by != 0) {
                        $new_Date = substr($dateS[0], 6, 4) . substr($dateS[0], 0, 2);
                        //                    } else {
                        //                        $new_Date = 0;
                        //                    }
                    }
                }

                if ($search_by == $new_Date) {
                    $dis_per = get_sub_field('new_discount');
                    $universalDiscount = get_field('discount_percentage', $pid);
                    //$universalDiscount = get_field('new_percentage', $p_id);
                    $cost = get_sub_field("new_price");
                    $journey_status = get_sub_field("new_status");
                    //echo $journey_status;
                    $count++;
                    if (strtotime($dateS[0]) >= $today) {
                        ?>
                        <tr>
                            <td><?php echo date('F j, Y', strtotime($dateS[0])); // ? date('F j, Y', get_sub_field('start_date') ) : ''; //$sdate->format('F j, Y'); ?></td>
                            <td><?php echo date('F j, Y', strtotime($dateS[1])); //? date('F j, Y', get_sub_field('end_date') ) : ''; ?></td>
                            <?php  if ($dis_per != '' &&  $dis_per != 0)  {
                                $dprice = $cost - ($dis_per / 100) * $cost;
                                ?>
                                <td><span
                                        class="initial-cost">US $<?php echo $cost; ?></span>
                                    <small><?php
                                        echo $dis_per;
                                        ?>% off &nbsp;</small>
                                    US $<?php
                                    echo $dprice;
                                    ?>
                                </td>
                            <?php }
                            else if ($dis_per == '' ||  $dis_per == 0) {
                                if( $universalDiscount != '' && $universalDiscount != 0 ) {
                                    $udprice = $cost - ($universalDiscount / 100) * $cost;

                                    ?>
                                    <td><span
                                            class="initial-cost">US $<?php echo $cost; ?></span>
                                        <small><?php
                                            echo $universalDiscount;
                                            ?>% off &nbsp;</small>
                                        US $<?php
                                        echo $udprice;
                                        ?>
                                    </td>
                                <?php } else { ?> <td>US $<?php echo $cost; ?></td> <?php } } else { ?>
                                <td>US $<?php echo $cost; ?></td>
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
                            <?php } ?>><?php the_sub_field("new_status"); ?>
                                <?php if ($journey_status == 'closed') { ?>
                                    <div class="closed">This date is available and open for bookings.  This
                                        trip
                                        is guaranteed to depart. Go for it!
                                    </div>

                                <?php } elseif ($journey_status == 'guaranteed') { ?>
                                    <div class="guaranteed">This date is available and open for bookings.
                                        This
                                        trip is guaranteed to depart. Go for it!
                                    </div>
                                <?php } elseif ($journey_status == 'limited') { ?>
                                    <div class="limited">This date is available and open for bookings.  This
                                        trip is guaranteed to depart. Go for it!
                                    </div>
                                    <?php
                                } ?>
                            </td>
                            <td>
                                <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                    <input type="hidden" name="bookSlug" value="bookSlug">
                                     <input type="hidden" name="post_id" value="<?php echo $pid;?>">
                                    <input type="hidden" name="slug-name"
                                           value="<?php echo $_POST['title']; ?>">
                                    <input type="hidden" name="start_date" value="<?php echo date('F j Y', strtotime($dateS[0])); ?>">
                                    <input type="hidden" name="end_date" value="<?php echo date('F j Y', strtotime($dateS[1])); ?>">
                                    <input type="submit" class="btn btn-secondary"
                                           value="BOOK NOW"/>
                                </form>
                            </td>
                        </tr>
                        <?php
                    } else {
                        $count = 0;
                    }
                }
            endwhile;
        endif;
        //new date search queries end

        if($count == 0) {  echo "<tr><td colspan=4 style='color:#FF0000'>No records found</td></tr>"; }
    }else{
        //do old method of ajax queries
        if (have_rows('small_group_journey', $pid)):
            while (have_rows('small_group_journey', $pid)):the_row();

                $dateS =  explode('-', get_sub_field('start_date/end_date'));
                if( ($mnth == 0) && ($year == 0) ) {
                    $new_Date = '';
                } else {
                    if ($mnth == 0) {
                        $new_Date = substr($dateS[0], 6, 4);
                    } else if ($year == 0) {
                        $new_Date = substr($dateS[0], 0, 2);
                    } else {
                        //                    if($search_by != 0) {
                        $new_Date = substr($dateS[0], 6, 4) . substr($dateS[0], 0, 2);
                        //                    } else {
                        //                        $new_Date = 0;
                        //                    }
                    }
                }

                if ($search_by == $new_Date) {
                    $dis_per = get_sub_field('journey_discount');
                    $universalDiscount = get_field('discount_percentage', $pid);
                    $cost = get_sub_field("journey_price");
                    $journey_status = get_sub_field("journey_status");
                    $count++;
                    if (strtotime($dateS[0]) >= $today) {
                        ?>

                        <tr>
                            <td><?php echo date('F j, Y', strtotime($dateS[0])); // ? date('F j, Y', get_sub_field('start_date') ) : ''; //$sdate->format('F j, Y'); ?></td>
                            <td><?php echo date('F j, Y', strtotime($dateS[1])); //? date('F j, Y', get_sub_field('end_date') ) : ''; ?></td>
                            <?php  if ($dis_per != '' &&  $dis_per != 0)  {
                                $dprice = $cost - ($dis_per / 100) * $cost;
                                ?>
                                <td><span
                                        class="initial-cost">US $<?php echo $cost; ?></span>
                                    <small><?php
                                        echo $dis_per;
                                        ?>% off &nbsp;</small>
                                    US $<?php
                                    echo $dprice;
                                    ?>
                                </td>
                            <?php }
                            else if ($dis_per == '' ||  $dis_per == 0) {
                                if( $universalDiscount != '' && $universalDiscount != 0 ) {
                                    $udprice = $cost - ($universalDiscount / 100) * $cost;

                                    ?>
                                    <td><span
                                            class="initial-cost">US $<?php echo $cost; ?></span>
                                        <small><?php
                                            echo $universalDiscount;
                                            ?>% off &nbsp;</small>
                                        US $<?php
                                        echo $udprice;
                                        ?>
                                    </td>
                                <?php } else { ?> <td>US $<?php echo $cost; ?></td> <?php } } else { ?>
                                <td>US $<?php echo $cost; ?></td>
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
                            <?php } ?>><?php the_sub_field("journey_status"); ?>
                                <?php if ($journey_status == 'closed') { ?>
                                    <div class="closed">This date is available and open for bookings.  This
                                        trip
                                        is guaranteed to depart. Go for it!
                                    </div>

                                <?php } elseif ($journey_status == 'guaranteed') { ?>
                                    <div class="guaranteed">This date is available and open for bookings.
                                        This
                                        trip is guaranteed to depart. Go for it!
                                    </div>
                                <?php } elseif ($journey_status == 'limited') { ?>
                                    <div class="limited">This date is available and open for bookings.  This
                                        trip is guaranteed to depart. Go for it!
                                    </div>
                                    <?php
                                } ?>
                            </td>
                            <td>
                                <form method="post" action="<?php echo site_url(); ?>/booking-form">
                                    <input type="hidden" name="bookSlug" value="bookSlug">
                                     <input type="hidden" name="post_id" value="<?php echo $pid;?>">
                                    <input type="hidden" name="slug-name"
                                           value="<?php echo $_POST['title']; ?>">
                                    <input type="hidden" name="start_date" value="<?php echo date('F j Y', strtotime($dateS[0])); ?>">
                                    <input type="hidden" name="end_date" value="<?php echo date('F j Y', strtotime($dateS[1])); ?>">
                                    <input type="submit" class="btn btn-secondary"
                                           value="BOOK NOW"/>
                                </form>
                            </td>
                        </tr>
                        <?php
                    } else {
                        $count = 0;
                    }
                }
            endwhile;
        endif;
        if($count == 0) {  echo "<tr><td colspan=4 style='color:#FF0000'>No records found</td></tr>"; }

    }
?>