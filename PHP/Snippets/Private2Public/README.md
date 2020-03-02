# BTC Private Key to Public Key Conversion
* Performs ECC conversion algorithm on your private Key to convert it to a public key which can be used to create a BTC Payment Address
* Use [Secp256k1.php](https://github.com/ItayRosen/cryptophp/blob/master/src/secp256k1.php) code from from [ItayRosen's CryptoPHP Repository](https://github.com/ItayRosen/cryptophp)
* Code snippet:
```php
<?php
 require('Secp256k1.php');
 $Secp256k1 = new Secp256k1();
 $public_key = $Secp256k1 -> private2public($private_key);
?>
```
* NOTE: I have not been able to get this to work correctly. There is an extension written for this class in Address.php, and other linked files in the CryptoPHP.php file. It would really be nice for this repo if JUST the privatekey to publickey conversion was in a single standalone function and the other necessary functions were added as stanalone functions too.
