# getBTCBalance
The examples below focus on the Blockchain.info blockchain explorer API. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

* Click [here](http://www.google.com/search?q=block+explorer+api) to search for Blockchain Explorer API's
  - [Blockchain.com](https://www.blockchain.com/api/q) API.

## Snippets
### PHP7.x w/json extension
* **Blockchain**:
 ```php
 <?php
  $blockchain = json_decode(file_get_contents('https://blockchain.info/q/getreceivedbyaddress/3LcRjPvDiCeVZyTEvPFFeqJnvVHeMupj2F?confirmations=3'),true);
 ?>
 ```
* Get the balance of an address (in satoshi).
  - https://blockchain.info/q/addressbalance/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
* Get the total number of bitcoins received by an address (in satoshi).
  - https://blockchain.info/q/getreceivedbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
* Get the total number of bitcoins send by an address (in satoshi).
  - https://blockchain.info/q/getsentbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
* Timestamp of the block an address was first confirmed in.
  - https://blockchain.info/q/addressfirstseen/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj
* 
*  
## The Tool
