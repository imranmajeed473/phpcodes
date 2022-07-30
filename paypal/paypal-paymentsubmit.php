<?php 
/*  Template Name: HM- Payment Submit */ 
// Include Paypal Functions
require_once get_stylesheet_directory() . '/homeexchange/paypal-functions.php';

if(count($_POST)>0){
    foreach($_POST as $key=>$value){
      echo "$key=$value";
      $cqfdata[$key] = stripslashes($value);
    }
}

$returnurl = $paypalConfig['return_url']."&email='".$userEmail."'&userid='".$userID."'";

if( !isset($_GET['payments']) ):

?><!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function submitform() { document.forms["myformsubmitted"].submit(); } 
</script>
</head>
<body>
<form action="<?php echo $paypalUrl ?>" id="myformsubmitted" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $paypalConfig['email'] ?>" />
<input type="hidden" name="item_name" value="<?php echo $itemName ?>" />
<input type="hidden" name="item_number" value="<?php echo $itemNumber ?>" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="lc" value="US" />
<input type="hidden" name="amount" value="<?php echo $itemAmount ?>" />
<input type="hidden" name="return" value="<?php echo $returnurl ?>"/>
<input type="hidden" name="cancel_return" value="<?php echo $paypalConfig['cancel_url']?>" />
<input type="hidden" name="notify_url" value="<?php echo $paypalConfig['notify_url']?>" />
<input type="hidden" name="first_name" value="<?php echo $userFullName ?>" />
<input type="hidden" name="payer_email" value="<?php echo $userEmail ?>" />
<input type="hidden" name="address_country" value="<?php echo $userAddress ?>" />
<input type="hidden" name="custom" value="<?php echo $itemName ?>" />
<input type="hidden" name="no_shipping" value="0">
<input type="hidden" name="no_note" value="1">
<!-- <input type="submit" name="submitpayment" value="Submit" class="wpcf7-form-control wpcf7-submit"> -->
</form>

<script type="text/javascript"> submitform(); </script>
</body>
</html>
<?php 
endif;
?>