<?php

/**
 * File to initiate all tests for getBTC.php 
 * 
 * @package Test
 * @license https://github.com/EAWF/getBTCAddress/blob/master/LICENSE   Unlicense License
 * @author  Carson Mullins (https://github.com/Septem151) <carsonmullins@yahoo.com>   
 * @author  Bob Holden (https://github.com/EAWF) <bob@eawf.com>
 * @author  Jan Moritz Lindemann (https://github.com/rgex)
 */

require_once(__DIR__ . '/../getBTC.php');

/**
 * Runs tests for the getBTCAddress function
 * 
 * Tests all test vectors and makes sure for each xpub, ypub, and zpub, the appropriate address is derived
 * and that the derivation path matches what is expected.
 */
function getBTCAddressFunctionTest()
{
    $xpubs = BTCTestVectors::getXpubs();
    $ypubs = BTCTestVectors::getYpubs();
    $zpubs = BTCTestVectors::getZpubs();
    $expectedXpubAddresses = BTCTestVectors::getExpectedXpubAddresses();
    $expectedYpubAddresses = BTCTestVectors::getExpectedYpubAddresses();
    $expectedZpubAddresses = BTCTestVectors::getExpectedZpubAddresses();
    $expectedXpubDerPaths = BTCTestVectors::getExpectedXpubDerPaths();
    $expectedYpubDerPaths = BTCTestVectors::getExpectedYpubDerPaths();
    $expectedZpubDerPaths = BTCTestVectors::getExpectedZpubDerPaths();
    TestLogger::newLogFile('test_results', 'test_getBTCAddress_results.txt');

    // Test that xpub are working correctly
    for ($i = 0; $i < count($xpubs); $i++) {
        $accountExtPubKey = ExtendedPublicKey::fromEncoded($xpubs[$i]);
        $externalExtPubKey = ExtendedPublicKey::CKDpub($accountExtPubKey, 0);
        TestLogger::log("Testing: " . $xpubs[$i]);
        for ($childNum = 0; $childNum < count($expectedXpubAddresses[$i]); $childNum++) {
            $coinExtPubKey = ExtendedPublicKey::CKDpub($externalExtPubKey, $childNum);
            $address = $coinExtPubKey->getAddress();
            $expectedAddress = $expectedXpubAddresses[$i][$childNum];
            $derPath = $coinExtPubKey->getDerivationPath();
            $expectedDerPath = $expectedXpubDerPaths[$i] . "/$childNum";
            TestLogger::log("Child Number: $childNum\n\tExpected Derivation: $expectedDerPath\n\tActual Derivation:   $derPath" .
                "\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
            if (strcmp($expectedAddress, $address) !== 0) {
                $error = "\nxpub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Address: " . $expectedAddress . "\n\tActual Address: " . $address . "\n";
                TestLogger::logError($error);
            }
            if (strcmp($expectedDerPath, $derPath) !== 0) {
                $error = "\nxpub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Derivation: " . $expectedDerPath . "\n\tActual Derivation: " . $derPath . "\n";
                TestLogger::logError($error);
            }
        }
        TestLogger::logNewLine();
    }

    // Test that ypub are working correctly
    for ($i = 0; $i < count($ypubs); $i++) {
        $accountExtPubKey = ExtendedPublicKey::fromEncoded($ypubs[$i]);
        $externalExtPubKey = ExtendedPublicKey::CKDpub($accountExtPubKey, 0);
        TestLogger::log("Testing: " . $ypubs[$i]);
        for ($childNum = 0; $childNum < count($expectedYpubAddresses[$i]); $childNum++) {
            $coinExtPubKey = ExtendedPublicKey::CKDpub($externalExtPubKey, $childNum);
            $address = $coinExtPubKey->getAddress();
            $expectedAddress = $expectedYpubAddresses[$i][$childNum];
            $derPath = $coinExtPubKey->getDerivationPath();
            $expectedDerPath = $expectedYpubDerPaths[$i] . "/$childNum";
            TestLogger::log("Child Number: $childNum\n\tExpected Derivation: $expectedDerPath\n\tActual Derivation:   $derPath" .
                "\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
            if (strcmp($expectedAddress, $address) !== 0) {
                $error = "\nypub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Address: " . $expectedAddress . "\n\tActual Address: " . $address . "\n";
                TestLogger::logError($error);
            }
            if (strcmp($expectedDerPath, $derPath) !== 0) {
                $error = "\nypub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Derivation: " . $expectedDerPath . "\n\tActual Derivation: " . $derPath . "\n";
                TestLogger::logError($error);
            }
        }
        TestLogger::logNewLine();
    }

    // Test that zpub are working correctly
    for ($i = 0; $i < count($zpubs); $i++) {
        $accountExtPubKey = ExtendedPublicKey::fromEncoded($zpubs[$i]);
        $externalExtPubKey = ExtendedPublicKey::CKDpub($accountExtPubKey, 0);
        TestLogger::log("Testing: " . $zpubs[$i]);
        for ($childNum = 0; $childNum < count($expectedZpubAddresses[$i]); $childNum++) {
            $coinExtPubKey = ExtendedPublicKey::CKDpub($externalExtPubKey, $childNum);
            $address = $coinExtPubKey->getAddress();
            $expectedAddress = $expectedZpubAddresses[$i][$childNum];
            $derPath = $coinExtPubKey->getDerivationPath();
            $expectedDerPath = $expectedZpubDerPaths[$i] . "/$childNum";
            TestLogger::log("Child Number: $childNum\n\tExpected Derivation: $expectedDerPath\n\tActual Derivation:   $derPath" .
                "\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
            if (strcmp($expectedAddress, $address) !== 0) {
                $error = "\nzpub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Address: " . $expectedAddress . "\n\tActual Address: " . $address . "\n";
                TestLogger::logError($error);
            }
            if (strcmp($expectedDerPath, $derPath) !== 0) {
                $error = "\nzpub test failed for: " . $accountExtPubKey->getEncoded() . " at childNum " . $childNum;
                $error .= "\n\tExpected Derivation: " . $expectedDerPath . "\n\tActual Derivation: " . $derPath . "\n";
                TestLogger::logError($error);
            }
        }
        TestLogger::logNewLine();
    }
    if (!TestLogger::raiseExceptionIfFailure()) {
        TestLogger::log("\nAll Tests Passed");
        TestLogger::close();
    }
}

/**
 * Runs tests for usage of the getBTCAddress function
 * 
 * Generates a mock getBTC.conf file and creates entries for each xpub, ypub, and zpub in the test vectors.
 * Verifies that each address derived using the getBTC.conf file is as expected.
 */
function getBTCAddressUsageTest()
{
    $xpubs = BTCTestVectors::getXpubs();
    $ypubs = BTCTestVectors::getYpubs();
    $zpubs = BTCTestVectors::getZpubs();
    $expectedXpubAddresses = BTCTestVectors::getExpectedXpubAddresses();
    $expectedYpubAddresses = BTCTestVectors::getExpectedYpubAddresses();
    $expectedZpubAddresses = BTCTestVectors::getExpectedZpubAddresses();
    // Declare names (more than necessary to facilitate further test vectors being added)
    $names = [
        "Alice", "Bob", "Charlie", "Dena", "Eve", "Frank", "Gary", "Henry", "Irene",
        "Jack", "Kyle", "Luke", "Mark", "Nick", "Oscar", "Paul", "Quincy", "Robert",
        "Sue", "Tom", "Ursula", "Victor", "Will", "Xavier", "Yana", "Zoe"
    ];

    TestLogger::newLogFile('test_results', 'test_getBTCAddressUsage_results.txt');

    // Create a getBTC.conf file and write test data
    $fileHandle = fopen('getBTC.conf', 'w');
    for ($i = 0; $i < count($xpubs); $i++) {
        fwrite($fileHandle, $names[$i] . "_xpub:" . $xpubs[$i] . "\n");
    }
    for ($i = 0; $i < count($ypubs); $i++) {
        fwrite($fileHandle, $names[$i] . "_ypub:" . $ypubs[$i] . "\n");
    }
    for ($i = 0; $i < count($zpubs); $i++) {
        fwrite($fileHandle, $names[$i] . "_zpub:" . $zpubs[$i] . "\n");
    }
    fclose($fileHandle);

    try {
        // Test against expected xpub addresses
        TestLogger::log("Testing xpub address derivation");
        for ($i = 0; $i < count($xpubs); $i++) {
            $name = $names[$i] . "_xpub";
            TestLogger::log("Testing name $name using xpub of " . $xpubs[$i]);
            for ($y = 0; $y < count($expectedXpubAddresses); $y++) {
                $expectedAddress = $expectedXpubAddresses[$i][$y];
                $address = getBTCAddress($name, $y);
                TestLogger::log("Child Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
                if (strcmp($expectedAddress, $address) !== 0) {
                    $error = "\nxpub test failed for $name using xpub of " . $xpubs[$i] .
                        "\n\tChild Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address";
                    TestLogger::logError($error);
                }
            }
            TestLogger::logNewLine();
        }

        // Test against expected ypub addresses
        TestLogger::log("Testing ypub address derivation");
        for ($i = 0; $i < count($ypubs); $i++) {
            $name = $names[$i] . "_ypub";
            TestLogger::log("Testing name $name using ypub of " . $ypubs[$i]);
            for ($y = 0; $y < count($expectedYpubAddresses); $y++) {
                $expectedAddress = $expectedYpubAddresses[$i][$y];
                $address = getBTCAddress($name, $y);
                TestLogger::log("Child Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
                if (strcmp($expectedAddress, $address) !== 0) {
                    $error = "\nypub test failed for $name using ypub of " . $ypubs[$i] .
                        "\n\tChild Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address";
                    TestLogger::logError($error);
                }
            }
            TestLogger::logNewLine();
        }

        // Test against expected zpub addresses
        TestLogger::log("Testing zpub address derivation");
        for ($i = 0; $i < count($zpubs); $i++) {
            $name = $names[$i] . "_zpub";
            TestLogger::log("Testing name $name using zpub of " . $zpubs[$i]);
            for ($y = 0; $y < count($expectedZpubAddresses); $y++) {
                $expectedAddress = $expectedZpubAddresses[$i][$y];
                $address = getBTCAddress($name, $y);
                TestLogger::log("Child Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address");
                if (strcmp($expectedAddress, $address) !== 0) {
                    $error = "\nzpub test failed for $name using zpub of " . $zpubs[$i] .
                        "\n\tChild Number: $y\n\tExpected Address: $expectedAddress\n\tActual Address:   $address";
                    TestLogger::logError($error);
                }
            }
            TestLogger::logNewLine();
        }
    } catch (\Exception $e) {
        // If any other Exception is thrown that was not accounted for, catch it and report a failure
        TestLogger::logError($e->getMessage());
    } finally {
        // Close the getBTC.conf file
        unlink('getBTC.conf');
        if (!TestLogger::raiseExceptionIfFailure()) {
            TestLogger::log("\nAll Tests Passed");
            TestLogger::close();
        }
    }
}

/**
 * Runs tests for the getBTCBalance function
 * 
 * Tests first address in each test vector address formats to make sure that the function works as intended. Unfortunately due to the ever-changing
 * nature of UTXOs in the Bitcoin Blockchain, there is no way to test that the amount returned from the function is correct.
 * Doing so would make this test dependent upon keeping an address unused forever, otherwise tests would always fail.
 */
function getBTCBalanceFunctionTest()
{
    TestLogger::newLogFile('test_results', 'test_getBTCBalance_results.txt');
    // Test first addresses in vectors.json
    $addresses = [
        BTCTestVectors::getExpectedXpubAddresses()[0][0],
        BTCTestVectors::getExpectedYpubAddresses()[0][0],
        BTCTestVectors::getExpectedZpubAddresses()[0][0]
    ];
    foreach ($addresses as $address) {
        try {
            // Test with 0 confirmations
            $balance = getBTCBalance($address);
            if ($balance === null)
                throw new \Exception("Amount was null");
            else
                TestLogger::log("Address " . $address . " returned a valid balance with 0 confirmations.");
            // Sleep 0.5 second between each call to avoid rate limits
            usleep(500000);
            // Test with 6 confirmations
            $balance = getBTCBalance($address, 6);
            if ($balance === null)
                throw new \Exception("Amount was null");
            else
                TestLogger::log("Address " . $address . " returned a valid balance with 6 confirmations.");
            // Sleep 0.5 second between each call to avoid rate limits
            usleep(500000);
        } catch (\Exception $e) {
            TestLogger::logError("\nError in getBTCBalance for address: $address\n" . $e->getMessage() . "\n");
        }
    }
    if (!TestLogger::raiseExceptionIfFailure()) {
        TestLogger::log("\nAll tests passed");
        TestLogger::close();
    }
}

/**
 * Runs tests for the getBTCInvoice function
 * 
 * Tests first address in each test vector address formats to make sure that getBTCInvoice function works as intended.
 */
function getBTCInvoiceFunctionTest()
{
    TestLogger::newLogFile('test_results', 'test_getBTCInvoice_results.txt');
    // Test All Addresses in vectors.json
    $addresses = [
        BTCTestVectors::getExpectedXpubAddresses()[0][0],
        BTCTestVectors::getExpectedYpubAddresses()[0][0],
        BTCTestVectors::getExpectedZpubAddresses()[0][0]
    ];
    foreach ($addresses as $address) {
        try {
            // Try with just address
            $invoice = getBTCInvoice($address);
            $expected_invoice = "bitcoin:" . $address;
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address and amount == 0.005
            $amount = 0.005;
            $invoice = getBTCInvoice($address, $amount);
            $expected_invoice = "bitcoin:" . $address . "?amount=0.005";
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address and amount == 0
            $amount = 0;
            $invoice = getBTCInvoice($address, $amount);
            $expected_invoice = "bitcoin:" . $address;
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address and amount < 0
            $amount = -0.005;
            $invoice = getBTCInvoice($address, $amount);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address and amount == 0.005 and a label
            $amount = 0.005;
            $label = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label);
            $expected_invoice = "bitcoin:" . $address . "?amount=0.005&label=" . urlencode($label);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address, amount == 0, and a label
            $amount = 0;
            $label = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label);
            $expected_invoice = "bitcoin:" . $address . "?label=" . urlencode($label);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address, amount == 0, and a message
            $amount = 0;
            $label = '';
            $message = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label, $message);
            $expected_invoice = "bitcoin:" . $address . "?message=" . urlencode($message);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address, amount == 0.005, and a message
            $amount = 0.005;
            $label = '';
            $message = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label, $message);
            $expected_invoice = "bitcoin:" . $address . "?amount=0.005&message=" . urlencode($message);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address, amount == 0, a label, and a message
            $amount = 0;
            $label = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $message = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label, $message);
            $expected_invoice = "bitcoin:" . $address . "?label=" . urlencode($label) . "&message=" . urlencode($message);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
            // Try with address, amount == 0.005, a label, and a message
            $amount = 0.005;
            $label = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $message = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&\'()*+,;= \\`%';
            $invoice = getBTCInvoice($address, $amount, $label, $message);
            $expected_invoice = "bitcoin:" . $address . "?amount=0.005&label=" . urlencode($label) . "&message=" . urlencode($message);
            if (strcmp($invoice, $expected_invoice) === 0)
                TestLogger::log("Invoice for Address " . $address . " matched expected invoice of " . $expected_invoice);
            else
                throw new \Exception("Invoice for Address " . $address . " did not match expected Invoice.\n\tExpected: " . $expected_invoice . "\n\tActual:   " . $invoice);
        } catch (\Exception $e) {
            TestLogger::logError("\n" . $e->getMessage() . "\n");
        }
    }
    if (!TestLogger::raiseExceptionIfFailure()) {
        TestLogger::log("\nAll tests passed");
        TestLogger::close();
    }
}

