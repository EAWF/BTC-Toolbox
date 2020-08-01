# BTC Private Key to Public Key Conversion
* Performs EC arithmetic on a Private Key to calculate its Public Key pair which can be used to create a BTC Payment Address
* Uses a modified version of [Secp256k1.php](https://github.com/ItayRosen/cryptophp/blob/master/src/secp256k1.php) from [ItayRosen's CryptoPHP Repository](https://github.com/ItayRosen/cryptophp)
* Sample Usage (see [Usage.php](Usage.php) for detailed usage):
```php
<?php
 require('Secp256k1.php');
 $Secp256k1 = new Secp256k1();
 $public_key = $Secp256k1 -> private2public($private_key);
?>
```

Please utilize [Secp256k1Test.php](Secp256k1Test.php) when making changes to [Secp256k1.php](Secp256k1.php) to verify the changes do not break the code.
