# Get/Verify Extended Public Key Data
* Procedure Overview
  - Input ExtendedPublicKey from Wallet
  - Deserialize Base58 encoded data
  - Verify checksum with data
  - Return data items

* PHP 7.x Function:
  - Requires: Base58
  - Test Vector Data (See [Test Vectors](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/Test-Vectors.md) for details and samples)
```php
<?php
 $pub = "xpub6BosfCnifzxcFwrSzQiqu2DBVTshkCXacvNsWGYJVVhhawA7d4R5WSWGFNbi8Aw6ZRc1brxMyWMzG3DSSSSoekkudhUd9yLb6qx39T9nMdj";
 function getPubData($pub);
 $ExtPubKey = bin2hex(base58_decode($Pub));
 getChecksum($ExtPubKey)  // Verify Checksum
 
 
 $Type = substr($ExtPubKey,0,8);                // See [SLP-0132]() for details
 $Depth = substr($ExtPubKey,8,2);               // "0x03" - Account level is the third level from master seed on the derivation path
 $Fingerprint = substr($ExtPubKey,10,8);        // Hash160 Fingerprint of parent
 $Account = substr($ExtPubKey,18,8);            // Should match derivation path + 0x80000000 (Accounts are always 'hardened' > 0x800000000)
 $ParentChainCode = substr($ExtPubKey,26,64);
 $ParentPublicKey = substr($ExtPubKey,90,66);
 $Checksum = substr($ExtPubKey,-8);
?>
```