/**
 * Runs tests for the getBTCRate function
 * 
 * Tests various amounts with the getBTCRate function. Unable to test exact value amounts returned since bitcoin price fluctuates.
 */
/*
function getBTCRateFunctionTest()
{
    TestLogger::newLogFile('test_results', 'test_getBTCRate_results.txt');
    try {
        // Try function with no args
        $rate = getBTCRate();
        if ($rate === null)
            throw new \Exception("getBTCRate with no args failed");
        else
            TestLogger::log("getBTCRate with no args passed");
        // Sleep 0.5 secs between queries to avoid rate limits
        usleep(500000);
        // Try function with amount == 0
        $rate = getBTCRate(0);
        if ($rate === null)
            throw new \Exception("getBTCRate with amount == 0 failed");
        else
            TestLogger::log("getBTCRate with amount == 0 passed");
        // Sleep 0.5 secs between queries to avoid rate limits
        usleep(500000);
        // Try function with amount > 0
        $rate = getBTCRate(15.99);
        if ($rate === null)
            throw new \Exception("getBTCRate with amount > 0 failed");
        else
            TestLogger::log("getBTCRate with amount > 0 passed");
        // Sleep 0.5 secs between queries to avoid rate limits
        usleep(500000);
        // Try function with amount < 0
        $rate = getBTCRate(-15.99);
        if ($rate === null)
            throw new \Exception("getBTCRate with amount < 0 failed");
        else
            TestLogger::log("getBTCRate with amount < 0 passed");
    } catch (\Exception $e) {
        TestLogger::logError("\n" . $e->getMessage() . "\n");
    }
    if (!TestLogger::raiseExceptionIfFailure()) {
        TestLogger::log("\nAll tests passed");
        TestLogger::close();
    }
}
*/

