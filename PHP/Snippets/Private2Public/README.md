# BTC Private Key to Public Key Conversion
* Performs ECC conversion algorithm on your private Key to convert it to a public key which can be used to create a BTC Payment Address
* Code for [secp256k1.php](https://github.com/ItayRosen/cryptophp/blob/master/src/secp256k1.php) taken from [ItayRosen's CryptoPHP Repository](https://github.com/ItayRosen/cryptophp)
* Code snippet:
```php
<?php
 require('secp256k1.php');
 $Secp256k1 = new Secp256k1();
 $public_key = $Secp256k1 -> private2public($private_key);
?>
```
