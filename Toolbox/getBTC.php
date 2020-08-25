<?php

/**
 * File containing the Bitcoin Merchants Toolbox functions
 * 
 * See https://github.com/EAWF/Bitcoin-Merchants-Toolbox for installation & usage instructions 
 * 
 * @package    Main
 * @license    https://github.com/EAWF/getBTCAddress/blob/master/LICENSE   Unlicense License
 * @author     Carson Mullins (https://github.com/Septem151) <carsonmullins@yahoo.com>   
 * @author     Bob Holden (https://github.com/EAWF) <bob@eawf.com>
 * @author     Jan Moritz Lindemann (https://github.com/rgex)
 */

namespace BTC;

// Test that PHP modules are installed
if (!extension_loaded('base58') || !extension_loaded('gmp') || !extension_loaded('mcrypt'))
    die("Error: Required extension(s) php-base58, php-gmp, and php-mcrypt not installed.\n");

/**
 * Derive a Bitcoin Address from a named account at the given index
 * 
 * Main interaction function to derive a RECEIVING (external) address from a given extended public key that is associated
 * with the specified name in the conf file.
 * 
 * @param  string $name     Extended public key to reference in the conf file
 * @param  int    $childNum Child number index to derive a public key from
 * @return string Encoded address derived from the given extended public key at the given child number index
 */
function getBTCAddress(string $name, int $childNum): string
{
    $extPubKey = getExtPubKey($name);
    $externalExtPubKey = ExtendedPublicKey::CKDpub($extPubKey, 0);
    return ExtendedPublicKey::CKDpub($externalExtPubKey, $childNum)->getAddress();
}

/**
 * Checks the balance (in BTC units) of a Bitcoin Address with an optional minimum number of confirmations
 * 
 * Uses the <a href="https://github.com/Blockstream/esplora">Blockstream Esplora API</a> to retrieve UTXOs of the given address,
 * then checks whether the UTXOs have greater than or an equal amount of confirmations specified.
 * 
 * @param  string $address       Bitcoin Address to check the address of
 * @param  int    $confirmations (Optional, default = 0) Minimum number of confirmations to consider a UTXO as part of the balance
 * @return string Bitcoin amount formatted to have 8 decimals
 */
