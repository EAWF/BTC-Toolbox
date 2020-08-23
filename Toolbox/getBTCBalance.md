# getBTCBalance
The examples below focus on the Blockchain.info blockchain explorer API. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

* Click [here](http://www.google.com/search?q=block+explorer+api) to search for Blockchain Explorer API's 

## Snippets
### PHP7.x w/json extension
* **Example Using Blockstream**: 
  - https://blockstream.info/api/address/:address/utxo
    - Returns the address data from the blockchain(in satoshi) as JSON.
  - https://blockstream.info/api/blocks/tip/height
    - Returns the latest confirmed block height.
 ```php
<?php
// Example Usage, uncomment an address and an echo line to check balance
//$address = "1Eyesds32qPzUF7jq7GyNne7gQxpPiQRV5";           // Uncomment to check balance
//$address = "3H1ANALce9WZF9YB1UFR3VGcC186jP96AH";           // Uncomment to check balance
//$address = "bc1qqssy2886jwzm2nwhsmrsf03cguwupufhz6sqq3";   // Uncomment to check balance

//echo getBTCBalance($address, 6);    // Returns balance of transactions with >= 6 confirmations
//echo getBTCBalance($address);       // Returns balance including unconfirmed transactions

function getBTCBalance(string $address, int $confirmations = 0): float
{
  $query = "https://blockstream.info/api/address/" . urlencode($address) . "/utxo";
  $result = json_decode(file_get_contents($query), true);
  $blockheight = 0;
  $balance = 0;
  foreach ($result as $utxo) {
    $utxo_confirmations = 0;
    if ($confirmations > 0 && filter_var($utxo["status"]["confirmed"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
      if ($blockheight == 0)
        $blockheight = (int)file_get_contents("https://blockstream.info/api/blocks/tip/height");
      $utxo_confirmations = 1 + $blockheight - (int)$utxo["status"]["block_height"];
    }
    if ($utxo_confirmations >= $confirmations)
      $balance += (int)$utxo["value"];
  }
  return $balance /= 100000000;
}
?>
  ```
