# OBSOLETE:
**It's easier to install the php-base58 extension *(on RH, use yum -y install php_base58 - Function calls are exactly the same)***

## <del>A simple, pure PHP implementation of the base58 encode and decode should be grabbed from here:
[Base58 Encoding](https://en.bitcoin.it/wiki/Base58Check_encoding)</del>

* Base58 Conversion Operations
```php
<?php
// The BTC Base58 Alphabet 
 $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

// Convert hexadecimally represented number string to Base58 encoded character string.
 function base58_encode($num) {
  $base_count = strlen($alphabet);
  $encoded = '';
  while ($num >= $base_count) {
   $div = $num / $base_count;
   $mod = ($num - ($base_count * intval($div)));
   $encoded = $alphabet[$mod] . $encoded;
   $num = intval($div);
  }
  if ($num) {
   $encoded = $alphabet[$num] . $encoded;
  }
  return $encoded;
 }

// Decode Base58 encoded character string to hexadecimally represented number string
 function base58_decode($num) {
  $len = strlen($num);
  $decoded = 0;
  $multi = 1;
  for ($i = $len - 1; $i >= 0; $i--) {
   $decoded += $multi * strpos($alphabet, $num[$i]);
   $multi = $multi * strlen($alphabet);
  }
  return $decoded;
 }
?>
'''
