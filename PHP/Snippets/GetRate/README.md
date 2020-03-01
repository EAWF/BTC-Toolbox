# How to get the current BTC/FIAT Exchange Rate
## Bitstamp API
* https://www.bitstamp.net/api/v2/ticker/btcusd/
  - Current exchange rate is **"last"**
  - Returns: {"high": "8419.23", "last": "8174.00", "timestamp": "1570123001", "bid": "8174.98", "vwap": "8220.90", "volume": "7949.95129369", "low": "8029.14", "ask": "8175.00", "open": "8377.68"
## Snippet
```php
<?php
 $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
 $price = $bitstamp["last"];
 echo "$price\n";
?>
```
