<?php

require_once "utils.php";

// COLLECT INFORMATION 
$xmlData = stripslashes( $_REQUEST['xml'] );
$xml = simplexml_load_string( $xmlData );
$customer = stripslashes( $_REQUEST['customer'] );

// -=- CHECK INPUT -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

// check the customer name/output directory
if( trim( $customer ) == '' ) {
	reportFailure( 'No customer specified' );
}

$customerDir = EXPORT_BASE_DIR . $customer;
$applicationsFilename = $customerDir . '/applications.enc';

if( !is_dir( EXPORT_BASE_DIR . $customer ) ) {
	reportFailure( 'Customer "' . $customer . '" not found' );
} 

// check the incoming XML data
if( !$xmlData ) {
	reportFailure( 'No application data received' );
}

// -=- GENERATE THE EMAIL -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //


$ROW = $xml->ROW[0];

$ROW->Comments = NULL;

$addressInfo = $ROW->Addresses;
$licenseInfo = $ROW->CDLs;
$commentInfo = $ROW->Comments;
$signatureInfo = $ROW->Signatures;
$movingViolationInfo = $ROW->MovingViolations;
$accidentInfo = $ROW->Accidents;
$commentInfo = $ROW->Comments[0]->RowComments;

$employerInfo = $ROW->Employers;
$felonyInfo = $ROW->Felonies;

// PERSONAL INFORMATION 
$firstName 				= $ROW['DRVFN'];
$middleName 			= $ROW['MIDDLENAME'];
$lastName 				= $ROW['DRVLN'];
$phoneNumber 			= $ROW['PHONE'];
$cellPhone 				= $ROW['DRPHON2'];
$socialSecurityNumber 	= $ROW['SSN'];
$emailAddress 			= $ROW['EMAILADDR'];
$dateOfBirth 			= $ROW['DOB'];
$availabilityDate 		= $ROW['AVLDTE'];
$howDidYouHearID 		= $ROW['ADRID'];

$addressInfo = $ROW->Addresses[0]->RowAddresses;

// GENERAL INFORMATION 
$validDot			= $ROW['DOT'];
$dui 				= $ROW['DUI'];
$testedPositive		= $ROW['DRUGS'];
$licenseSuspended	= $ROW['LICSUS'];
$recklessDriving	= $ROW['RCKDRV'];
$felony				= $ROW['FELONY'];
$currentlyEmployed	= $ROW['EMPLOYED'];
$highSchoolDiploma  = $ROW['HSDIPLOMA'];
$drivingSchool 		= $ROW['DRVSCHOOL'];

// SIGNATURE 
$signatureBase64 = $ROW->Signatures[0]->RowSignatures[0]['JPG'];

// GENERATE! 
ob_start( );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>DriverSignUp.com &mdash; Sign Up</title>
<style media="all" type="text/css">
	* { 
		margin: 0;
		padding: 0;
		border: none;
		font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
		font-size: 10pt;
	}
	
	body {
		padding: 10px;
	}
	
	#message {
		width: 540pt; /* 540pt = 7.5in * 72ppi */
		margin: 0 auto;
		
	}
	
	h1 {
		color: #25569a;
		font-size: 14pt;
		border-bottom: 1px solid #25569a;
		margin: 7pt 0 7pt 0;
		font-weight: normal;
	}
	h2 {
		color: #25569a;
		font-size: 12pt;
		border-bottom: 1px solid #25569a;
		margin: 0 0 7pt 0;
		font-weight: normal;
	}
	
	b {
		color: #25569a;
		font-weight: normal;
	}
	
	ul {
	}
		ul li {
			margin-left: 0pt;
			text-indent: 0;
			list-style-position: inside;
			list-style-type: circle;
		}
		
	ol {
		padding: 0 4pt;
		margin: 0;
	}
		ol li {
			margin: 0 0 0 12pt;
			list-style-position: outside;
		}
	
	table {
		width: 100%;
		border-collapse: collapse;
	}
		table tr {
			
		}
			table tr td, 
			table tr th {
				padding: 2pt 4pt;
				border: none;
			}
			div.th,
			table tr th {
				font-weight: normal;
				background-color: #FFFFFF;
				color: #25569a;
				width: 84pt;
				text-align: left;
				vertical-align: top;
			}
			
			div.td,
			table tr td {
				
			}
			
	.underlined {
		border-bottom: 1px solid #25569a;
	}
	
	
	table.licenses {
	}
		table.licenses th, td {
			width: auto;
		}
	
	table.accidents {
	}
		table.accidents th, td {
			width: auto;
		}
		
	table.moving-violations {
	}
		table.moving-violations th, td {
			width: auto;
		}

	table.employers {
		margin: 0 0 12pt 0;
	}
		table.employers th, td {
			width: auto;
		}

