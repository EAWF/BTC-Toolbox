<?php
# Example usage from command line:
# php Usage.php [HEX PRIVATE KEY] (optional)[0 for uncompressed, 1 for compressed]
# php Usage.php [WIF PRIVATE KEY] (optional)[0 for uncompressed, 1 for compressed]
# The Optional compression flag (0 or 1) defaults to Compressed (1)

require('Secp256k1.php');
$Secp256k1 = new Secp256k1();

if(sizeof($argv) == 3 && (strcasecmp($argv[2], "0") == 0 || strcasecmp($argv[2], "1") == 0)) {
	$compressed = boolval($argv[2]);
	$public_key = $Secp256k1->private2public($argv[1],$compressed);
	echo "Private Key: " . $argv[1] . "\nPublic Key: " . $public_key . "\n";
}else if(sizeof($argv) == 2) {
	$public_key = $Secp256k1->private2public($argv[1]);
	echo "Private Key: " . $argv[1] . "\nPublic Key: " . $public_key . "\n";
}else {
	echo "Invalid usage: First argument must be a private key (hex or WIF), (optional) second argument must be 0 (true) or 1 (false).\n";
}
?>
