<?php
 $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
 $price = $bitstamp["last"];
 echo "$price\n";
?>