function getBTCBalance(string $address, int $confirmations = 0): string
{
    $query = "https://blockstream.info/api/address/" . urlencode($address) . "/utxo";
    $result = json_decode(file_get_contents($query), true);
    $blockheight = 0;
    $balance = 0;
    foreach ($result as $utxo) {
        $utxo_confirmations = 0;
        if ($confirmations > 0 && filter_var($utxo["status"]["confirmed"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
            if ($blockheight == 0)
                $blockheight = (int)file_get_contents("https://blockstream.info/api/blocks/tip/height");
            $utxo_confirmations = 1 + $blockheight - (int)$utxo["status"]["block_height"];
        }
        if ($utxo_confirmations >= $confirmations)
            $balance += (float)$utxo["value"];
    }
    $balance /= 100000000;                   // Convert Satoshis to BTC
    $balance = number_format($balance, 8);   // Format $balance to match $amount from getBTCInvoice()
    return $balance;
}

/**
 * Generates a QR Code image, in binary encoding, of a BIP21 Payment Request
 * 
 * Function is a WIP
 * 
 * @return void WIP
 */
function getBTCInvoice()
{
}

/**
 * Get the current USD rate of Bitcoin, or convert a USD amount to Bitcoin amount
 * 
 * Uses the <a href="https://www.bitstamp.net/api/">Bitstamp v2 API</a> to retrieve USD price data.
 * 
 * @param  float  $amount (Optional, default = 0) Amount in USD to convert to Bitcoin amount
 * @return string Either the current Bitcoin price in USD formatted as "$###,###.##", or an equivalent Bitcoin amount formatted to 8 decimals
 */
function getBTCRate(float $amount = 0): string
{
    $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'), true);
    if ($amount <= 0) {           // Assign 0 if null, and protect against accidental use of negative numbers.
        // Display Rate in Dollars mode
        $result = "$ " . number_format($bitstamp["last"], 2);     // return $result in users locale format with 2 decimal places and thousands separators.
    } else {
        // Exchange Dollars for BTC Mode
        $result = number_format($amount / $bitstamp["last"], 8, '.', '');  // return $result with 8 decimal places and no thousands separators.
    }
    return $result;
}

/**
 * Get ExtendedPublicKey from config file based on name
 * 
 * Returns exported Account-Level {@see ExtendedPublicKey} from getBTC.conf file based on name.
 * Requires a getBTC.conf file. Set ownership/permissions with "chown [owner]:apache" and "chmod 640"
 * 
 * @param  string            $name Determines which extended public key to reference in the conf file
 * @return ExtendedPublicKey Object representation of the extended public key from the conf file
 */
function getExtPubKey(string $name): ExtendedPublicKey
{
    $fh = fopen(stream_resolve_include_path("getBTC.conf"), "r") or die("Error attempting to open configuration file: getBTC.conf\n");
    $res = '';
    while (!feof($fh)) {
        $line = fgets($fh);
        if ($line[0] === "#")
            continue;
        $data = explode(':', $line);
        if (trim($data[0]) === $name) {
            $res = $data[1];
            break;
        }
    }
    fclose($fh);
    if (empty($res))
        die("Extended Public Key for \"$name\" NOT found. Check location and contents of getBTC.conf\n");
    else
        return ExtendedPublicKey::fromEncoded(trim($res));
}

/**
 * Class encapsulating data of an Extended Public Key and the CKDPub function
 */
class ExtendedPublicKey
{
    /**
     * Valid extended public key versions and their properties 
     */
    const VERSIONS = [
        "xpub" => ["hex" => "0488b21e", "path" => "m/44'"],
        "ypub" => ["hex" => "049d7cb2", "path" => "m/49'"],
        "zpub" => ["hex" => "04b24746", "path" => "m/84'"]
    ];

    /**
     * Properties of an Extended Public Key
     */
    protected $version, $depth, $fingerprint, $childNum, $chainCode, $pubKey, $encodedExtPubKey, $parentIndeces;

    /**
     * Constructor for ExtendedPublicKey objects
     * 
     * Constructor should not be used directly. See {@see ExtendedPublicKey::fromEncoded()} or {@see ExtendedPublicKey::fromParent()} for object creation.
     * 
     * @param  string   $version          Hexadecimal version (4 bytes), must be a valid version defined in the VERSIONS array
     * @param  string   $depth            Hexadecimal depth (1 byte), must be >= 3
     * @param  string   $fingerprint      Hexadecimal fingerprint (4 bytes), the first 4 bytes of the Hash256 of parent's public key
     * @param  string   $childNum         Hexadecimal child number (4 bytes), the index at which this key is derived
     * @param  string   $chainCode        Hexadecimal chain code (32 bytes), the chain code for this extended public key
     * @param  string   $pubKey           Hexadecimal public key (33 bytes), in compressed DER encoding
     * @param  string   $encodedExtPubKey (optional, default = null) Hexadecimal encoding of this extended public key, calculated if not given
     * @param  string[] $parentIndeces    (optional, default = []) Array of all parent's child numbers for knowing the derivation path
     * @throws \Exception                 if the given values are not valid for an extended public key
     */
    public function __construct(
        string $version,
        string $depth,
        string $fingerprint,
        string $childNum,
        string $chainCode,
        string $pubKey,
        string $encodedExtPubKey = null,
        array $parentIndeces = []
    ) {
        foreach (static::VERSIONS as $extKeyVals) {
            if (strtolower($version) === $extKeyVals["hex"]) {
                $this->version = $version;
                break;
            }
        }
        if (empty($this->version))
            throw new \Exception('Unknown version bytes detected. Unable to get address for extended public key: ' . $this->encodedExtPubKey);
        $this->depth = $depth;
        if (hexdec($depth) - 3 != count($parentIndeces))
            throw new \Exception('Incorrect amount of parent indeces. Needed: ' . (hexdec($depth) - 3) . ", Provided: " . count($parentIndeces));
        $this->parentIndeces = $parentIndeces;
        $this->fingerprint = $fingerprint;
        $this->childNum = $childNum;
        $this->chainCode = $chainCode;
        $this->pubKey = $pubKey;
        if ($encodedExtPubKey == null) {
            $extPubKey = $this->version . $this->depth . $this->fingerprint . $this->childNum . $this->chainCode . $this->pubKey;
            $checksum = substr(HashUtil::hash256($extPubKey), 0, 8);
            $this->encodedExtPubKey = base58_encode(hex2bin($extPubKey . $checksum));
        } else {
            $this->encodedExtPubKey = $encodedExtPubKey;
        }
    }

    /**
     * Decodes an Account-level extended public key into an ExtendedPublicKey object representation
     * 
     * Decodes the given Account-level extended public key (in Base58Check encoding) and returns an {@see ExtendedPublicKey} object
     * representing its data. This function should only be used on Account-level keys, as parental data is needed to know the derivation path.
     * 
     * @param  string            $encodedExtPubKey Account-level extended public key in Base58Check encoding
     * @return ExtendedPublicKey Object representation of the given extended public key
     * @throws \Exception        if the given extended public key is not valid or not at the Account level
     */
    public static function fromEncoded(string $encodedExtPubKey): ExtendedPublicKey
    {
        $decodedExtPubKey = bin2hex(base58_decode($encodedExtPubKey));
        if (strlen($decodedExtPubKey) != 164)
            throw new \Exception('Invalid Extended Public Key (incorrect length of ' . strlen($decodedExtPubKey) . '): ' . $encodedExtPubKey);
        $extPubKey = substr($decodedExtPubKey, 0, -8);
        $checksum = substr($decodedExtPubKey, -8);
        $computedChecksum = substr(HashUtil::hash256($extPubKey), 0, 8);
        if ($checksum !== $computedChecksum)
            throw new \Exception('Invalid Extended Public Key (checksum mismatch): ' . $encodedExtPubKey);
        $version = substr($extPubKey, 0, 8);
        $depth = substr($extPubKey, 8, 2);
        if (hexdec($depth) != 3)
            throw new \Exception('Invalid Extended Public Key (not at account-level): Depth: ' . hexdec($depth));
        $fingerprint = substr($extPubKey, 10, 8);
        $childNum = substr($extPubKey, 18, 8);
        $chainCode = substr($extPubKey, 26, 64);
        $pubKey = substr($extPubKey, 90, 66);
        return new static($version, $depth, $fingerprint, $childNum, $chainCode, $pubKey, $encodedExtPubKey);
    }

    /**
     * Creates a child ExtendedPublicKey object from a given parent object
     * 
     * Creates an {@see ExtendedPublicKey} object that has the fingerprint value calculated based on the given parent,
     * and all child number indeces appended to the returned object.
     * 
     * @param  string            $childNum  Hexadecimal child number (4 bytes) of the ExtendedPublicKey to be created
     * @param  string            $chainCode Hexadecimal chain code (32 bytes) of the ExtendedPublicKey to be created
     * @param  string            $pubKey    Hexadecimal public key (33 bytes) of the ExtendedPublicKey to be created, in compressed DER encoding
     * @param  ExtendedPublicKey $parent    Parent extended public key for the child ExtendedPublicKey to be created
     * @return ExtendedPublicKey Object representation of the child extended public key
     */
    public static function fromParent(string $childNum, string $chainCode, string $pubKey, ExtendedPublicKey $parent): ExtendedPublicKey
    {
        if (count($parent->parentIndeces) > 0)
            $parentIndeces = array_merge($parent->parentIndeces, [$parent->childNum]);
        else
            $parentIndeces = [$parent->childNum];
        // Increment the depth of the parent by 1, which will be the child's depth, and left-pad to length 2 (1 byte)
        $depth = dechex(hexdec($parent->depth) + 1);
        if (strlen($depth) % 2 != 0)
            $depth = '0' . $depth;
        // Child Fingerprint is equal to the first 4 bytes of the Hash160 of the parent's public key
        $fingerprint =  substr(HashUtil::hash160($parent->pubKey), 0, 8);
        return new static($parent->version, $depth, $fingerprint, $childNum, $chainCode, $pubKey, null, $parentIndeces);
    }

    /**
     * Check if a hexadecimal child number is hardened
     * 
     * Checks if a hexadecimal child number is >= 2^31 (hardened index)
     * 
     * @param  string $childNum Hexadecimal child number (4 bytes)
     * @return bool   Whether the child number is hardened
     */
    public static function isHardenedIndex(string $childNum): bool
    {
        $index = gmp_init($childNum, 16);
        return gmp_testbit($index, 31);
    }

    /**
     * Derives a child extended public key from a parent extended public key at the specified index (child number)
     * 
     * CKDPub function from <a href="https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki#public-parent-key--public-child-key">BIP32</a>
     * 
     * @param  ExtendedPublicKey $parentExtPubKey Parent ExtendedPublicKey to derive a child from
     * @param  int               $childNum        Child number index to derive the child ExtendedPublicKey at
     * @return ExtendedPublicKey Child ExtendedPublicKey derived from the given parent at the given child number index
     */
    public static function CKDpub(ExtendedPublicKey $parentExtPubKey, int $childNum): ExtendedPublicKey
    {
        // Convert the Child Number to hexadecimal and left-pad to length 8 (4 bytes)
        $childNum = dechex($childNum);
        while (strlen($childNum) < 8)
            $childNum = '0' . $childNum;
        // HMAC-SHA512 with Data = parent public key || child number, Key = parent chain code
        $hmac = hash_hmac("sha512", pack("H*", $parentExtPubKey->getPubKey()) . pack("H*", $childNum), pack("H*", $parentExtPubKey->getChainCode()));
        // Right-most 32 bytes of the HMAC result is the child's Chain Code
        $childChainCode = substr($hmac, -64);
        // Left-most 32 bytes of the HMAC result is used to tweak the parent public key to find the child Public Key
        $tweak = BitcoinECC::scalarMultiply(substr($hmac, 0, 64));
        $childPubKey = BitcoinECC::scalarAdd($parentExtPubKey->getPubKey(), $tweak);
        // Construct the new ExtendedPublicKey and return it
        $childExtPubKey = ExtendedPublicKey::fromParent($childNum, $childChainCode, $childPubKey, $parentExtPubKey);
        return $childExtPubKey;
    }

    /**
     * Get the address of this extended public key
     * 
     * @return string Encoded address of this extended public key
     */
    public function getAddress(): string
    {
        $pubKeyHash = HashUtil::hash160($this->pubKey);
        if (strtolower($this->version) === static::VERSIONS["xpub"]["hex"]) // P2PKH Address
        {
            $payload = '00' . $pubKeyHash;
            $checksum = substr(HashUtil::hash256($payload), 0, 8);
            $address = base58_encode(hex2bin($payload . $checksum));
        } else if (strtolower($this->version) === static::VERSIONS["ypub"]["hex"]) // P2SH-P2WPKH
        {
            $payload = '05' . HashUtil::hash160('0014' . $pubKeyHash);
            $checksum = substr(HashUtil::hash256($payload), 0, 8);
            $address = base58_encode(hex2bin($payload . $checksum));
        } else if (strtolower($this->version) === static::VERSIONS["zpub"]["hex"]) // P2WPKH
        {
            $address = Bech32::encode_bech32($pubKeyHash);
        }
        // Version is assumed as always valid and defined since it's checked on object creation
        return $address;
    }

    /**
     * Get the string representation of the derivation path for this extended public key
     * 
     * @return string Derivation path in string representation, ex: m/44'/0'/0'/0/5
     */
    public function getDerivationPath(): string
    {
        // Version is assumed as always valid and defined since it's checked on object creation
        $derivationPath = "";
        foreach (static::VERSIONS as $extKeyVals) {
            if (strtolower($this->version) === $extKeyVals["hex"]) {
                $derivationPath .= ($extKeyVals["path"] . "/0'");
                break;
            }
        }
        for ($i = 0; $i <= count($this->parentIndeces); $i++) {
            $lookIndex = ($i < count($this->parentIndeces)) ? $this->parentIndeces[$i] : $this->childNum;
            if (static::isHardenedIndex($lookIndex)) // is hardened? Subtract 2^31 and add ' symbol
            {
                $lookIndex = gmp_init($lookIndex, 16);
                gmp_setbit($lookIndex, 31, false);
                $derivationPath .= ("/" . strval($lookIndex) . "'");
            } else // not hardened? Just convert hexa to decimal
            {
                $derivationPath .= ("/" . hexdec($lookIndex));
            }
        }
        return $derivationPath;
    }

    /**
     * Getter for $version
     * 
     * @return string Hexadecimal version of the extended public key (4 bytes)
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Getter for $depth
     * 
     * @return string Hexadecimal depth of the extended public key (1 byte)
     */
    public function getDepth(): string
    {
        return $this->depth;
    }

    /**
     * Getter for $fingerprint
     * 
     * @return string Hexadecimal fingerprint of the extended public key (4 bytes)
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
    }

    /**
     * Getter for $childNum
     * 
     * @return string Hexadecimal child number of the extended public key (4 bytes)
     */
    public function getChildNum(): string
    {
        return $this->childNum;
    }

    /**
     * Getter for $chainCode
     * 
     * @return string Hexadecimal chain code of the extended public key (32 bytes)
     */
    public function getChainCode(): string
    {
        return $this->chainCode;
    }

    /**
     * Getter for $pubKey
     * 
     * @return string Hexadecimal public key of the extended public key in compressed DER encoding (33 bytes)
     */
    public function getPubKey(): string
    {
        return $this->pubKey;
    }

    /**
     * Getter for $encodedExtPubKey
     * 
     * @return string Base58Check encoding of the extended public key
     */
    public function getEncoded(): string
    {
        return $this->encodedExtPubKey;
    }
}

/**
 * Class containing Hash functions relevant to Bitcoin
 */
class HashUtil
{
    /**
     * Hashes hex data with SHA256 then RIPEMD160
     * 
     * Returns the RIPEMD160(SHA256) of the given data in hexadecimal.
     * Both input and output are hexadecimal values. Does <strong>NOT</strong> accept non-hexadecimal values.
     * Hexadecimal input is interpreted as bytes, not as a UTF-8 string.
     * 
     * @param  string $hexData Hexadecimal data to be hashed
     * @return string Hexadecimal result of data hashed
     */
    public static function hash160(string $hexData): string
    {
        return hash('ripemd160', hex2bin(hash('sha256', hex2bin($hexData))));
    }

    /**
     * Hashes hex data with SHA256 twice
     * 
     * Returns the SHA256(SHA256) of the given data in hexadecimal.
     * Both input and output are hexadecimal values. Does <strong>NOT</strong> accept non-hexadecimal values.
     * Hexadecimal input is interpreted as bytes, not as a UTF-8 string.
     * 
     * @param  string $hexData Hexadecimal data to be hashed
     * @return string Hexadecimal result of data hashed
     */
    public static function hash256(string $hexData): string
    {
        return hash('sha256', hex2bin(hash('sha256', hex2bin($hexData))));
    }
}

/**
 * Class for encoding and decoding Bech32 Bitcoin addresses
 */
class Bech32
{
    /**
     * @var string All Bech32 characters
     */
    const BECH32_VALS = 'qpzry9x8gf2tvdw0s3jn54khce6mua7l';

    /**
     * @var string Human-readable part for Bech32 bitcoin addresses
     */
    const HRP = 'bc';

    /**
     * Encodes a hexadecimal string into Bech32 Check encoding
     * 
     * Encodes hexadecimal data into the Bech32 encoding format, including a checksum.
     * Does <strong>NOT</strong> accept non-hexadecimal values.
     * Hexadecimal input is interpreted as bytes, not as a UTF-8 string.
     * 
     * @param  string $hexData  Hexadecimal data to be encoded
     * @return string Bech32 Check encoded string
     */
    public static function encode_bech32(string $hexData): string
    {
        $bits = '';
        for ($i = 0; $i < strlen($hexData); $i += 2) {
            $byte = gmp_strval(gmp_init(substr($hexData, $i, 2), 16), 2);
            while (strlen($byte) < 8)
                $byte = '0' . $byte;
            $bits = $bits . $byte;
        }
        while (strlen($bits) % 5 != 0)
            $bits = $bits . '0';
        $nums = [];
        for ($i = 0; $i < strlen($bits); $i += 5) {
            $num = gmp_intval(gmp_init(substr($bits, $i, 5), 2));
            array_push($nums, $num);
        }
        $nums = array_merge([0], $nums);
        $checksum = static::bech32_create_checksum(static::HRP, $nums);
        $nums = array_merge($nums, $checksum);
        if (!static::bech32_verify_checksum(static::HRP, $nums))
            throw new \Exception('Bech32 Checksum mismatch!');
        $address = static::HRP . '1';
        foreach ($nums as $num)
            $address = $address . static::BECH32_VALS[$num];
        return $address;
    }

    /**
     * Used in computing the Bech32 encoding checksum value
     * 
     * Direct translation from python code at
     * https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32
     * 
     * @param  int[] $values
     * @return int
     */
    protected static function bech32_polymod(array $values): int
    {
        $GEN = [hexdec('3b6a57b2'), hexdec('26508e6d'), hexdec('1ea119fa'), hexdec('3d4233dd'), hexdec('2a1462b3')];
        $chk = 1;
        for ($i = 0; $i < count($values); $i++) {
            $b = $chk >> 25;
            $chk = ($chk & hexdec('1ffffff')) << 5 ^ $values[$i];
            for ($y = 0; $y < 5; $y++) {
                if (($b >> $y) & 1)
                    $chk = $chk ^ $GEN[$y];
                else
                    $chk = $chk ^ 0;
            }
        }
        return $chk;
    }

    /**
     * Used in computing the Bech32 encoding checksum value
     * 
     * Direct translation from python code at
     * https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32
     * 
     * @param  string $s
     * @return int[]
     */
    protected static function bech32_hrp_expand(string $s): array
    {
        $highBits = [];
        $zeroBit = [0];
        $lowBits = [];
        for ($i = 0; $i < strlen($s); $i++) {
            $highBits[$i] = ord(substr($s, $i, 1)) >> 5;
            $lowBits[$i] = ord(substr($s, $i, 1)) & 31;
        }
        return array_merge($highBits, $zeroBit, $lowBits);
    }

    /**
     * Verifies that the Bech32 checksum is correct for the given data+checksum values
     * 
     * Direct translation from python code at
     * https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32
     * 
     * @param  string $hrp
     * @param  int[]  $data
     * @return bool
     */
    protected static function bech32_verify_checksum(string $hrp, array $data): bool
    {
        return static::bech32_polymod(array_merge(static::bech32_hrp_expand($hrp), $data)) == 1;
    }

    /**
     * Creates a Bech32 encoding checksum for the given data values
     * 
     * Direct translation from python code at
     * https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32
     * 
     * @param  string $hrp
     * @param  int[]  $data
     * @return int[]
     */
    protected static function bech32_create_checksum(string $hrp, array $data): array
    {
        $values = array_merge(static::bech32_hrp_expand($hrp), $data);
        $polymod = static::bech32_polymod(array_merge($values, [0, 0, 0, 0, 0, 0])) ^ 1;
        $checksum = [];
        for ($i = 0; $i < 6; $i++)
            $checksum[$i] = ($polymod >> 5 * (5 - $i)) & 31;
        return $checksum;
    }
}

/**
 * Singleton design pattern implementation
 * 
 * Defines a "getInstance" method that serves as an alternate constructor and lets clients
 * utilize the same instance of classes inheriting Singleton over and over, 
 * with only 1 instance of each class ever existing at a given time.
 */
class Singleton
{
    /**
     * @var array List of all known instances
     */
    private static $instances = [];

    /**
     * Empty constructor method
     */
    protected function __construct()
    {
    }

    /**
     * Empty clone method, singletons should not be able to be cloned
     */
    protected function __clone()
    {
    }

    /**
     * Prevent wakeup call
     * 
     * @throws \Exception if called, because Singletons cannot be unserialized
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize singleton');
    }

    /**
     * Get the Singleton's instance
     * 
     * @return mixed
     */
    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass]))
            self::$instances[$subclass] = new static;
        return self::$instances[$subclass];
    }
}

