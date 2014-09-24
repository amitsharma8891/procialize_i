<script src="<?php echo base_url(); ?>public/admin/js/jquery-1.10.2.min.js"></script>
<?php
//$redirectUrl = "";
//set_include_path(APPPATH . 'libraries/citrus_pg/lib/' . PATH_SEPARATOR . get_include_path());
//require_once(APPPATH . 'libraries/citrus_pg/lib/CitrusPay.php');
//CitrusPay::setApiKey("7fd40a748aea729eb2ab261cc39d5c64012f5671", 'sandbox');
//$response = Transaction::create($tarr, CitrusPay::getApiKey());
//$redirectUrl = $response->get_redirect_url();
////$response_code = $response->get_resp_code();
//if ($redirectUrl != "" && $response_code == 200) {
//    header("Location: $redirectUrl");
//}
?>
<?php
set_include_path(APPPATH . 'libraries/citrus_pg/lib/' . PATH_SEPARATOR . get_include_path());
require_once(APPPATH . 'libraries/citrus_pg/lib/CitrusPay.php');
require_once 'Zend/Crypt/Hmac.php';

function generateHmacKey($data, $apiKey = null) {
    $hmackey = Zend_Crypt_Hmac::compute($apiKey, "sha1", $data);
    return $hmackey;
}

$action = SITE_URL . "client/event/pay";
$flag = "";
CitrusPay::setApiKey("0b6d9ca1ea75ad568fe9612b9b42cfa7faa1371d", 'sandbox');
//display($payment);die;
//if (isset($_POST['submit'])) {
$vanityUrl = "mj0z8czjmr";
$currency = "INR";
$merchantTxnId = $payment['merchantTxnId']; //$_POST['merchantTxnId'];
$addressState = $payment['addressState'];
$addressCity = $payment['addressCity'];
$addressStreet1 = $payment['addressStreet1'];
$addressCountry = $payment['addressCountry'];
$addressZip = $payment['addressZip'];
$firstName = $payment['firstName'];
$lastName = $payment['lastName'];
$phoneNumber = $payment['phoneNumber'];
$email = $payment['email'];
$paymentMode = $payment['paymentMode'];
$issuerCode = $payment['issuerCode'];
$cardHolderName = $payment['cardHolderName'];
$cardNumber = $payment['cardNumber'];
$expiryMonth = $payment['expiryMonth'];
$cardType = $payment['cardType'];
$cvvNumber = $payment['cvvNumber'];
$expiryYear = $payment['expiryYear'];
$returnUrl = $payment['returnUrl'];
$notifyUrl = $payment['notifyUrl'];
$orderAmount = $payment['event_cost']; //$_POST['orderAmount'];
$flag = "post";
$data = "$vanityUrl$orderAmount$merchantTxnId$currency";
$secSignature = generateHmacKey($data, CitrusPay::getApiKey());
$action = CitrusPay::getCPBase() . "$vanityUrl";
$time = time() * 1000;
$time = number_format($time, 0, '.', '');
$templateCode = "MTT001";
$dpFlag = 'post';
/* $iscod = $_POST['COD']; */

