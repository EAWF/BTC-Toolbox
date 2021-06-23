# Base58.php
## Use in case you aren't able to install php-base58


```php
<?php
class base58{
 static public $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz"; //Bitcoin Alphabet

 public static function encode($int){
  $base58_string = "";
  $base = strlen(self::$alphabet);
  while($int >= $base){
   $div = floor($int / $base);
   $mod = $int % $base;
   $base58_string = self::$alphabet{$mod} . $base58_string;
   $int = $div;
  }
  if($int) $base58_string = self::$alphabet{intval($int)} . $base58_string;
   return $base58_string;
  }
  public static function decode($base58) {
   $int_val = 0;
   for($i=strlen($base58)-1,$j=1,$base=strlen(self::$alphabet);$i>=0;$i--,$j*=$base){
    $int_val += $j * strpos(self::$alphabet, $base58{$i});
   }
   return $int_val;
  }
 }
?>
```