/**
 * Class that contains static helper utilities for performing calculations along the SECP256K1 elliptic curve
 * 
 * The SECP256K1 curve is y^2 = x^3 + ax + b over F_p, with F_p defined by p = 2^256 - 2^32 - 2^9 - 2^8 - 2^7 - 2^4 - 1
 * and a = 0, b = 7. Since we are not generating or dealing with private keys, n does not need to be defined here.
 * Functions are modified versions from https://github.com/BitcoinPHP/BitcoinECDSA.php which is in the public domain
 */
class BitcoinECC extends Singleton
{
    /**
     * Values for the SECP256K1 elliptic curve
     */
    protected $a, $b, $p, $G;

    /**
     * Initializes elliptic curve values
     */
    protected function __construct()
    {
        $this->a = gmp_init('0', 10);
        $this->b = gmp_init('7', 10);
        $this->p = gmp_init('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFEFFFFFC2F', 16);
        $this->G = [
            'x' => gmp_init('55066263022277343669578718895168534326250603453777594175500187360389116729240'),
            'y' => gmp_init('32670510020758816978083085130507043184471273380659243275938904335757337482424')
        ];
    }

    /**
     * Wrapper function for mulPoint()
     * 
     * Calculates a public key from the given private key, $k, and returns the public key.
     * If specified, encodes the public key to DER encoding.
     * By default, returns an array of points. Uses the generator point G as the point to multiply.
     * 
     * @param  string          $k          Hexadecimal private key (32 bytes)
     * @param  bool            $derEncode  (optional, default = false) Whether the given public key should be DER encoded
     * @return string[]|string Array of hexadecimal x,y points (32 bytes each), or a compressed DER encoded public key
     */
    public static function scalarMultiply(string $k, bool $derEncode = false)
    {
        $instance = static::getInstance();
        $K = $instance->mulPoint($k, ['x' => $instance->G['x'], 'y' => $instance->G['y']]);
        return ($derEncode) ? $instance->pointsToPubKey($K) : $K;
    }

