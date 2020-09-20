## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
  - [getBTCPrice]
  - **setBTCPrice**
- [Developer Documentation][DevDocs]

# setBTCPrice
Function that retrieves the current price from exchange servers and stores locally so as to avoid API limits on the servers.
* Provides fail-safe redundancy by searching other resources in the instance of 400, 403, or 404 errors from the source.
  - Timestamp may be used to verify that data is "fresh" and if not, allow for automatic admin warning or shutdown if desired.
* JSON is used to simplify and clarify conversion between arrays and text storage.

### Outputs
- JSON Text String stored in ```/var/www/php/getBTC.json```
  - Fields:
    - source: Name of Exchange
    - price: Current USD/BTC exchange rate
    - timestamp: Unix timestamp from server

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
See source at [setBTCPrice.php] 

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
[setBTCPrice]: ../setBTCPrice/
[setBTCPrice.php]: ../setBTCPrice/setBTCPrice.php

[DevDocs]: ../docs/

