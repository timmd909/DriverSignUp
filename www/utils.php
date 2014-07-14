<?php
/**
	@file	utils.php
*/

// -=- CONSTANTS -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

define( 'MIME_BOUNDRY', 				'M1M3_B0undry-' . rand( 1000000, 9999999 ) );
define( 'MIME_INNER_BOUNDRY', 			'M1M3_1nn3r_B0undry-' . rand( 1000000, 9999999 ) );
define( 'TEMPORY_SIGNATURE_FILENAME',	'/tmp/TEMPSIGNATURE' . rand( 1000000, 9999999 ) . '.jpg' );

// define( 'EXPORT_BASE_DIR', '../../accounts/' );
define('EXPORT_BASE_DIR', '/home/');
define('IV_SIZE', 8);

$ACCOUNT_INFO = array(
	'test' => array( 
		'password' => 'test123',
		'email' => 'test@example.com'
	)
);




// -=- UTILITY FUNCTIONS -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

function formatMonth( $monthNum ) {
	switch( intval( $monthNum, 10 ) ) {
		case  1: { return 'January';   } break;
		case  2: { return 'February';  } break;
		case  3: { return 'March';     } break;
		case  4: { return 'April';     } break;
		case  5: { return 'May';       } break;
		case  6: { return 'June';      } break;
		case  7: { return 'July';      } break;
		case  8: { return 'August';    } break;
		case  9: { return 'September'; } break;
		case 10: { return 'October';   } break;
		case 11: { return 'November';  } break;
		case 12: { return 'December';  } break;
	} // switch( $month ) {
} // function formatMonth( $monthNum ) {

/** Takes a date string in the XML format and makes it human readable
	Ex: 20100204 -> February 4, 2010
*/
function formatDate( $dateStr ) {
	$day   = intval( substr( $dateStr, 6, 2 ), 10 );
	$month = intval( substr( $dateStr, 4, 2 ), 10 );
	$year  = intval( substr( $dateStr, 0, 4 ), 10 );

	return formatMonth( $month ) . ' ' . $day . ', ' . $year;
}


//function htmlEmail( $to, $subject, $message, $headers = "From: noreply@driversignup.com\r\nBcc: tim@tim-doerzbacher.com\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=\"iso-8859-1\""  ) {
function htmlEmail( $to, $subject, $message, $headers = "From: noreply@driversignup.com\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=\"iso-8859-1\""  ) {
	error_log( "htmlEmail( '$to', '$subject', '$message', '$headers' )" );
	return mail( $to, $subject, $message, $headers );
}


function decryptData( $customer, $encodedData ) {
	global $ACCOUNT_INFO;
	$password = $ACCOUNT_INFO[$customer]['password'];
	if( $password == '' ) {
		reportFailure( "Couldn't find customer '$customer' secret decoder ring" );
	}
	
	$encryptModule = mcrypt_module_open( 'tripledes', '', 'ecb', '' );
	$key = $password;
	$iv = mcrypt_create_iv( IV_SIZE, MCRYPT_RAND );
	
	if( mcrypt_generic_init( $encryptModule, $key, $iv ) != -1 ) {
		$decoded = mdecrypt_generic( $encryptModule, $encodedData );
	} else {
		reportFailure( "Couldn't initialize decryption." );
	}
	mcrypt_generic_deinit($encryptModule);
	mcrypt_module_close($encryptModule);
	return $decoded;
}

function encryptData( $customer, $plaintext ) {
	global $ACCOUNT_INFO;
	$password = $ACCOUNT_INFO[$customer]['password'];
	if( $password == '' ) {
		reportFailure( "Couldn't find customer '$customer' secret encoder ring" );
	}
	
	$encryptModule = mcrypt_module_open( 'tripledes', '', 'ecb', '' ); // wonder why 'ecb' works and another one doesn't....
	$key = $password;
	$iv = mcrypt_create_iv( IV_SIZE, MCRYPT_RAND );
	
	if( mcrypt_generic_init( $encryptModule, $key, $iv ) != -1 ) {
		$encoded = mcrypt_generic( $encryptModule, $plaintext );
	} else {
		reportFailure( "Couldn't initialize decryption." );
	}
	
	return $encoded;
}

function reportSuccess( $message, $debug = '' ) {
	?><submitResult>
	<message><?= htmlspecialchars( $message ) ?></message>
	<? 
	if( $debug != '' ) { 
		?><debug><?= htmlspecialchars( $debug ) ?></debug><? 
	} else { 
		?><!-- no debug info --><? 
	} 
	?>
</submitResult><?
	exit( 0 );
} // function reportSuccess( ... )

function reportFailure( $message, $debug = '' ) {
	?><submitResult>
	<error><?= htmlspecialchars( $message ) ?></error>
	<? 
	if( $debug != '' ) { 
		?><debug><?= htmlspecialchars( $debug ) ?></debug><? 
	} else { 
		?><!-- no debug info --><? 
	} 
	?>
</submitResult><?
	exit( -1 );
} // function reportFailure( ... )



?>
