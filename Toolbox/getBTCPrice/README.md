## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
  - **getBTCPrice**
- [Developer Documentation][DevDocs]

# getBTCPrice
Function that returns the Bitcoin amount for a specified USD amount.

Calls getBTCRate to retrieve current exchange rate data.

### Inputs
- USD Amount

### Outputs
- BTC Value based on the current BTC Exchange Rate
  - Type: float
  - Units:  Bitcoin
  - Description:
    - The value of BTC based on the submitted dollar amount. 
    - Format returned: #########.########
      - *It is up to the programmer to decide on the ultimate format desired for their situation.*

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
```php
<?php
require_once('getBTC.php');

# Prints the current price of Bitcoin in USD
$dollars = 12345.67;
$btcvalue = getBTCPrice($dollars);
echo $amount . " = " . $btcvalue;

?>
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[bitstamp-api]: https://www.bitstamp.net/api/
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[getBTCPrice]: ../getBTCPrice/
[DevDocs]: ../docs/