</style>
</head>

<body>
<div id="message">
	<h1>Personal Information</h1>
	<table width="100%">
		<tr>
			<th width="16%">Full Name</th>
			<td colspan="6"><?
				$fullName = trim( $firstName . ' ' . $middleName );
				$fullName = trim( $fullName . ' ' . $lastName );
				print htmlspecialchars( "$fullName" );
			?></td>
		</tr>
		<tr>
			<th width="16%">Phone</th>
			<td width="16%"><?= htmlspecialchars( $phoneNumber ) ?></td>
			<th width="16%">Cell phone</th>
			<td width="16%"><?= htmlspecialchars( $cellPhone ) ?></td>
			<th width="16%">Best Time to Call</th>
			<td width="16%"><?= htmlspecialchars( (string)$ROW->BestTimeToCall[0] ) ?></td>
		</tr>
		<tr>
			<th>SSN</th>
			<td>XXX-XX-<?= substr( $socialSecurityNumber, strlen($socialSecurityNumber)-4 ) ?></td>
		</tr>
	</table>
	
	<div style="width: 100%" class="underlined">&nbsp;</div>
	
<?
	if( $addressInfo && count( $addressInfo ) ) {
		for( $i = 0; $i < count( $addressInfo ); $i ++ ) {
			$currAddress = $addressInfo[$i]; 
			$addressLine1 = $currAddress['ADDR1'];
			$addressLine2 = $currAddress['ADDR2'];
			$city = $currAddress['CITY'];
			$state = $currAddress['ST'];
			$zip = $currAddress['ZIP'];		
			$addressType = $currAddress['ADRTYP'];
			?>
	<table class="underlined">
		<tr>
			<th rowspan="3">Address <?= ($i + 1 ) ?> <br />
				(<?= htmlspecialchars( substr( $addressType, 0, 1 ) . strtolower( substr( $addressType, 1 ) ) ) ?>)</th>
			<td><?= htmlspecialchars( $addressLine1 ) ?></td>
		</tr>
		<tr>
			<td><?= htmlspecialchars( $addressLine2 ) ?></td>
		</tr>
		<tr>
			<td><?= htmlspecialchars( $city ) ?>, <?= htmlspecialchars( $state ) ?> <?= htmlspecialchars( $zip ) ?></td>
		</tr>
	</table>
			<?
		} // end for( 
	} // end if( 