    /**
     * Wrapper function for addPoints()
     * 
     * Calculates a public key by adding two public keys together, and returns the new public key.
     * If specified, encodes the new public key to DER encoding.
     * Automatically detects if a point array or a DER encoded public key is given as the points.
     * By default, returns a DER encoded public key.
     * 
     * @param  string[]|string $point1    First public key in either x,y points array (32 bytes each) or compressed DER encoding
     * @param  string[]|string $point2    Second public key in either x,y points array (32 bytes each) or compressed DER encoding
     * @param  bool            $derEncode (optional, default = true) Whether the resulting public key should be DER encoded
     * @return string[]|string Resulting public key of $point1 + $point2 in either x,y points array or compressed DER encoding
     */
    public static function scalarAdd($point1, $point2, bool $derEncode = true)
    {
        $instance = static::getInstance();
        if (!is_array($point1))
            $point1 = $instance->pubKeyToPoints($point1);
        if (!is_array($point2))
            $point2 = $instance->pubKeyToPoints($point2);
        $K = $instance->addPoints($point1, $point2);
        return ($derEncode) ? $instance->pointsToPubKey($K) : $K;
    }

    /**
     * Returns the public key resulting from doubling it
     * 
     * Computes the result of point doubling and returns the resulting point as an Array.
     * 
     * @param  string[]   $pt Point to be doubled given in hexadecimal x,y array (32 bytes each)
     * @return string[]   Hexadecimal x,y points array (32 bytes each)
     * @throws \Exception if the point is at infinity
     */
    protected function doublePoint(array $pt): array
    {
        $gcd = gmp_strval(gmp_gcd(gmp_mod(gmp_mul(gmp_init(2, 10), $pt['y']), $this->p), $this->p));
        if ($gcd !== '1')
            throw new \Exception('Points at infinity are not supported. See https://github.com/BitcoinPHP/BitcoinECDSA.php/issues/9');
        // SLOPE = (3 * ptX^2 + a )/( 2*ptY )
        // Equals (3 * ptX^2 + a ) * ( 2*ptY )^-1
        $slope = gmp_mod(gmp_mul(gmp_invert(gmp_mod(gmp_mul(gmp_init(2, 10), $pt['y']), $this->p), $this->p), gmp_add(gmp_mul(gmp_init(3, 10), gmp_pow($pt['x'], 2)), $this->a)), $this->p);
        // nPtX = slope^2 - 2 * ptX
        // Equals slope^2 - ptX - ptX
        $nPt = [];
        $nPt['x'] = gmp_mod(gmp_sub(gmp_sub(gmp_pow($slope, 2), $pt['x']), $pt['x']), $this->p);
        // nPtY = slope * (ptX - nPtx) - ptY
        $nPt['y'] = gmp_mod(gmp_sub(gmp_mul($slope, gmp_sub($pt['x'], $nPt['x'])), $pt['y']), $this->p);
        return $nPt;
    }

