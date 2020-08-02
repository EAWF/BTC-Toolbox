# Extended Public Key Data Extraction Snippet
* Requirements - PHP > 5.x
```php
<?php
 $pub = "xpub6BosfCnifzxcFwrSzQiqu2DBVTshkCXacvNsWGYJVVhhawA7d4R5WSWGFNbi8Aw6ZRc1brxMyWMzG3DSSSSoekkudhUd9yLb6qx39T9nMdj";
 $ExtPubKey = bin2hex(base58_decode($Pub));
 $Type = substr($ExtPubKey,0,8);                // "SLP-0132"
 $Depth = substr($ExtPubKey,8,2);               // "0x03" - Account level is the third level from master seed on the derivation path
 $Fingerprint = substr($ExtPubKey,10,8);
 $Account = substr($ExtPubKey,18,8);            // Should match derivation path + 0x80000000 (Accounts are always 'hardened' > 0x800000000)
 $ParentChainCode = substr($ExtPubKey,26,64);
 $ParentPublicKey = substr($ExtPubKey,90,66);
 $PubChecksum = substr($ExtPubKey,-8);
?>
```