/**
 * Singleton class containing test vector data for all tests
 * 
 * A file must exist within the same directory as this file called "vectors.json".
 * The test vectors must include keys for "xpubs", "ypubs", "zpubs", "expected_xpub_addresses", "expected_ypub_addresses",
 * "expected_zpub_addresses", "expected_xpub_derivation_paths", "expected_ypub_derivation_paths", and "expected_zpub_derivation_paths".
 * Each key must contain an array. "xpub", "ypub", and "zpub" must have equal length arrays. For each extended public key, there should be 
 * exactly one sub-array within the respective expected addresses array. For each extended public key, There should be exactly one expected derivation path
 * for each respective extended public key type.
 */
class BTCTestVectors extends \Singleton
{
    /**
     * Variables containing arrays of extended public keys
     */
    protected $xpubs, $ypubs, $zpubs;

    /**
     * Variables containing expected addresses of the extended public keys, derived in sequential order starting at 0
     */
    protected $expectedXpubAddresses, $expectedYpubAddresses, $expectedZpubAddresses;

    /**
     * Variables containing expected derivation paths for the extended public keys
     */
    protected $expectedXpubDerPaths, $expectedYpubDerPaths, $expectedZpubDerPaths;

    /**
     * Constructor for the Vectors class
     * 
     * Reads from the "vectors.json" file and assigns values to variables.
     */
    protected function __construct()
    {
        $filepath = dirname(__FILE__) . "/vectors.json";
        TestLogger::newLogFile('test_results', 'test_vectorsPrecheck_results.txt');
        if (!file_exists($filepath)) {
            TestLogger::logError("Vectors file does not exist! Path: " . $filepath);
            TestLogger::raiseExceptionIfFailure();
        }
        $vectors_file = file_get_contents($filepath);
        if ($vectors_file === false) {
            TestLogger::logError("Error reading from vectors file! Path: " . $filepath . "\nVector File: " . $vectors_file);
            TestLogger::raiseExceptionIfFailure();
        }
        try {
            $vectors = json_decode($vectors_file, true);
            $this->xpubs = $vectors['xpubs'];
            $this->ypubs = $vectors['ypubs'];
            $this->zpubs = $vectors['zpubs'];
            $this->expectedXpubAddresses = $vectors['expected_xpub_addresses'];
            $this->expectedYpubAddresses = $vectors['expected_ypub_addresses'];
            $this->expectedZpubAddresses = $vectors['expected_zpub_addresses'];
            $this->expectedXpubDerPaths = $vectors['expected_xpub_derivation_paths'];
            $this->expectedYpubDerPaths = $vectors['expected_ypub_derivation_paths'];
            $this->expectedZpubDerPaths = $vectors['expected_zpub_derivation_paths'];
        } catch (\Exception $e) {
            TestLogger::logError("Invalid json syntax or missing required fields. Error: " . $e);
        }
        if (!TestLogger::raiseExceptionIfFailure())
            TestLogger::log("Vectors precheck passed");
    }

