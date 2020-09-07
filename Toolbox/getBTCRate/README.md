## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - **getBTCRate**
  - [getBTCPrice]
- [Developer Documentation][DevDocs]

# getBTCRate
Function that returns either the current USD price of Bitcoin, or the Bitcoin amount for a specified USD amount.

Uses the [Bitstamp v2 API][bitstamp-api] to retrieve price data.

### Inputs
- None

### Outputs
- Exchange Rate
  - Type: float
  - Units:  Dollars
  - Description:
    - The exchange rate (in USD) of 1 Bitcoin. Format returned: #########.##
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
$exchange_rate = getBTCRate();
echo "Current price of Bitcoin is: " . $exchange_rate;

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
