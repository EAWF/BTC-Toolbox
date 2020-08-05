# Obtaining BTC Exchange Rates
The examples below focus on the USD/BTC exchange pair. Other currency pair data may be provided by the exchanges below or other exchanges. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*
Click [here](http://www.google.com/search?q=bitcoin+ticker+api) to search for Bitcoin Ticker API's

## Language Specific Snippets
### PHP
* **Bitstamp**:
  - ```php
    <?php
     $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
     echo "Bitstamp: $".number_format($bitstamp["last"],2);
    ?>
    ```
* **Blockchain**:
  - ```php
    <?php
     $blockchain = json_decode(file_get_contents('https://blockchain.info/ticker'),true);
     echo "Blockchain: ".$blockchain["USD"]["symbol"].number_format($blockchain["USD"]["last"],2);
    ?>
    ```