    /**
     * Get the xpubs used as test vectors
     * 
     * @return string[] Array of xpubs
     */
    public static function getXpubs()
    {
        $vectors = static::getInstance();
        return $vectors->xpubs;
    }

    /**
     * Get the ypubs used as test vectors
     * 
     * @return string[] Array of ypubs
     */
    public static function getYpubs()
    {
        $vectors = static::getInstance();
        return $vectors->ypubs;
    }

    /**
     * Get the zpubs used as test vectors
     * 
     * @return string[] Array of zpubs
     */
    public static function getZpubs()
    {
        $vectors = static::getInstance();
        return $vectors->zpubs;
    }

    /**
     * Get an array of expected xpub addresses used as test vectors
     * 
     * @return array[] Array of expected xpub addresses in an array
     */
    public static function getExpectedXpubAddresses()
    {
        $vectors = static::getInstance();
        return $vectors->expectedXpubAddresses;
    }

    /**
     * Get an array of expected ypub addresses used as test vectors
     * 
     * @return array[] Array of expected ypub addresses in an array
     */
    public static function getExpectedYpubAddresses()
    {
        $vectors = static::getInstance();
        return $vectors->expectedYpubAddresses;
    }

    /**
     * Get an array of expected zpub addresses used as test vectors
     * 
     * @return array[] Array of expected zpub addresses in an array
     */
    public static function getExpectedZpubAddresses()
    {
        $vectors = static::getInstance();
        return $vectors->expectedZpubAddresses;
    }

