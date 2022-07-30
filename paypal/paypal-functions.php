<?php
ob_start();
session_start();

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
$site_url = site_url( '/homeexchange');

$paypalConfig = [
	'email1' => 'paypal-owner@email.com',
	'email' => 'sb-jsegq1113542@business.example.com',
	'return_url' => $site_url.'/paymentsubmit?payments=successful',
	'cancel_url' => $site_url.'/paymentsubmit?payments=cancelled',
	'notify_url' => $site_url.'/paymentsubmit?payments=notify'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Product being purchased.
$itemName = 'membership fee';
$itemAmount = '60';
$itemNumber = 'userid'.$_SESSION["userid"];
$userID = $_SESSION["userid"];
$userEmail = $_SESSION["email"];
$userFullName = $_SESSION["name"];
$userFullName = $_SESSION["name"];
$userAddress = $_SESSION["address"];

/* payment query*/
if( isset($_GET['payments']) ):
	// echo $_GET['payments'];
endif;
/* payment successful add to record*/
if( isset($_GET['payments']) == 'successful' ):
	$paymentstatus = 'successful';
	global $wpdb;
	echo($dbConfig['hm_user']);
	$wpdb->update( $dbConfig['hm_user'], array('paymentstatus'=>$paymentstatus), array('id'=>$userID) );
	//wp_die(); // this is required to terminate immediately and return a proper response
	// $_SESSION["msg"] = $_SESSION["msg"];
	header("location: /homeexchange/profile/");
	exit();
endif;


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
		$stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime, custom) VALUES(?, ?, ?, ?, ?, ?)');
		$stmt->bind_param(
			'sdssss',
			$data['txn_id'],
			$data['payment_amount'],
			$data['payment_status'],
			$data['item_number'],
			date('Y-m-d H:i:s'),
			$data['custom']
		);
		$stmt->execute();
		$stmt->close();

		return $db->insert_id;
	}

	return false;
}


/*
create_payments.sql


CREATE TABLE IF NOT EXISTS `payments` (
 `id` int(6) NOT NULL AUTO_INCREMENT,
 `txnid` varchar(20) NOT NULL,
 `payment_amount` decimal(7,2) NOT NULL,
 `payment_status` varchar(25) NOT NULL,
 `itemid` varchar(25) NOT NULL,
 `createdtime` datetime NOT NULL,
 `first_name` datetime NOT NULL,
 `payer_email` datetime NOT NULL,
 `night_phone_a` datetime NOT NULL,
 `address1` datetime NOT NULL,
 `custom` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
*/