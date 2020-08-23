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
  // Uncomment one to test.
  // $address="1LqBGSKuX5yYUonjxT5qGfpUsXKYYWeabA";         // Legacy
  // $address="37VucYSaXLCAsxYyAPfbSi9eh4iEcbShgf";         // Segwit-Compatible
  // $address="bc1qcr8te4kr609gcawutmrza0j4xv80jy8z306fyu"; // Segwit(bech32)
  $query="https://blockstream.info/api/address/".$address;  // Build the query
  $result=json_decode(file_get_contents($query),true);      // Retrieve the result
  var_dump($result);                                        // Display the result
 ?>
  ```
  
