<?php
/**
 * Template Name: Trip Booking Form
 */
get_header();

?>
<?php if (has_post_thumbnail()) {
	$image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-mobile');
	$image_medium = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image-tab');
	$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'banner-image');
	?>
    <figure class="hero-image style1">
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
                 alt="<?php the_title();?>">
        </picture>
    </figure>
<?php }?>
        
    <div class="container booking-form">
        <div class="row">
            <div class="form-container">
                <?php if (is_page(4474)) {
                	$pid = $_POST['post_id'];
                	$trip_title = $_POST['slug-name'];
                	session_start();
                    if(empty($_SESSION['bookSlug'])):
                	   if (!isset($_SESSION['post_id']) || !isset($_SESSION['slug-name']) || isset($_SESSION['bookSlug'])):
                    		$_SESSION['post_id'] = $pid;
                            $_SESSION['slug-name'] = $trip_title;
                            $_SESSION['bookSlug'] = $_POST['bookSlug'];
                    		$_SESSION['group_trip'] = $_POST['group_trip'];
                    		/*$_SESSION['start_date'] = $start_date;
                            $_SESSION['end_date'] = $end_date;*/
                        endif;
                    endif; 
                    ?>

                <h1 class="border-btm">  
                    <?php
                      //var_dump($_SESSION);
                       /*if (isset($_POST['slug-name'])) {*/
                	//echo $trip_title;
                	echo $_SESSION['slug-name'];
                	//$trip_title = str_replace("&", "and", $_SESSION['slug-name']);
                	$trip_title = str_replace("&", "and", $_SESSION['slug-name']);
                	/*}*/

                     ?>
                </h1>

                <?php //var_dump($_SESSION['post_id']);
            	$cost = get_field("trip_cost", $_SESSION['post_id']);
            	$dis_per = get_field('discount_percentage', $_SESSION['post_id']);
            	if ($dis_per) {
            		$des_cost = $cost - ($dis_per / 100) * $cost;
            		$initial_price = number_format($des_cost);
            		$initial_price_u = $des_cost;
            	} else {
            		$initial_price = number_format($cost);
            		$initial_price_u = $cost;

            	}
            	//repeater field group discount price section
            	if (have_rows('group_discount', $_SESSION['post_id'])): ?>
                                  <div class="hide group-price-range">
                                    <?php while (have_rows('group_discount', $_SESSION['post_id'])): the_row();
            		$group_range = get_sub_field('group_range', $_SESSION['post_id']);
            		$group_price = get_sub_field('group_price', $_SESSION['post_id']);?>
            	                                <p><strong><?php echo $group_range; ?></strong><span><?php echo $group_price; ?></span></p>
            	                        <?php endwhile;?>
                                    </div>
                                <?php endif;?>
                                <?php
       
            	if (isset($_POST['bookSlug'])) {
            		echo do_shortcode('[gravityform id="2" title="false" description="true" ajax="false" field_values="trip_name=' . $trip_title . '&departure_date=' . $_POST['start_date'] . '-' . $_POST['end_date'] . '" tabindex="23" ]');
            	} elseif($_SESSION['bookSlug']) {
            		echo do_shortcode('[gravityform id="2" title="false" description="true" ajax="false" field_values="trip_name=' . $trip_title . '&departure_date=' . $_POST['start_date'] . '-' . $_POST['end_date'] . '" tabindex="23" ]');
            	}else{
                    echo do_shortcode('[gravityform id="13" title="false" description="true" ajax="false" field_values="trip_name=' . $trip_title . '" tabindex="23"]');
                }
            	?>
                <!--New logic for payment information in gravity form-->

                    <div class="button-process-booking">
                        <span class="gform_button btn button gravity-process-payment">Pay By Card</span>
                        <span class="gform_button btn button gravity-direct-bank">Bank Transfer</span>
                    </div>
                <!--End of New logic for payment information in gravity form-->
                <?php }
            if (is_page(4510)) {
            //page ace Inquire Form
                ?>
                    <span class="hint-text">Trip Inquire for</span>

                    <h1 class="border-btm">  <?php if (isset($_POST['slug-name'])) {
                    echo $trip_title = $_POST['slug-name'];
                    $trip_title = str_replace("&", "and", $_POST['slug-name']);
                    $trip_code = $_POST['trip-code'];
                    }?></h1>
                    <?php echo do_shortcode('[gravityform id="7" title="false" description="false" ajax="true" field_values="trip_name=' . $trip_title . '&trip_code=' . $trip_code . '" tabindex="23"]'); ?>
                <?php }?>
            </div>
        </div>
    </div>
    <style>
        .payment-method-select ,.booking-form .gform_footer input[type="submit"]{
    display: none;
}
    </style>
    <script>
        $(document).ready(function(){
        var initial_price = '<?php echo $initial_price_u; ?>';
        var initial_price_n = '<?php echo number_format($initial_price_u); ?>';
        var inital_price_dis = Math.round(initial_price*.3);
        $('.payment-method').after('<div class="cal-price"><strong>Your Total Payment: <p class="dollor-sign">USD </p></strong><span> '+inital_price_dis+'</span></div>');


        //check for group price
        var price_range = $('.group-price-range p');
        if(price_range.length != 0){

        //new logic for minium grp price
            var grp_range = price_range[0].children[0].innerText;
            var grp_range_initial = grp_range.split('-')[0];

            var all_range = $('.number-of-pax select option');
            //debugger;
            //remove extra option in number of pax
            //hide unwanted options
            if(grp_range_initial.length>0){
                for (var i = 1; i < grp_range_initial; i++) {
                  all_range[i].hidden = true;
                }
            }
                //hide 31 to 100 option in Pax
            if(all_range.length>32){
                for (var i = 31; i < 100; i++) {
                  all_range[i].hidden = true;
                }
            }
        }

        $(document).on('change','.number-of-pax select,.payment-method',function(){
                //debugger;
                var checked_payment_method = $('.payment-method input:checked').val();
                var pax = parseInt($('.number-of-pax select').val());

                //remove all append html
                $('.remainging-amount').remove();
                $('.enq').remove();
                if(pax>31){
                    
                    $('.number-of-pax').after("<div class='enq'>Maximum number of participant to choose is 30. We would request to enquiry for more discounts and information on the price for more than 30.<a href='#enquiry-popup-form' class='btn-enq fancybox enq-without-date btn btn-blue'><strong>INQUIRE NOW</strong></a></div>");
                }

                var initial_price= Math.round('<?php echo $initial_price_u; ?>');

                //check for group price
                var price_range = $('.group-price-range p');

                //calculation for grouped price
                if(price_range.length!=0){
                    var index;
                   
                    for (index = 0; index < price_range.length; ++index) {

                        console.log(price_range[index]);
                        var grp = price_range[index].children[0].innerText;
                        var group_min = grp.split('-')[0];
                        var group_max = grp.split('-')[1];

                       if(pax <= group_max && pax >= group_min){
                            var price_to_cal = price_range[index].children[1].innerText;
                            jQuery('#input_13_50').val(price_to_cal);
                              if(checked_payment_method=="100%"){
                                   var  f_price = price_to_cal*pax;
                                }else{
                                    var  f_price = Math.round((price_to_cal*.3)*pax);
                                }
                            stop();
                             //debugger;
                                 //remaining amount calculation 
                                if(checked_payment_method=="30%"){    
                                    $('.remainging-amount').remove();
                                    var i_price = price_to_cal;
                                    var r_price = Math.round((i_price)*pax);
                                    var fi_price = Math.round((i_price*.3)*pax);
                                    var remaining_amount = parseInt(r_price) - parseInt(fi_price);
                                    $('.cal-price').after('<p class="remainging-amount">Remaining Amount: USD <span>'+remaining_amount.toLocaleString()+'</span></p>');
                                     //remaining price input 
                                    $('.remaining-amount input').val(remaining_amount.toLocaleString());
                                }

                                //if 100% selected,remove remaining price value.
                                if(checked_payment_method=="100%"){ 
                                     $('.remainging-amount').remove();
                                      $('.remaining-amount input').val('0');
                                }
                       }
                    }

                }


                //calculation for flat discount
                 function calculatePrice(price,pax){
                    var final_price = Math.round(price)*parseInt(pax);
                    return final_price;
                }
                
                if(price_range.length == 0){
                    if(checked_payment_method=="100%"){
                        var price = '<?php echo $initial_price_u; ?>';
                    }else{
                        var price = '<?php echo $initial_price_u; ?>';
                        var price = Math.round(price*.3);
                    }
                    var f_price = calculatePrice(price,pax);
                   
                     //remaining amount calculation 
                    if(checked_payment_method=="30%"){    
                        $('.remainging-amount').remove();
                        var a_price = '<?php echo $initial_price_u; ?>';
                        var r_price = Math.round(a_price*.3*pax);
                        var fi_price =  calculatePrice(a_price,pax);
                        var remaining_amount = parseInt(fi_price) - parseInt(r_price);
                        $('.cal-price').after('<p class="remainging-amount">Remaining Amount: USD <span>'+remaining_amount.toLocaleString()+'</span></p>');
                         //remaining price input 
                        $('.remaining-amount input').val(remaining_amount.toLocaleString());
                    }
                    //if 100% selected,remove remaining price value.
                    if(checked_payment_method=="100%"){ 
                         $('.remainging-amount').remove();
                          $('.remaining-amount input').val('0');
                    }

                }

                //append price after calculation
                $('.cal-price span').html(' '+f_price.toLocaleString());
                $('#input_13_45').val(f_price);
                $('#input_2_43').val(f_price);



            });

        //add price per person
        //jQuery('.price-per-person').html('Price Per Person: <span class="price-per-color">US $'+initial_price+'</span>');
        jQuery('.price-per-person input').val(initial_price_n);

         //change the default value (participants) to 1 if not selected after changing 30% or 100%
         $('.payment-method').change(function(){
            if($('.number-of-pax select').val() == 0){
                $('.number-of-pax select').val('1');
            }
        });

         //hide pre-define date if its empty
         var check_group_trip = "<?php echo $_SESSION['group_trip'];?>";
         if(check_group_trip == "group_trip" ){
             if($('#input_13_46').val()== "" || $('#input_13_46').val()== null  ){
                //debugger;
                    $('#field_13_46,#field_13_40').hide();
                    $('#field_13_38').css('width','96%')
                }
        }

            //new wire & payment button  logic
            $(document).on('click','.gravity-process-payment,.gravity-direct-bank',function(){
                $('.payment-method-select input').val($(this).html());
                $('.booking-form .gform_footer input[type="submit"]').trigger('click');
            });

        });
    </script>
<?php
get_footer();