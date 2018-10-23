<?php
/**
* Template Name: Direct Payment proccess
*/
get_header();
//query url for booking id
$url = $_SERVER['QUERY_STRING'];
$url_arr = explode('bookingID=', $url);
$bookingId = $url_arr[1];
if($bookingId){
  $independent = GFAPI::get_entry( $bookingId );
    if($independent['form_id'] == 16){
        $independent_user_name = $independent['1'];
        $independent_trip_name = $independent['5'];
        $independent_trip_nationality = $independent['2'];
        $independent_trip_address = $independent['4'];
        $independent_trip_email = $independent['7'];
        $independent_trip_phone = $independent['3'];
        $independent_trip_calprice = $independent['6'];
    }
}
?>
<div class="container">
  <div class="row  contact-us">
    <div class="col-lg-12">
      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          the_content();
      ?>
      <div class=""  >
        <h1 class="page-heading"><?php //the_content();?></h1>
        <?php
        function random_invoice() {
          $number = "";
          for($i=0; $i<20; $i++) {
          $min = ($i == 0) ? 1:0;
          $number .= mt_rand($min,9);
          }
          return $number;
        }
        ?>
        <div class="payment-form form-container" style="display: none;">
          <Form method="post" action="https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment" id="process-form">
            <input type="text" id="paymentGatewayID" name="paymentGatewayID" value="9103332318" hidden>
            <input type="text" id="invoiceNo" name="invoiceNo" value="<?php echo random_invoice();?>" hidden>
            <input type="text" id="currencyCode" name="currencyCode" value="840" hidden>
            
            <div class="form-group">
              <label>Trip Name</label>
              <input type="text" id="productDesc" name="productDesc" value="<?php if(!empty($independent_trip_name)){ echo $independent_trip_name;}else{ echo "Trip";}?>" >
            </div>
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" id="fullname" name="userDefined1" value="<?php if(!empty($independent_user_name)){ echo $independent_user_name;}else{ echo "User Name";}?>" >
            </div>
            
            <div class="row">
              <div class="col-md-6 col-xm-12">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" id="paymentEmail" name="userDefined5" value="<?php if(!empty($independent_trip_email)){ echo $independent_trip_email;}else{ echo "Email";}?>" >
                </div>
              </div>
              <div class="col-md-6 col-xm-12">
                <div class="form-group">
                  <label>Booking ID</label>
                  <input type="text" id="paymentBookingId" name="userDefined3" value="<?php if(!empty($bookingId)){ echo $bookingId;}else{ echo "Booking ID";}?>" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-xm-12">
                <div class="form-group">
                  <label>Amount</label>
                  <input type="text" id="amount" name="amount" value="" placeholder="$<?php if($independent_trip_calprice){ echo $independent_trip_calprice;}?>" required>
                  
                </div>
              </div>
              <div class="col-md-6 col-xm-12">
                <div class="form-group">
                  <label>Nationality</label>
                  <input type="text" id="independent_trip_nationality" name="userDefined4" value="<?php if(!empty($independent_trip_nationality)){ echo $independent_trip_nationality;}else{ echo "Nationality";}?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Note</label>
                  <textarea class="form-control" id="paymentNote" name="userDefined2" value=""><?php if(!empty($paymentNote)){ echo $paymentNote;}else{ echo "Payment Note";}?></textarea>
                </div>
              </div>
            </div>
            
            <input type="text" id="nonSecure" name="nonSecure" value="N" hidden>
            <input type="text" id="hashValue" name="hashValue" value="<?php echo $hash_code;?>" hidden>
            <button type="submit" class="pay-button">Submit</button>
          </Form>
          
        </div>
      </div>
      <?php
        } // end while
      } // end if
      ?>
    </div>
  </div>
</div>

<script>
    jQuery('.payment-form  input[type=text]').blur(function()
    {
      if( !jQuery(this).val() ) {
        jQuery(this).next().show();
      }else{
        jQuery(this).next().hide();
      }
    });
    //change price formatt for HBL API
    function padDigits(number, digits) {
      return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
    }
    //add data in first input
    jQuery('.payment-form').ready(function(){
      var user_data = jQuery('#fullname').val()+'//'+jQuery('#paymentEmail').val()+'//'+jQuery('#paymentBookingId').val()+'//'+jQuery('#independent_trip_nationality').val()+'//'+jQuery('#productDesc').val();
      jQuery('#fullname').val(user_data);
      var user_price = '<?php echo $independent_trip_calprice;?>';
      var formatted_price = padDigits(user_price,10)+'00';
      jQuery('#amount').val(formatted_price);
      document.getElementById("process-form").submit();
    });

  </script>

<?php get_footer();?>