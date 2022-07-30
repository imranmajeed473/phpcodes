<?php
/*  Template Name: -Payment New1 */ 
// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// Database settings. Change these for your database configuration.
$dbConfig = [
	'host' => DB_HOST,
	'name' => DB_NAME,
	'username' => DB_USER,
	'password' => DB_PASSWORD,
	'hm_user' => 'hm_user',
	'hm_posts' => 'hm_posts',
];
// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
// $site_url = site_url();
$site_url = site_url( '/homeexchange/paymentnew/');
$paypalConfig = [
	'email' => 'sb-jsegq1113542@business.example.com',
	'return_url' => $site_url.'?payments=successful',
	'cancel_url' => $site_url.'?payments=cancelled',
	'notify_url' => $site_url.'?payments=notify'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Product being purchased.
$itemName = 'membership fee';
$itemAmount = '60';
// $itemNumber = 'userid'.$_SESSION["userid"];
// $userID = $_SESSION["userid"];
// $userEmail = $_SESSION["email"];
// $userFullName = $_SESSION["name"];
// $userFullName = $_SESSION["name"];
// $userAddress = $_SESSION["address"];


// Include Functions
//require 'functions.php';

// form
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"]) && !isset($_POST) ) {
?>
<form class="paypal" action="payments.php" method="post" id="paypal_form">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="lc" value="UK" />
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        <input type="hidden" name="first_name" value="Customer's First Name" />
        <input type="hidden" name="last_name" value="Customer's Last Name" />
        <input type="hidden" name="payer_email" value="customer@example.com" />
        <input type="hidden" name="item_number" value="123456" / >
        <input type="submit" name="submit" value="Submit Payment"/>
    </form>
<?php
}

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"]) && isset($_POST) ) {

	// Grab the post data so that we can set up the query string for PayPal.
	// Ideally we'd use a whitelist here to check nothing is being injected into
	// our post data.
	$data = [];
	foreach ($_POST as $key => $value) {
		$data[$key] = stripslashes($value);
	}

	// Set the PayPal account.
	$data['business'] = $paypalConfig['email'];

	// Set the PayPal return addresses.
	$data['return'] = stripslashes($paypalConfig['return_url']);
	$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
	$data['notify_url'] = stripslashes($paypalConfig['notify_url']);

	// Set the details about the product being purchased, including the amount
	// and currency so that these aren't overridden by the form data.
	$data['item_name'] = $itemName;
	$data['amount'] = $itemAmount;
	$data['currency_code'] = 'USD';

	// Add any custom fields for the query string.
	// $data['custom'] = USERID;

	// Build the query string from the data.
	$queryString = http_build_query($data);

	// Redirect to paypal IPN
	header('location:' . $paypalUrl . '?' . $queryString);
	exit();

}

if ( isset($_POST["txn_id"]) && isset($_POST["txn_type"]) ) {
	// Handle the PayPal response.

	// Create a connection to the database.
	$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

	// Assign posted variables to local data array.
	$data = [
		'item_name' => $_POST['item_name'],
		'item_number' => $_POST['item_number'],
		'payment_status' => $_POST['payment_status'],
		'payment_amount' => $_POST['mc_gross'],
		'payment_currency' => $_POST['mc_currency'],
		'txn_id' => $_POST['txn_id'],
		'receiver_email' => $_POST['receiver_email'],
		'payer_email' => $_POST['payer_email'],
		'custom' => $_POST['custom'],
	];

	// We need to verify the transaction comes from PayPal and check we've not
	// already processed the transaction before adding the payment to our
	// database.
	if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
		// if (addPayment($data) !== false) {
		// 	// Payment successfully added.
		// }
		if (addPaymentNew1($data) !== false) {
			// Payment successfully added.
		}
	}
}
?><?php

/**
 * Verify transaction is authentic
 *
 * @param array $data Post data from Paypal
 * @return bool True if the transaction is verified by PayPal
 * @throws Exception
 */
function verifyTransaction($data) {
	global $paypalUrl;

	$req = 'cmd=_notify-validate';
	foreach ($data as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
		$req .= "&$key=$value";
	}

	$ch = curl_init($paypalUrl);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSLVERSION, 6);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	$res = curl_exec($ch);

	if (!$res) {
		$errno = curl_errno($ch);
		$errstr = curl_error($ch);
		curl_close($ch);
		throw new Exception("cURL error: [$errno] $errstr");
	}

	$info = curl_getinfo($ch);

	// Check the http response
	$httpCode = $info['http_code'];
	if ($httpCode != 200) {
		throw new Exception("PayPal responded with http code $httpCode");
	}

	curl_close($ch);

	return $res === 'VERIFIED';
}

/**
 * Check we've not already processed a transaction
 *
 * @param string $txnid Transaction ID
 * @return bool True if the transaction ID has not been seen before, false if already processed
 */
function checkTxnid($txnid) {
	global $db;

	$txnid = $db->real_escape_string($txnid);
	$results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

	return ! $results->num_rows;
}

/**
 * Add payment to database
 *
 * @param array $data Payment data
 * @return int|bool ID of new payment or false if failed
 */
function addPayment($data) {
	global $db;

	if (is_array($data)) {
		$stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
		$stmt->bind_param(
			'sdsss',
			$data['txn_id'],
			$data['payment_amount'],
			$data['payment_status'],
			$data['item_number'],
			date('Y-m-d H:i:s')
		);
		$stmt->execute();
		$stmt->close();

		return $db->insert_id;
	}

	return false;
}
function addPaymentNew1($data) {
	// $paymentstatus = 'successful';
	$paymentstatus = $data['txn_id'];
	global $wpdb;
	$wpdb->update( $dbConfig['hm_user'], array('paymentstatus'=>$paymentstatus), array('id'=>$userID) );

	// global $db;
	// if (is_array($data)) {
	// 	$stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
	// 	$stmt->bind_param(
	// 		'sdsss',
	// 		$data['txn_id'],
	// 		$data['payment_amount'],
	// 		$data['payment_status'],
	// 		$data['item_number'],
	// 		date('Y-m-d H:i:s')
	// 	);
	// 	$stmt->execute();
	// 	$stmt->close();

	// 	return $db->insert_id;
	// }

	return false;
}
