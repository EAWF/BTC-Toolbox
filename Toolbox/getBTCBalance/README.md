## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - **getBTCBalance**
  - [getBTCInvoice]
  - [getBTCRate]
- [Developer Documentation][DevDocs]

# getBTCBalance
Function that returns the balance of an address with the option to specify a minimum number of confirmations.

Uses the [Blockstream Esplora][esplora] API to retrieve balance information.

### Inputs
- Bitcoin Address
  - Type: string
  - Restrictions:
    - Must be a valid Bitcoin address
  - Description: Address to check the balance of
- Confirmations (Optional)
  - Type: integer
  - Restrictions:
    - Must be in the range `0 <= x < 2^31`
  - Description: Minimum number of confirmations a transaction needs to be considered completed

### Outputs
- Balance
  - Type: string
  - Units: Bitcoin
- Description: Total balance of the Bitcoin Address. Format: ########.########

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
```php
<?php
require_once('getBTC.php');

# Prints the balance of address, including unconfirmed transactions
$address = "bc1qqssy2886jwzm2nwhsmrsf03cguwupufhz6sqq3";
$balance = getBTCBalance($address);
echo "The address " . $address . " has a total balance of: " . $balance;

# Prints the balance of address, only including transactions with confirmations >= 6
$address = "1Eyesds32qPzUF7jq7GyNne7gQxpPiQRV5";
$min_confirmations = 6;
$balance = getBTCBalance($address, $min_confirmations);
echo "The address " . $address . " has a total balance of: " . $balance;
?>
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[esplora]: https://github.com/Blockstream/esplora
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[DevDocs]: ../docs/
