<?php
/**
 * Template Name: Payment success
 */
get_header();
?>
<?php 
 /**
  * 
  * query for return data from HBL
  * 
  */
        
        $bookingData = GFAPI::get_entry( $bookingId );
        $PaymentInformation_all = $_POST['userDefined1'];
        $data_part = explode("//", $PaymentInformation_all);
        $price_n = $_POST['Amount'];
        $price_c = ltrim($price_n, '0');
        $price = $price_c/100;
        $PaymentInformation_invoiceNo = $_POST['invoiceNo'];
        $PaymentInformation_name = $data_part['0'];
        $PaymentInformation_email = $data_part['1'];
        $PaymentInformation_bid = $data_part['2'];
        $PaymentInformation_date = $data_part['3'];
        $PaymentInformation_description = $data_part['4'];
        $PaymentInformation_paymentNote = $_POST['userDefined2'];
        //extra returned data  from HBL
        $PaymentInformation_dateTime = $_POST['dateTime'];
        $PaymentInformation_paymentGatewayID = $_POST['paymentGatewayID'];
        $PaymentInformation_respCode = $_POST['respCode'];
        $PaymentInformation_fraudCode = $_POST['fraudCode'];
        $PaymentInformation_Pan = $_POST['Pan'];
        $PaymentInformation_tranRef = $_POST['tranRef'];
        $PaymentInformation_approvalCode = $_POST['approvalCode'];
        $payment_value = array(
                                $price,
                                $PaymentInformation_invoiceNo,
                                $PaymentInformation_dateTime,
                                $PaymentInformation_paymentGatewayID,
                                $PaymentInformation_approvalCode,
                                $PaymentInformation_respCode,
                                $PaymentInformation_fraudCode,
                                $PaymentInformation_Pan,
                                $PaymentInformation_tranRef,
                                $PaymentInformation_paymentNote
                            );?>
                            <div style="display:none;"><?php //var_dump($_POST);?></div>
        <?php 
         //mail notification for online HBL payment
            function direct_bank_notification($success = "true"){

                //Posted Data
                $PaymentInformation_all = $_POST['userDefined1'];
                $data_part = explode("//", $PaymentInformation_all);
                $price_n = $_POST['Amount'];
                $price_c = ltrim($price_n, '0');
                $price = $price_c/100;
                $PaymentInformation_invoiceNo = $_POST['invoiceNo'];
                $PaymentInformation_name = $data_part['0'];
                $PaymentInformation_email = $data_part['1'];
                $PaymentInformation_bid = $data_part['2'];
                $PaymentInformation_date = $data_part['3'];
                $PaymentInformation_description = $data_part['4'];
                $PaymentInformation_paymentNote = $_POST['userDefined2'];
                //extra returned data  from HBL
                $PaymentInformation_dateTime = $_POST['dateTime'];
                $PaymentInformation_paymentGatewayID = $_POST['paymentGatewayID'];
                $PaymentInformation_respCode = $_POST['respCode'];
                $PaymentInformation_fraudCode = $_POST['fraudCode'];
                $PaymentInformation_Pan = $_POST['Pan'];
                $PaymentInformation_tranRef = $_POST['tranRef'];
                $PaymentInformation_approvalCode = $_POST['approvalCode'];
                    $to = 'info@acethehimalaya.com';
                    //$to = 'surya@lastdoorsolutions.com';
                    //$admin_email = get_option( 'admin_email' );
              
                if($success == "true"){
                    $subject = 'New online payment Successful';
                    $body = "Dear Admin,<br/><br/>
                    New payment has been succefully transferred. 
                    <br/><br/>
                    Here is your payment detail:<br/>
                    </hr>
                        <br/>Price: $".$price."
                        <br/>InvoiceNo : ".$PaymentInformation_invoiceNo."
                        <br/>DateTime: ".$PaymentInformation_dateTime."
                        <br/>PaymentGatewayID: ".$PaymentInformation_paymentGatewayID."
                        <br/>ApprovalCode: ".$PaymentInformation_approvalCode."
                        <br/>RespCode: ".$PaymentInformation_respCode."
                        <br/>FraudCode: ".$PaymentInformation_fraudCode."
                        <br/>Pan: ".$PaymentInformation_Pan."
                        <br/>TranRef: ".$PaymentInformation_tranRef."
                        <br/>paymentNote : ". $PaymentInformation_paymentNote."
                    </hr>
                    <br/> <br/>Please visit Dashboard to get more detail about trip booking with entry ID #".$PaymentInformation_bid."
                    <br/><br/>";
                }else{
                    $subject = 'New online payment Cancelled';
                    $body = "Dear Admin,<br/><br/>
                    New payment transaction has been cancelled. 
                    <br/><br/>
                    Here is  payment detail:<br/>
                    </hr>
                        <br/>Price: $".$price."
                        <br/>InvoiceNo : ".$PaymentInformation_invoiceNo."
                        <br/>DateTime: ".$PaymentInformation_dateTime."
                        <br/>PaymentGatewayID: ".$PaymentInformation_paymentGatewayID."
                        <br/>TranRef: ".$PaymentInformation_tranRef."
                    </hr>
                     Please visit Dashboard to get more detail about trip booking with entry ID #".$PaymentInformation_bid."
                    <br/><br/>";
                }
                $body .= 'Thank you';
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $admin_mail = wp_mail( $to, $subject, $body, $headers );
                if($admin_mail){
                    //echo '<h3>Mail notification has been sent.Thank you.</h3>';
                }else{
                    //echo '<h3>Mail notification failed.</h3>';
                }
            }
                
            //update in email notification
                if($PaymentInformation_approvalCode){

                    direct_bank_notification('true');
                    
                }else{
                    direct_bank_notification("false");
                }

                //save in booking entry in gravity form
                if($PaymentInformation_bid){
                    $option_name = 'hbl_payment_result_'.$PaymentInformation_bid ;
                    if ( get_option( $option_name ) !== false ) {
                        update_option( $option_name, $payment_value );
                    } else {
                        $deprecated = null;
                        $autoload = 'no';
                        add_option( $option_name, $payment_value, $deprecated, $autoload );
                    }
                }

 ?>

    <div class="container contact-us" style="">
        <div class="row">

                <div class="col-lg-12">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            ?>
                            <div class="header-block">
                                <h1 class="page-heading"><?php // PaymentInformation_respCode the_title(); ?> </h1>
                                <?php if($PaymentInformation_approvalCode){
                                    the_content();
                                }else{
                                    the_excerpt();
                                }?>
                            </div>
                            <?php
                        } // end while
                    } // end if
                    ?>
                </div>

           

        </div>
    </div>
<?php
get_footer();