    /**
     * Get the expected xpub derivation paths used as test vectors
     * 
     * @return string[] Array of xpub derivation paths
     */
    public static function getExpectedXpubDerPaths()
    {
        $vectors = static::getInstance();
        return $vectors->expectedXpubDerPaths;
    }

    /**
     * Get the expected ypub derivation paths used as test vectors
     * 
     * @return string[] Array of ypub derivation paths
     */
    public static function getExpectedYpubDerPaths()
    {
        $vectors = static::getInstance();
        return $vectors->expectedYpubDerPaths;
    }

    /**
     * Get the expected zpub derivation paths used as test vectors
     * 
     * @return string[] Array of zpub derivation paths
     */
    public static function getExpectedZpubDerPaths()
    {
        $vectors = static::getInstance();
        return $vectors->expectedZpubDerPaths;
    }
}

/**
 * Singleton Base logger to write to log files
 * 
 * Should only be extended, should not be used directly. See {@see TestLogger} for usage.
 */
class Logger extends Singleton
{
    /**
     * Logger properties
     */
    protected $logFile, $logDir, $fileHandle, $defaultLogFile, $defaultLogDir;

    /**
     * Constructor for a base Logger
     */
    protected function __construct()
    {
        $this->defaultLogFile = 'logs.txt';
        $this->defaultLogDir = 'test_results';
    }

