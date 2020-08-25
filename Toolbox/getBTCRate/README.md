## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - **getBTCRate**
- [Developer Documentation][DevDocs]

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
    - `USD Amount` Input Provided: The exchange rate (in USD) of 1 Bitcoin. Format: $###,###,###.##
    - `USD Amount` Input Not Provided: The Bitcoin amount of the given USD Amount. Format: ########.########

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

# Prints the amount of Bitcoin equivalent to $199.99
$usd_price = 199.99;
$bitcoin_price = getBTCRate($usd_price);
echo "The USD amount of $" . number_format($usd_price, 2) . " is equivalent to " . $bitcoin_price . " BTC";
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
[DevDocs]: ../docs/