?>		
	<div style="width: 100%">&nbsp;</div>

	<table>
		<tr>
			<th style="width:35%">Availability Date</th>
			<td><?= formatDate( $availabilityDate ) ?></td>
		</tr>
		<tr>
			<th>How did you hear about us?</th>
			<td><?= (string)$ROW->HowYouHear[0] ?><? 
				if( (string)($ROW->HowYouHear[0]['DETAILS']) ) {
					?> (<?= htmlspecialchars( (string)($ROW->HowYouHear[0]['DETAILS']) ) ?>)<?
				}
			?></td>
		</tr>
	</table>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>General Information</h1>
	<table>
		<tr>
			<th style="width: 62%">Valid DOT physical?</th>
			<td><?= ( $validDot == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr>
		<tr>
			<th style="width: 62%">DUI (driving under the influence of alcohol or drugs)?</th>
			<td><?= ( $dui == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr>
		<tr>
			<th>License ever suspended?</th>
			<td><?= ( $licenseSuspended == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr>
		<tr>
			<th>Convicted of Reckless Driving Charge?</th>
			<td><?= ( $recklessDriving == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr>
		<tr>
			<th>Tested positive, or refused a test, for drugs or alcohol?</th>
			<td><?= ( $testedPositive == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr> 
		<tr>
			<th>Currently employeed?</th>
			<td><?= ( $currentlyEmployed == 'Y' ? 'Yes': 'No' ) ?></td>
		</tr>
		<tr>
			<th>High school diploma or GED?</th>
			<td><?= ( $highSchoolDiploma == 'Y' ? 'Yes' : 'No' ) ?></td>
		</tr>
		<tr>
			<th>Graduated from driving school?</th>
			<td><?= ( $drivingSchool == 'Y' ? 'Yes' : 'No' ) ?></td>
		</tr>
		<tr>
			<th>Abandoned equipment?</th>
			<td><?= ( $ROW['ABANDON'] == 'Y' ? 'Yes' : 'No' ) ?></td>
		</tr>
		<tr>
			<th>Convicted of a felony?</th>
			<td><div><?= ( $felony == 'Y' ? 'Yes': 'No' ) ?></div>
				<ol><?
				print "\n";
				
				foreach( $felonyInfo->RowFelony as $currFelony ) {
					?><li><b>Circumstance: </b><?= htmlspecialchars( $currFelony->Comments[0]->RowComment[0]['COMMNT'] ) ?><?
					
					if( (string)$currFelony['DATE'] != '' ) { 
						?> &nbsp;<br /><b>Date: </b><?= htmlspecialchars( formatDate( (string)$currFelony['DATE'] ) ) ?><? 
					}
					
				} // foreach( 
				
				print "\t\t\t\t";
				?></ol>
			</td>
		</tr>
	</table>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>License Information</h1>
	<?php
		if( $licenseInfo && count( $licenseInfo->RowCDLs ) ) {
			for( $i = 0; $i < count( $licenseInfo->RowCDLs ); $i++ ) {
					$currLicense = $licenseInfo->RowCDLs[$i];
				?>
	<table class="licenses">
		<tr>
			<th rowspan="2" style="width:96pt">License #<?= ($i+1 ) ?></th>
			<th>CDL</th>
			<td><?= htmlspecialchars( $currLicense['CDLNUM'] ) ?></td>
			<th>Issue State</th>
			<td><?= htmlspecialchars( $currLicense['CDLST'] ) ?></td>
			<th>Expiration</th>
			<td><?= formatMonth( substr( $currLicense['EXPDT'], 4, 2 ) ) ?> <?= htmlspecialchars( substr( $currLicense['EXPDT'], 0, 4 ) ) ?></td>
		</tr>
		<tr>
			<!-- <th>Endorsements</th> -->
			<th>Hazmat</th>
			<td><?= ( $currLicense['HAZMAT'] == 'Y' ? 'Yes' : ' No' ) ?></td>
			<th>Tanker</th>
			<td><?= ( $currLicense['TANK'] == 'Y' ? 'Yes' : ' No' ) ?></td>
			<th>Doubles/Triples</th>
			<td><?= ( $currLicense['DBLTPL'] == 'Y' ? 'Yes' : ' No' ) ?></td>
		</tr>
	</table>		
				<?
			} // for( $i = 0; $i < count( $licenseInfo ); $i++ ) {
		} // if( $licenseInfo && count( $licenseInfo ) ) {
	?>


	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>Accidents</h1>
	<?php
	if( $accidentInfo->RowAccidents && count( $accidentInfo->RowAccidents ) ) 
	for( $i = 0; $i < count( $accidentInfo->RowAccidents ); $i ++ ) {
		$currAccident = $accidentInfo->RowAccidents[$i];
	?>
	<table class="accidents">
		<tr>
			<th rowspan="3" style="width:96pt">Accident #<?= ( $i + 1 ) ?></th>
			<th>Date</th>
			<td><?= formatDate( $currAccident['DATE'] ) ?></td>
			<th>Vehicle Type</th>
			<td><?= htmlspecialchars( $currAccident['VEHICLETYPE'] ) ?></td>
			<th>Preventability</th>
			<td><?= ( $currAccident['PREVENTABLE'] == 'Y' ? 'Yes' : 'No' ) ?></td>
		</tr>
		<tr>
			<th>Damage</th>
			<td>$<? 
				setlocale(LC_MONETARY, 'en_US');
				print money_format( '%!i', doubleval($currAccident['DAMAGE']) );
			?></td>
			<th>Fatalities</th>
			<td><?= htmlspecialchars( $currAccident['FATALITIES'] ) ?></td>
			<th>Injuries</th>
			<td><?= htmlspecialchars( $currAccident['INJURIES'] ) ?></td>
		</tr>
		<tr>
			<th>Nature</th>
			<td colspan="5"><?= htmlspecialchars( $currAccident['NATURE'] ) ?></td>
		</tr>
	</table>
	<?
	} //  for( $i = 0; $i < $accidentInfo->RowAccidents->length( ); $i ++ ) {
	?>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>Moving Violations</h1>
	<?php
	if( $movingViolationInfo->RowMovingViolations && count( $movingViolationInfo->RowMovingViolations ) ) 
	for( $i = 0; $i < count( $movingViolationInfo->RowMovingViolations ); $i ++ ) {
		$currMovingViolation = $movingViolationInfo->RowMovingViolations[$i];
	?>
	<table class="moving-violations">
		<tr>
			<th rowspan="2" style="width: 96pt;">Violation #<?= ($i+1) ?></th>
			<th>Date</th>
			<td><?= formatDate( $currMovingViolation['DATE'] ) ?></td>
			<th>Type of Violation</th>
			<td><?= htmlspecialchars( $currMovingViolation['TYPE'] ) ?></td>
		</tr>
		<tr>
			<th>State</th>
			<td><?= htmlspecialchars( $currMovingViolation['ST'] ) ?></td>
			<th>Penalty</th>
			<td><?= htmlspecialchars( $currMovingViolation['PENALTY'] ) ?></td>
		</tr>
	</table>
	<?
	} //  for( $i = 0; $i < $movingViolationInfo->RowMovingViolations->length( ); $i ++ ) {
	?>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>Employers</h1>
	<?php
	if( $employerInfo->RowEmployers && count( $employerInfo->RowEmployers ) ) 
	for( $i = 0; $i < count( $employerInfo->RowEmployers ); $i ++ ) {
		$currEmployer = $employerInfo->RowEmployers[$i];
	?>
	<table class="employers">
		<tr>
			<th rowspan="7" style="width: 96pt;">Employer #<?= ($i+1) ?></th>
			<th style="width: 72pt;">Name</th>
			<td colspan="3"><?= htmlspecialchars( $currEmployer['NAME'] ) ?></td>
		</tr>
		<tr>
			<th>Address</th>
			<td colspan="3"><?= htmlspecialchars( $currEmployer['ADDR1'] ) ?></td>
		</tr>
		<tr>
			<td></td>
			<td><?= htmlspecialchars( $currEmployer['CITY'] ) ?>, <?= htmlspecialchars( $currEmployer['ST'] ) ?></td>
			<th>Trailer type</th>
			<td><?= htmlspecialchars( $currEmployer['TRAILERTYPE'] ) ?></td>
		</tr>
		<tr>
			<th>Phone</th>
			<td><?= htmlspecialchars( $currEmployer['PHONE'] ) ?></td>
			<th style="width: 72pt;">Employed</th>
			<td><?= formatDate( $currEmployer['BEGDTE'] ) ?> &mdash; <?= formatDate( $currEmployer['ENDDTE'] ) ?></td>
		</tr>
		<tr>
			<th>Position</th>
			<td><?= htmlspecialchars( $currEmployer['JOBPRF'] ) ?></td>
			<th>Reason left</th>
			<td><?= htmlspecialchars( $currEmployer['RSNRID'] ) ?></td>
		</tr>
		<tr>
			<th>Safety Sensitive</th>
			<td><?= ( $currEmployer['SSF'] == 'Y' ? 'Yes' : 'No' ) ?></td>
			<th>FMCSR</th>
			<td><?= ( $currEmployer['FMCSR'] == 'Y' ? 'Yes' : 'No' ) ?></td>
		</tr>
	</table>
	<?
	} //  for( $i = 0; $i < $employerInfo->RowEmployers->length( ); $i ++ ) {
	?>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>Confirmation</h1>
	<table>
		<tr>
			<th>Agreed to release</th>
			<td>Yes</td>
		</tr>
	</table>

	<?php /* -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- */ ?>
	<h1>Comments</h1>
	<?php
	if( $commentInfo && count( $commentInfo ) ) {
		?><ul><? 
		print "\n";
		
		for( $i = 0; $i < count( $commentInfo ); $i++ ) {
			$currComment = $commentInfo[$i];
			?><li><?= htmlspecialchars( $currComment['COMMNT'] ) ?></li><?
			print "\n";
		} // for( $i = 0; $i < count( $commentInfo ); $i++ ) {
		
		print "\n";
		?></ul><?
	} // if( $commentInfo && count( $commentInfo ) ) {
	
	?>
</div>

</body>

</html>

<?php

$emailMessageBody = wordwrap( ob_get_contents( ), 70, "\n", true );

ob_end_clean();


$headers = 
	'From: noreply@driversignup.com' . "\r\n" . 
	'Content-Type: multipart/mixed; boundary=' . MIME_BOUNDRY . "\r\n" .
	'Mime-Version: 1.0' . "\r\n";

$email = 
	'--' . MIME_BOUNDRY . "\r\n" . 
		'Content-Type: text/html;' . "\r\n" .
		"\r\n" . 
		$emailMessageBody . "\r\n" .
		"\r\n" . 
	'--' . MIME_BOUNDRY . "\r\n" .
		'Content-Transfer-Encoding: base64' . "\r\n" .
		'Content-Disposition: attachment' . "\r\n" .
		'Content-Type: image/jpeg, name="signature.jpg"' . "\r\n" .
		"\r\n" . 
		str_replace( " ", "\r\n", $signatureBase64 ). "\r\n" .
		"\r\n" .
	'--' . MIME_BOUNDRY . "--\r\n";


$emailAddress = $ACCOUNT_INFO[$customer]['email'];
if( $emailAddress == '' ) {
	$emailAddress = 'tim@tim-doerzbacher.com';
}
$result = htmlEmail( $emailAddress, "Online Application submission", $email, $headers ); 


// -=- ADD TO APPLICATIONS.ENC -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

// check to see if the applicant.xml file exists
if( file_exists( $applicationsFilename ) ) {
	$oldXMLData = decryptData( $customer, file_get_contents( $applicationsFilename ) );
	if( !$oldXMLData ) $oldXMLData = '<DATAPACKET Version="2.0"></DATAPACKET>'; 
} else {
	$oldXMLData = '<DATAPACKET Version="2.0"></DATAPACKET>'; 
}
$oldXML = simplexml_load_string( $oldXMLData );

$newXMLData = '<DATAPACKET Version="2.0">' . "\n";
$newXMLData .= '  '. $xml->ROW[0]->asXML( ) . "\n";

foreach( $oldXML->ROW as $currRow ) {
	$newXMLData .= $currRow->asXML( ) . "\n";
}
$newXMLData .= "\n" . '</DATAPACKET>';

$debug = "BEFORE = \n\n$newXMLData\n\nAFTER = \n\n$newXMLData\n\n";

$newXML = simplexml_load_string( $newXMLData );

// save out XML
file_put_contents( $applicationsFilename, encryptData( $customer, $newXML->asXML( ) ) );
file_put_contents( $applicationsFilename . '.xml', $newXMLData ); // DEBUGGING ONLY... This is UNSAFE and dumps the XML into plaintext


// -=- THE FINAL STRETCH -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- -=- //

reportSuccess( "Successfully received new application for customer $customer", $debug );

?>