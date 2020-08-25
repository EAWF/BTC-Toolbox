## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress][getBTCAddress]
  - [getBTCBalance][getBTCBalance]
  - [getBTCInvoice][getBTCInvoice]
  - **getBTCRate**

# getBTCRate
Function that returns either the current USD price of Bitcoin, or the Bitcoin amount for a specified USD amount.

Uses the [Bitstamp v2 API][bitstamp-api] to retrieve price data.

### Inputs
- USD Amount (Optional)
  - Type: float
  - Units: USD
  - Restrictions:
    - Must be greater than `0`
  - Description: If given, the amount of USD to convert to Bitcoin

### Outputs
- Exchange Rate *OR* Bitcoin Amount
  - Type: string
  - Units: USD *OR* Bitcoin
  - Description:
    - `USD Amount` Input Provided: The exchange rate (in USD) of 1 Bitcoin
    - `USD Amount` Input Not Provided: The Bitcoin amount of the given USD Amount

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
PHP Standalone Function
```php
<?php
  function getBTCRate($amount){
   $bitstamp = json_decode(file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true);
   if($amount <= 0){
    // Display Rate Mode
    $result = "Bitstamp: $".number_format($bitstamp["last"],2);
   }else{
    // Exchange Dollars for BTC Mode
    $result = number_format($amount/$bitstamp["last"],8,'.','');
   }
   return $result;
  }
?>
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[bitstamp-api]: https://www.bitstamp.net/api/
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