    /**
     * Writes to a log file
     * 
     * @param string $message Message to write to the log file
     */
    protected function writeLog(string $message)
    {
        if (empty($this->logFile))
            $this->setLogFile($this->defaultLogDir, $this->defaultLogFile);
        fwrite($this->fileHandle, "$message\n");
    }

    /**
     * Sets the log file to write to
     * 
     * If the log file does not exist, it is created. If the directory does not exist, the directory is created.
     * 
     * @param $logDir  Directory where the log file is located
     * @param $logFile Name of the log file within the specified log directory
     */
    protected function setLogFile($logDir, $logFile)
    {
        if (!empty($this->logFile)) {
            fclose($this->fileHandle);
        }
        $this->logFile = $logFile;
        $this->logDir = $logDir;
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        $this->fileHandle = fopen("$logDir/$logFile", 'w');
    }

    /**
     * Writes to a log file
     * 
     * Wrapper function for {@see Logger::writeLog()}.
     * 
     * @param string $message Message to write to the log file
     */
    public static function log(string $message)
    {
        $logger = static::getInstance();
        $logger->writeLog($message);
    }

    /**
     * Writes a new line to a log file
     * 
     * Wrapper function for {@see Logger::writeLog()} but with an empty message.
     */
    public static function logNewLine()
    {
        $logger = static::getInstance();
        $logger->writeLog("");
    }
}

/**
 * Singleton Test Logger that can be used to record if an exception occurs in a test
 * 
 * The {@see TestLogger::newLogFile()} function should be called at least once, otherwise the default location is used.
 */
class TestLogger extends Logger
{
    /**
     * @var bool Set to true if a failure is written to the logs
     */
    protected $isFailure;

    /**
     * Constructor for TestLogger
     */
    protected function __construct()
    {
        $this->isFailure = false;
    }

    /**
     * Sets a new log file, must be called at least once otherwise the default location is used
     * 
     * Wrapper function for {@see Logger::setLogFile()}
     * 
     * @param $logDir  Directory where the log file is located
     * @param $logFile Name of the log file within the specified log directory
     */
    public static function newLogFile(string $logDir, string $logFile)
    {
        $logger = static::getInstance();
        $logger->setLogFile($logDir, $logFile);
    }

    /**
     * Logs an error to the log files and sets $isFailure to true
     * 
     * @param string $message Message to write to the log files
     */
    public static function logError(string $message)
    {
        $logger = static::getInstance();
        $logger->isFailure = true;
        $logger->writeLog($message);
    }

    /**
     * Raises an Exception if there were any failures written to the logs
     * 
     * @return bool       if there were no failures
     * @throws \Exception if there was a failure
     */
    public static function raiseExceptionIfFailure()
    {
        $logger = static::getInstance();
        if ($logger->isFailure) {
            static::close();
            throw new \Exception("One or more tests failed.");
        }
        return false;
    }

    /**
     * Closes the log file
     */
    public static function close()
    {
        $logger = static::getInstance();
        $logger->logFile = "";
        $logger->logDir = "";
        fclose($logger->fileHandle);
    }
}

getBTCAddressFunctionTest();
getBTCAddressUsageTest();
getBTCInvoiceFunctionTest();
// getBTCRateFunctionTest();
getBTCBalanceFunctionTest();