/* $customParamsName = $_POST['customParamsName']; */
/* $customParamsValue = $_POST['customParamsValue']; */
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Event Transaction</title>
        <link href="css/default.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-color: rgb(238,238,238);"><!--style="background-color: rgb(238,238,238);"-->
        <div id="page-header">
            <div class="page-wrap">
                <div class="logo-wrapper">
                </div>
            </div>
        </div>

        <div id="page-client-logo">&#160;</div>
        <img src="<?php echo CLIENT_IMAGES . 'loaders/loader7.gif' ?>" id="loader_image" style=" position: fixed;top: 50%;left: 50%;display: none;"/>
        <div id="page-wrapper" style="display: none;">
            <div class="box-white">
                <div class="page-content">
                    <form action="<?php echo $action; ?>" method="POST" 	name="TransactionForm" id="transactionForm">

                        <?php
                        if ($flag == "post") {
                            ?>
                            <input name="merchantTxnId"
                                   type="text" value="<?php echo $merchantTxnId; ?>" />
                            <input name="addressState" type="text"
                                   value="<?php echo $addressState; ?>" />
                            <input name="addressCity" type="text"
                                   value="<?php echo $addressCity; ?>" />
                            <input name="addressStreet1"
                                   type="text" value="<?php echo $addressStreet1; ?>" />
                            <input name="addressCountry"
                                   type="text" value="<?php echo $addressCountry; ?>" />

                            <input name="addressZip" type="text"
                                   value="<?php echo $addressZip; ?>" />
                            <input name="firstName" type="text"
                                   value="<?php echo $firstName; ?>" />
                            <input name="lastName" type="text"
                                   value="<?php echo $lastName; ?>" />

                            <input name="phoneNumber" type="text"
                                   value="<?php echo $phoneNumber; ?>" />
                            <input name="email" type="text"
                                   value="<?php echo $email; ?>" />
                            <input name="paymentMode" type="text"
                                   value="<?php echo $paymentMode; ?>" />
                            <input name="issuerCode" type="text"
                                   value="<?php echo $issuerCode; ?>" />
                            <input name="cardHolderName"
                                   type="text" value="<?php echo $cardHolderName; ?>" />
                            <input name="cardNumber" type="text"
                                   value="<?php echo $cardNumber; ?>" />
                            <input name="expiryMonth" type="text"
                                   value="<?php echo $expiryMonth; ?>" />
                            <input name="cardType" type="text"
                                   value="<?php echo $cardType; ?>" />
                            <input name="cvvNumber" type="text"
                                   value="<?php echo $cvvNumber; ?>" />
                            <input name="expiryYear" type="text"
                                   value="<?php echo $expiryYear; ?>" />
                            <input name="returnUrl" type="text"
                                   value="<?php echo $returnUrl; ?>" /> <?php // echo $returnUrl;                                 ?>
                            <input name="notifyUrl" type="text"
                                   value="<?php echo $notifyUrl; ?>" />
                            <input name="orderAmount" type="text"
                                   value="<?php echo $orderAmount; ?>" />
                            <input name="templateCode" type="text"
                                   value="<?php echo $templateCode; ?>" />
                            <input type="text" name="reqtime" value="<?php echo $time; ?>" /> 
                            <input
                                type="hidden" name="secSignature"
                                value="<?php echo $secSignature; ?>" /> <input type="hidden"
                                name="currency" value="<?php echo $currency; ?>" />

                            <input type="text" class="text" name="dpFlag" value="<?php echo $dpFlag; ?>" />



                            <?php
                        } else {
                            ?>
                            <div>	
                                <ul class="form-wrapper add-merchant clearfix">
                                    <li class="clearfix"> <label width="125px;">Transaction Number:</label><input class="text" name="merchantTxnId"
                                                                                                                  type="text" value="" /></li>

                                    <li class="clearfix"> <label width="125px;">State:</label><input class="text" name="addressState" type="text"
                                                                                                     value="" /></li>

                                    <li class="clearfix"> <label width="125px;">City:</label><input class="text" name="addressCity" type="text"
                                                                                                    value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Address:</label><input class="text" name="addressStreet1"
                                                                                                       type="text" value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Country:</label><input class="text" name="addressCountry"
                                                                                                       type="text" value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Pin Code:</label><input class="text" name="addressZip" type="text"
                                                                                                        value="" /></li>

                                    <li class="clearfix"> <label width="125px;">First Name:</label><input class="text" name="firstName" type="text"
                                                                                                          value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Last Name:</label><input class="text" name="lastName" type="text" value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Mobile Number:</label><input class="text" name="phoneNumber" type="text"
                                                                                                             value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Email:</label><input class="text" name="email" type="text" value="" />
                                    </li>



                                    <!-- Custom parameter section starts here. 
                                    You can omit this section if no custom parameters have been defined.
                                    Hidden field value should be the name of the parameter created in Checkout settings page.
                                    An array of Custom Parameter's Name and Custom Parameters Value should be passed to the POST script.
                                    Please refer below code snippet for passing Custom parameters to the POST script Page.
                                    
                                    Once the parameters are passed through a text input field they are captured in the script mentioned 
                                    in the Action attribute of the Form
                                    -->
                                    <!-- <input type="hidden" name="customParamsName[]" value="Roll Number" />
                                    <p>
                                            Roll Number <input type="text" class="text" name="customParamsValue[]" value="" />
                                    </p>
                                    <input type="hidden" name="customParamsName[]" value="age" />
                                    <p>
                                            age <input type="text" class="text" name="customParamsValue[]" value="" />
                                    </p> -->


                                    <!-- COD section starts here 
                                    Uncomment the below cod section if COD to be sent from merchant site
                                    pass the values as 'Yes' or 'No'
                                    
                                    
                                    <li class="clearfix"><label width="125px;">Is COD:</label> 
                                            <select class="text" name="COD">
                                                    <option value="">Select...</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                            </select>
                                    </li>
                                    
                                    <!-- COD section END -->

                                    <li class="clearfix"> <label width="125px;">Payment Mode:</label><select class="text" name="paymentMode">
                                            <option value="">Select Payment Mode</option>
                                            <option value="NET_BANKING">NetBanking</option>
                                            <option value="CREDIT_CARD">Credit Card</option>
                                            <option value="DEBIT_CARD">Debit Card</option>
                                        </select>
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Issuer Code:</label><input class="text" name="issuerCode" type="text"
                                                                                                           value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Card Holder Name:</label><input class="text" name="cardHolderName"
                                                                                                                type="text" value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Card Number:</label><input class="text" name="cardNumber" type="text"
                                                                                                           value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Expiry Month:</label><input class="text" name="expiryMonth" type="text"
                                                                                                            value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Card Type:</label><input class="text" name="cardType" type="text" value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">CVV Number:</label><input class="text" name="cvvNumber" type="text"
                                                                                                          value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Expiry Year:</label><input class="text" name="expiryYear" type="text"
                                                                                                           value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Return Url:</label><input class="text" name="returnUrl" type="text"
                                                                                                          value="" /></li>

                                    <li class="clearfix"> <label width="125px;">Notify Url:</label><input class="text" name="notifyUrl" type="text"
                                                                                                          value="" /></li>


                                    <li class="clearfix"> <label width="125px;">Amount:</label><input class="text" name="orderAmount" type="text" value="" />
                                    </li>

                                    <li class="clearfix"> <label width="125px;">Dynamic pricing:</label>
                                        <input type="text" class="text" name="dpFlag" value="Yes" />
                                    </li>
                                </ul>
                                <input type="submit" name="submit" class="btn-orange" value="Test Transaction" /> <input
                                    type="reset" class="btn" name="reset" value="Cancel" />
                            </div>	
                            <?php
                        }
                        ?>
                    </form>
                </div>
                <div
                    style="padding-left: 700px; padding-bottom: 20px; padding-top: 20px;">
                </div>
            </div>
        </div>
        <!--<button type="button">Click Me!</button>--> 
        <button type="button" id="payment_form_button" name="pay" class="btn-orange" style="position: fixed;top: 50%;left: 50%;" value="Test Transaction" >Click here for payment</button>
        <?php
        if ($flag == "post") {
            ?>
            <script type="text/javascript">
                $("#payment_form_button").live('click', function() {
                    alert("dfg");
    //                    document.getElementById("transactionForm").submit();
                    $("#payment_form_button").hide();
                    $("#loader_image").show();
                });
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            $("#payment_form_button").click(function() {
                $("#payment_form_button").hide();
                $("#loader_image").show();
                $("#transactionForm").submit();
            });
        </script>
    </body>
</html>