    /**
     * Returns the public key resulting from the addition of two public keys
     * 
     * Computes the result of a point addition and returns the resulting point as an array of x,y hexadecimal values (32 bytes each).
     *
     * @param  string[]   $pt1 First public key in x,y points array (32 bytes each)
     * @param  string[]   $pt2 Second public key in x,y points array (32 bytes each)
     * @return string[]   Resulting public key of $point1 + $point2 in x,y points array
     * @throws \Exception if the point is at infinity
     */
    protected function addPoints(array $pt1, array $pt2): array
    {
        if (gmp_cmp($pt1['x'], $pt2['x']) === 0  && gmp_cmp($pt1['y'], $pt2['y']) === 0) //if identical
            return $this->doublePoint($pt1);
        $gcd = gmp_strval(gmp_gcd(gmp_sub($pt1['x'], $pt2['x']), $this->p));
        if ($gcd !== '1')
            throw new \Exception('Points at infinity are not supported. See https://github.com/BitcoinPHP/BitcoinECDSA.php/issues/9');
        // SLOPE = (pt1Y - pt2Y)/( pt1X - pt2X )
        // Equals (pt1Y - pt2Y) * ( pt1X - pt2X )^-1
        $slope = gmp_mod(gmp_mul(gmp_sub($pt1['y'], $pt2['y']), gmp_invert(gmp_sub($pt1['x'], $pt2['x']), $this->p)), $this->p);
        // nPtX = slope^2 - ptX1 - ptX2
        $nPt = [];
        $nPt['x'] = gmp_mod(gmp_sub(gmp_sub(gmp_pow($slope, 2), $pt1['x']), $pt2['x']), $this->p);
        // nPtX = slope * (ptX1 - nPtX) - ptY1
        $nPt['y'] = gmp_mod(gmp_sub(gmp_mul($slope, gmp_sub($pt1['x'], $nPt['x'])), $pt1['y']), $this->p);
        return $nPt;
    }

