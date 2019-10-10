<?php

require "../vendor/autoload.php";

use Elliptic\EC;
use BN\BN;
use function BitWasp\Bech32\encodeSegwit;

$xpub = "0488b21e";
$ypub = "049d7cb2";
$zpub = "04b24746";
$base58 = new StephenHill\Base58();
$ec = new EC("secp256k1");

if (sizeof($argv) == 1) {
    $seed_test = "rival keen siege police adjust lonely city remain hill digital evidence agent violin diesel goat unhappy degree brick sunny famous act dash pair barrel";

    $xpub_test = "xpub6DLsMr8UBXHRGiQse2FDYbZi2VtSJfAjueR2UHVyjNRAFZF9xDDm5ncFP3Hr6Eh6zwNyBWQdYmVCtwijpTFiTd3i7WRihF6aUAe78LqPi2S";
    $ypub_test = "ypub6WbbRC6tgQ3TFERbsWnjUjnT2uGX5jXhM7PfCq99NL6reDNA57xQCAhcRHu2VnBrU9dco5mEycEV3gpGLGTCz1yj8Rc5cVGkBRvFqekAV5e";
    $zpub_test = "zpub6rz3grcWWZw3nPQ7moNtAXFHaQ1uPs83TSWsdd9La1RdvPdrTaNeapmZwSA8riy4mwo6hKDvfHcHi7U7DstrA5kFsbYaf49cZ2fGFJCouy5";

    $index_test = 15000;

    $expectedP2PKH = "1DC6RFoe5e9Gqwt8HAhR1i9M9erpZcdCF4";
    $expectedP2SHP2WPKH = "36QZB8PwuoQeLP9nquS8WgCdkBquKZVtoP";
    $expectedP2WPKH = "bc1qzm2j4wvq0lgut7c49x3tugvnaxkxxvdy6duzmy";

    echo "From seed: " . $seed_test . "\n";
    echo "\nxpub: " . $xpub_test . "\n";
    echo "ypub: " . $ypub_test . "\n";
    echo "zpub: " . $zpub_test . "\n";

    $P2PKH = derive($xpub_test, $index_test);
    $P2SHP2WPKH = derive($ypub_test, $index_test);
    $P2WPKH = derive($zpub_test, $index_test);

    if ($P2PKH[1] != $expectedP2PKH) {
        echo "\nP2PKH (xpub) derivation result did not match " . $expectedP2PKH . "!";
    }
    if ($P2SHP2WPKH[1] != $expectedP2SHP2WPKH) {
        echo "\nP2SHP2WPKH (ypub) derivation result did not match " . $expectedP2SHP2WPKH . "!";
    }
    if ($P2WPKH[1] != $expectedP2WPKH) {
        echo "\nP2WPKH (zpub) derivation result did not match " . $expectedP2WPKH . "!";
    }

    echo "\nm/44'/0'/0'/0/15000: " . $P2PKH[1] . "\n";
    echo "m/49'/0'/0'/0/15000: " . $P2SHP2WPKH[1] . "\n";
    echo "m/84'/0'/0'/0/15000: " . $P2WPKH[1] . "\n";
}else if(sizeof($argv) == 3 && ctype_digit($argv[2])) {
    $Xpub = $argv[1];
    $index = $argv[2];
    $address = derive($Xpub, $index);
    echo $address[0] . " Address: " . $address[1];
}else {
    echo "Invalid parameters. Expected: [Xpub] [Index]";
}

function derive($XpubSerialized, $index): Array {
    $Xpub = base58check_decode($XpubSerialized);
    $version = substr($Xpub, 0, 4 * 2);
    $depth = substr($Xpub, 4 * 2, 1 * 2);
    $chaincodeAccount = substr($Xpub, -65 * 2, 32 * 2);
    $pubkeyAccount = substr($Xpub, -33 * 2);
    if (strtolower($version) == $GLOBALS["xpub"]) {
        $addressType = "P2PKH";
    } elseif (strtolower($version) == $GLOBALS["ypub"]) {
        $addressType = "P2SH-P2WPKH";
    } elseif (strtolower($version) == $GLOBALS["zpub"]) {
        $addressType = "P2WPKH";
    } else {
        throw new Exception("Invalid extended public key: version bytes do not match xpub, ypub, or zpub.");
    }
    if ($depth != "03") {
        throw new Exception("Invalid extended public key: depth is not indicative of an account-level extended key.");
    }
    // Derive External extended key
    $XpubExternal = CKDpub($pubkeyAccount, $chaincodeAccount, 0);
    $pubkeyExternal = substr($XpubExternal, 0, 33 * 2);
    $chaincodeExternal = substr($XpubExternal, -32 * 2);
    // Derive Public Key for address at given index
    $pubkeyAddress = substr(CKDpub($pubkeyExternal, $chaincodeExternal, $index), 0, 33 * 2);
    $pubkeyHash = hash160($pubkeyAddress);
    if ($addressType == "P2PKH") {
        return [$addressType, encodeP2PKH($pubkeyHash)];
    } else if ($addressType == "P2SH-P2WPKH") {
        return [$addressType, encodeP2SHP2WPKH($pubkeyHash)];
    } else {
        return [$addressType, encodeP2WPKH($pubkeyHash)];
    }
}

function base58check_decode($encodedData): string {
    $decodedData = bin2hex($GLOBALS["base58"]->decode($encodedData));
    $data = substr($decodedData, 0, -4 * 2);
    $checksum = substr($decodedData, -4 * 2);
    $dataHash = hash("sha256", hash("sha256", hex2bin($data), true));
    if (strtolower($checksum) != strtolower(substr($dataHash, 0, 4 * 2))) {
        throw new Exception("Base58 checksum is not valid.");
    }
    return $data;
}

function base58check_encode($data): string {
    $doubleSha256Hash = hash("sha256", hash("sha256", hex2bin($data), true));
    $checksum = substr($doubleSha256Hash, 0, 4 * 2);
    return $GLOBALS["base58"]->encode(hex2bin($data . $checksum));
}

function CKDpub($pubkeyParent, $chaincodeParent, $index): string {
    $I_key = hex2bin($chaincodeParent);
    $I_data = hex2bin($pubkeyParent) . pack("N", $index);
    $I = hash_hmac("sha512", $I_data, $I_key);
    $I_L = substr($I, 0, 64);
    $I_R = substr($I, 64, 64);
    $chaincodeChild = $I_R;

    $pubkeyAccount_point = $GLOBALS["ec"]->curve->decodePoint($pubkeyParent, "hex");
    $I_L_point = $GLOBALS["ec"]->g->mul(new BN($I_L, 16));
    $pubkeyChild = ($pubkeyAccount_point->add($I_L_point))->encodeCompressed("hex");

    return $pubkeyChild . $chaincodeChild;
}

function hash160($data): string {
    return hash("ripemd160", hash("sha256", hex2bin($data), true));
}

function encodeP2PKH($pubkeyHash): string {
    $version = "00";
    return base58check_encode($version . $pubkeyHash);
}

function encodeP2SHP2WPKH($pubkeyHash): string {
    $witnessProgram = "0014" . $pubkeyHash;
    $version = "05";
    return base58check_encode($version . hash160($witnessProgram));
}

function encodeP2WPKH($pubkeyHash): string {
    return encodeSegwit("bc", 0, hex2bin($pubkeyHash));
}
