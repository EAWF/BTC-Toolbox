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
  - Type: float
  - Units:  Dollars
  - Restrictions:
    - Must be greater than 0

### Outputs
- BTC Value based on the current BTC Exchange Rate
  - Type: float
  - Units:  Bitcoin
  - Description:
    - The value of BTC based on the submitted dollar amount. 
    - Format returned: #########.########
      - *It is up to the programmer to decide on the ultimate format desired for their situation.*

## Usage

```php
<?php
require_once('getBTC.php');

# Prints the current bitcoin value of desired dollars
$dollars = 12345.67;
$btcvalue = getBTCPrice($dollars);
echo $dollars . " = " . $btcvalue;

?>
```


[bitstamp-api]: https://www.bitstamp.net/api/
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[getBTCPrice]: ../getBTCPrice/
[DevDocs]: ../docs/