    /**
     * Return whether the given coordinates are on the SECP256K1 curve
     * 
     * @param  string $x Hexadecimal point value (32 bytes)
     * @param  string $y Hexadecimal point value (32 bytes)
     * @return bool   Whether the point is on the SECP256K1 elliptic curve
     */
    protected function validatePoint(string $x, string $y): bool
    {
        $x = gmp_init($x, 16);
        $y2 = gmp_mod(gmp_add(gmp_add(gmp_powm($x, gmp_init(3, 10), $this->p), gmp_mul($this->a, $x)), $this->b), $this->p);
        $y = gmp_mod(gmp_pow(gmp_init($y, 16), 2), $this->p);
        if (gmp_cmp($y2, $y) === 0)
            return true;
        else
            return false;
    }

    /**
     * Returns the public key points corresponding to the given private key
     * 
     * Computes the result of a point multiplication and returns the resulting point as an array of x,y hexadecimal values (32 bytes each).
     *
     * @param  string     $k  Hexadecimal private key value (32 bytes)
     * @param  string[]   $pG Generator point in x,y point array (32 bytes each)
     * @return string[]   Array of hexadecimal x,y points (32 bytes each)
     * @throws \Exception if the resulting point is not on the curve
     */
    protected function mulPoint(string $k, array $pG): array
    {
        //in order to calculate k*G
        $k = gmp_init($k, 16);
        $kBin = gmp_strval($k, 2);
        $lastPoint = $pG;
        for ($i = 1; $i < strlen($kBin); $i++) {
            if (substr($kBin, $i, 1) === '1') {
                $dPt = $this->doublePoint($lastPoint);
                $lastPoint = $this->addPoints($dPt, $pG);
            } else {
                $lastPoint = $this->doublePoint($lastPoint);
            }
        }
        if (!$this->validatePoint(gmp_strval($lastPoint['x'], 16), gmp_strval($lastPoint['y'], 16)))
            throw new \Exception('The resulting point is not on the curve.');
        return $lastPoint;
    }

