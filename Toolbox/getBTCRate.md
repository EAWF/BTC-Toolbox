# getBTCRate
The examples below focus on the USD/BTC exchange pair. Other currency pair data may be provided by the exchanges below or other exchanges. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

Click [here](http://www.google.com/search?q=bitcoin+ticker+api) to search for Bitcoin Ticker API's

## Snippets
### PHP7.x w/json extension
* **Bitstamp**:
```php
 <?php
  $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
  echo "Bitstamp: $".number_format($bitstamp["last"],2);
 ?>
 ```
* **Blockchain**:
 ```php
 <?php
  $blockchain = json_decode(file_get_contents('https://blockchain.info/ticker'),true);
  echo "Blockchain: ".$blockchain["USD"]["symbol"].number_format($blockchain["USD"]["last"],2);
 ?>
 ```
## The Tool
* returns the current USD exchange rate for bitcoin
  - Two Modes:
    - Return Current USD Exchange Rate
      - *param*  - Dollar Amount <= 0 (#)
      - *return* - USD(string) ($)(#,###.##)
    - Get Current BTC amount for specified USD Amount
      - *param*  - Dollar Amount > 0 (####.##)
      - *return* - BTC(string) (####.########)
### PHP7.x FUNCTION (Requires JSON extension)      
```php
<?php
  function getBTCRate($amount){
   $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
   if($amount <= 0){
    // Display Rate Mode
    $result = "$".number_format($bitstamp["last"],2);
   }else{
    // Exchange Dollars for BTC Mode
    $result = number_format($amount/$bitstamp["last"],8,'.','');
   }
   return $result;
  }
?>
```
