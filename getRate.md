# getRate - Return the current BTC exchange rate
The examples focus on the USD/BTC echange pair.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*
* [Bitstamp](https://www.bitstamp.net/api/v2/ticker/btcusd/) - ```https://www.bitstamp.net/api/v2/ticker/btcusd/```
* [Blockchain](https://blockchain.info/ticker) - ```https://blockchain.info/ticker```

The above is NOT a complete list of the rate resources, just one's that have been tested with the code below.

## Language Specific Snippets
### PHP
* **Bitstamp**:
  - ```php
    <?php
     $result = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
     $BTCUSD = $result["last"];
    ?>
    ```
* **Blockchain**:
  - ```php
    <?php
     $result = json_decode(file_get_contents('https://blockchain.info/ticker'),true);
     $BTCUSD = $result["USD"]["last"];
    ?>
    ```