    /**
     * Equivalent to sqrt(num) % p
     * 
     * Calculates the square root of $num mod p and returns the 2 solutions as an array.
     *
     * @param  resource        $num GMP number to take mod square root of
     * @return resource[]|null Array of two GMP integers, or null if no solution exists
     */
    protected function mod_sqrt($num)
    {
        if (gmp_legendre($num, $this->p) !== 1) //no result
            return null;
        $sqrt1 = gmp_powm(
            $num,
            gmp_div_q(gmp_add($this->p, gmp_init(1, 10)), gmp_init(4, 10)),
            $this->p
        );
        // there are always 2 results for a square root
        // In an infinite number field you have -2^2 = 2^2 = 4
        // In a finite number field you have a^2 = (p-a)^2
        $sqrt2 = gmp_mod(gmp_sub($this->p, $sqrt1), $this->p);
        return [$sqrt1, $sqrt2];
    }

    /**
     * Calculate the Y coordinates for a given X coordinate
     *
     * @param  string      $x       Hexadecimal x value of a point (32 bytes)
     * @param  string      $derCode Hexadecimal value of either 0x02 (even) or 0x03 (odd)
     * @return string|null Resulting Y coordinate, null if no result or invalid $derCode
     */
    protected function calculateYWithX(string $x, string $derCode)
    {
        $x = gmp_init($x, 16);
        $y2 = gmp_mod(gmp_add(gmp_add(gmp_powm($x, gmp_init(3, 10), $this->p), gmp_mul($this->a, $x)), $this->b), $this->p);
        $y = $this->mod_sqrt($y2);
        if ($y === null) //if there is no result
            return null;
        if ($derCode === '02') // even
        {
            $resY = null;
            if (gmp_strval(gmp_mod($y[0], gmp_init(2, 10)), 10) === '0')
                $resY = gmp_strval($y[0], 16);
            if (gmp_strval(gmp_mod($y[1], gmp_init(2, 10)), 10) === '0')
                $resY = gmp_strval($y[1], 16);
            if ($resY !== null) {
                while (strlen($resY) < 64) {
                    $resY = '0' . $resY;
                }
            }
            return $resY;
        } else if ($derCode === '03') // odd
        {
            $resY = null;
            if (gmp_strval(gmp_mod($y[0], gmp_init(2, 10)), 10) === '1')
                $resY = gmp_strval($y[0], 16);
            if (gmp_strval(gmp_mod($y[1], gmp_init(2, 10)), 10) === '1')
                $resY = gmp_strval($y[1], 16);
            if ($resY !== null) {
                while (strlen($resY) < 64) {
                    $resY = '0' . $resY;
                }
            }
            return $resY;
        }
        return null;
    }

