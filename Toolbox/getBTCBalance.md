# getBTCBalance
The examples below focus on the Blockchain.info blockchain explorer API. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

* Click [here](http://www.google.com/search?q=block+explorer+api) to search for Blockchain Explorer API's 

## Snippets
### PHP7.x w/json extension
* **Example Using Blockstream**: 
  - https://blockstream.info/api/address/:address
  - Returns the address data from the blockchain(in satoshi) as JSON.
 ```php
<?php
function getBTCBalance(string $address, int $confirmations = 0): float
{
  $query = "https://blockstream.info/api/address/" . urlencode($address) . "/utxo";
  $result = json_decode(file_get_contents($query), true);
  $blockheight = 0;
  $balance = 0;
  foreach ($result as $utxo) {
    $utxo_confirmations = 0;
    if ($confirmations <= 0 && filter_var($utxo["status"]["confirmed"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
      if ($blockheight == 0)
        $blockheight = (int)file_get_contents("https://blockstream.info/api/blocks/tip/height");
      $utxo_confirmations = $blockheight - (int)$utxo["status"]["block_height"];
    }
    if ($utxo_confirmations >= $confirmations)
      $balance += (int)$utxo["value"];
  }
  return $balance /= 100000000;
}
?>
  ```
