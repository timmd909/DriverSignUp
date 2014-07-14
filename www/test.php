<?php

require "utils.php";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

	define( 'IV_SIZE', 8 );
	$iv = mcrypt_create_iv( IV_SIZE, MCRYPT_RAND );

    /* Data */
    $key = 's@f3tyF1R$T';
    /* Open module */
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
	$iv = mcrypt_create_iv( IV_SIZE, MCRYPT_RAND );
	
    /* Initialize encryption handle, IV is ignored for ecb */
    if (mcrypt_generic_init($td, $key, $iv ) != -1) {
        /* Decrypt data */
        $p_t = mdecrypt_generic($td, file_get_contents('../../accounts/test/applications.enc'));
        mcrypt_generic_deinit($td);
        echo "Applications = \n<pre>" . htmlspecialchars( $p_t ) . "</pre>";
        /* Clean up */
        mcrypt_module_close($td);
    }
?>


<?php
/*    $key = 'this is a very long key, even too long for the cipher';
    $plain_text = 'very important data';

    $td = mcrypt_module_open('des', '', 'ecb', '');
    $key = substr($key, 0, mcrypt_enc_get_key_size($td));
    $iv_size = mcrypt_enc_get_iv_size($td);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

    if (mcrypt_generic_init($td, $key, $iv) != -1) {

        $c_t = mcrypt_generic($td, $plain_text);
        mcrypt_generic_deinit($td);

		$iv = 'HI!';
        mcrypt_generic_init($td, $key, $iv);
        $p_t = mdecrypt_generic($td, $c_t);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
    }

    if (strncmp($p_t, $plain_text, strlen($plain_text)) == 0) {
        echo "ok\n";
    } else {
        echo "error\n";
    } */
?>




<?php
$original = "Hi there";
$encoded = encryptData( 'nussbaum', $original );
$decoded = decryptData( 'nussbaum', $encoded );
?>
<p><b><?= htmlspecialchars( $original ) ?></b> =&gt;<br />
<?= htmlspecialchars( $encoded ) ?> =&gt;<br />
<?= htmlspecialchars( $decoded ) ?>
</p>





<?php

$relPath = '../../accounts/';

$dh = opendir( $relPath );

$dirNames = array( );

while( $name = readdir( $dh ) ) {
	$dirNames[] = $name;
}

sort( $dirNames );

?><ul><?
print "\n";
foreach( $dirNames as $currName ) {
	?><li><?
	if( is_dir( $relPath . $currName ) ) { ?><b><? }
		
	print htmlspecialchars( $currName );
	
	if( is_dir( $relPath . $currName ) ) { ?></b><? }
	?></li><?
	print "\n";
}
?></ul><?

?></body>
</html>