    /**
     * Converts a DER encoded public key to an array of x, y coordinates
     *
     * @param  string     $derPubKey Compressed or uncompressed DER encoded public key
     * @return array      Array of x,y hexadecimal points (32 bytes each)
     * @throws \Exception if the given string is not valid DER encoding
     */
    protected function pubKeyToPoints(string $derPubKey): array
    {
        if (substr($derPubKey, 0, 2) === '04' && strlen($derPubKey) === 130) {
            //uncompressed DER encoded public key
            $x = substr($derPubKey, 2, 64);
            $y = substr($derPubKey, 66, 64);
            return ['x' => gmp_init($x, 16), 'y' => gmp_init($y, 16)];
        } else if ((substr($derPubKey, 0, 2) === '02' || substr($derPubKey, 0, 2) === '03') && strlen($derPubKey) === 66) {
            //compressed DER encoded public key
            $x = substr($derPubKey, 2, 64);
            $y = $this->calculateYWithX($x, substr($derPubKey, 0, 2));
            return ['x' => gmp_init($x, 16), 'y' => gmp_init($y, 16)];
        } else {
            throw new \Exception('Invalid DER Encoded PubKey format : ' . $derPubKey);
        }
    }

    /**
     * Converts an array of x, y coordinates to a DER encoded public key
     *
     * @param  array      $pubKeyPts Array of x,y hexadecimal points (32 bytes each)
     * @return string     Compressed DER encoded public key
     */
    protected function pointsToPubKey(array $pubKeyPts): string
    {
        $x = gmp_strval($pubKeyPts['x'], 16);
        $y = gmp_strval($pubKeyPts['y'], 16);
        while (strlen($x) < 64) {
            $x = '0' . $x;
        }
        while (strlen($y) < 64) {
            $y = '0' . $y;
        }
        if (gmp_strval(gmp_mod(gmp_init($y, 16), gmp_init(2, 10))) === '0')
            $compressedPubKey = '02' . $x;    //if $pubKey['y'] is even
        else
            $compressedPubKey = '03' . $x;    //if $pubKey['y'] is odd
        return $compressedPubKey;
    }
}
