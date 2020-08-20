# getBTCBalance
The examples below focus on the Blockchain.info blockchain explorer API. Always refer to the API documentation/limitations found at the links below.
## Bitcoin Exchanges Providing Free Or Low Cost Current Rate Information:
*Some Exchanges may having rate limiting or require an API key/payment plan. See each sites API documentation for trading pairs available and other details*

* Click [here](http://www.google.com/search?q=block+explorer+api) to search for Blockchain Explorer API's
  - [Blockchain.com](https://www.blockchain.com/api/q) API.

## Snippets
### PHP7.x w/json extension
* **Blockchain**:
* Get the balance of an address (in satoshi).
  - https://blockchain.info/q/addressbalance/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
 ```php
 <?php
  $amount = file_get_contents('https://blockchain.info/q/addressbalance/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6');
  echo $amount;
 ?>
 ```
  
* Get the total number of bitcoins received by an address (in satoshi).
  - https://blockchain.info/q/getreceivedbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
 ```php
 <?php
  $amount = file_get_contents('https://blockchain.info/q/getreceivedbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6');
  echo $amount;
 ?>
 ```
* Get the total number of bitcoins sent by an address (in satoshi).
  - https://blockchain.info/q/getsentbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6
 ```php
 <?php
  $amount = file_get_contents('https://blockchain.info/q/getsentbyaddress/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj?confirmations=6');
  echo $amount;
 ?>
 ```
* Timestamp of the block an address was first confirmed in.
  - https://blockchain.info/q/addressfirstseen/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj
 ```php
 <?php
  $firstseen = file_get_contents('https://blockchain.info/q/addressfirstseen/1EzwoHtiXB4iFwedPr49iywjZn2nnekhoj');
  echo $firstseen;
 ?>
 ```
  
## The Tool
* Request balance for Address and filter confirmations
* Return balance of address in Bitcoin
```php
 <?php
  function getBTCBalance($address,$confirmations){
   // Request current balance of $address, filtered by confirmations (0-6)
   // Return balance of address in bitcoin.
   $result = file_get_contents('https://blockchain.info/q/addressbalance/$address?confirmations=$confirmations');
   $amount = $result*100000000; //Convert satoshi's to bitcoin
   return $amount;
  }
 ?>
```
## Usage
Here's one way to use this function:
```php
 <?php
  require_once 'getBTC.php'
  $amount=0.00010000;
  $address=""; // This is the address we want to check.
  $confirmations="3"; // This is the address we want to check to see if the balance has 3 confirmations.
  $balance=getBTCBalance($address,$confirmations);
  if ($balance < $amount){
   echo "Waiting for more confirmations...please be patient"; 
  }else{
   echo "Payment has been received! Your order will ship ASAP."
  }
 ?>
```
## Thoughts:
* Load and use [php-ev](https://www.php.net/manual/en/ev.examples.php), a pecl event timer that you can use to pause enough time to avoid API rate limits.

