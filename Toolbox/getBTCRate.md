# getBTCRate
The examples below focus on the USD/BTC exchange pair. Other currency pair data may be provided by the exchanges below or other exchanges. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

[Click here](http://www.google.com/search?q=bitcoin+ticker+api) to search for Bitcoin Ticker API's

## Snippets
### PHP7.x w/json extension
* **Bitstamp**:
```php
 <?php
  $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
  $BTCRate="Bitstamp: $".number_format($bitstamp["last"],2);
 ?>
 ```
* **Blockchain**:
 ```php
 <?php
  $blockchain = json_decode(file_get_contents('https://blockchain.info/ticker'),true);
  $BTCRate="Blockchain: ".$blockchain["USD"]["symbol"].number_format($blockchain["USD"]["last"],2);
 ?>
 ```
## A Functional Tool
* returns the current USD/BTC exchange rate for your paywall.
  - Two Modes:
    - Return Current USD Exchange Rate
      - No Parameters
      - *return* - USD(string) ($ ###,###,###.##)
    - Get Current BTC amount for specified USD Amount
      - *param*  - Dollar Amount > 0 (#######.##)
      - *return* - BTC(string) (####.########)
* PHP7.x FUNCTION (Requires JSON extension)      
```php
<?php
// Assign $amount = 0 if null
function getBTCRate($amount = 0)  
{   
  $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'), true);
  if ($amount <= 0) {           // Assign 0 if null, and protect against accidental use of negative numbers.
    // Display Rate in Dollars mode
    $result = "$ " . number_format($bitstamp["last"], 2);     // return $result in users locale format with 2 decimal places and thousands separators.
  } else {
    // Exchange Dollars for BTC Mode
    $result = number_format($amount / $bitstamp["last"], 8,'.','');  // return $result with 8 decimal places and no thousands separators.
  }
  return $result;
}
?>
```
