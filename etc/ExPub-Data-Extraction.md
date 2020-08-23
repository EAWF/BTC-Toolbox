# Get/Verify Extended Public Key Data
* Procedure Overview
  - Input ExtendedPublicKey from Wallet
  - Deserialize Base58 encoded data
  - Verify checksum with data
  - Store data

* PHP:
  - Requires: base58, mcrypt
  - See [Test Vectors](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/Test-Vectors.md) for sample data
  ```php
  <?php
   $pub = "Your_Extended_Public_Key_Goes_Here";
   function getPubData($pub);
   $ExtPubKey = bin2hex(base58_decode($Pub));
   // Verify Checksum
   $payload = substr($ExtPubKey,0,-8);
   $Checksum = substr($ExtPubKey,-8);
   $check = substr(bin2hex(hash('sha256',bin2hex(hash('sha256',$payload)))),0,8);
   if($Checksum === $check ){
    // ExtPubKey Data is correct. Load data to array
    $pubdata = array[
     'Type' => substr($ExtPubKey,0,8),               // See [SLP-0132]() for details
     'Depth' => substr($ExtPubKey,8,2),              // indicates how many times derivation has happened from the master seed.
     'Fingerprint' => substr($ExtPubKey,10,8),       // Hash160 "fingerprint" of the parent extended key
     'Account' => substr($ExtPubKey,18,8),           // Should match the derivation path + 80000000 (Accounts are always 'hardened' > 800000000)
     'ParentChainCode' => substr($ExtPubKey,26,64),  
     'ParentPublicKey' => substr($ExtPubKey,90,66),
     'Checksum' => $Checksum
    ];
    print_r($pubdata);
   }else{
    echo "Invalid Extended Public Key";
    exit;
   }
  ?>
  ```
