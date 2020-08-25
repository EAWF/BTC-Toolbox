## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress][getBTCAddress]
  - **getBTCBalance**
  - [getBTCInvoice][getBTCInvoice]
  - [getBTCRate][getBTCRate]

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
- Description: Total balance of the Bitcoin Address

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
Standalone Function
```php
function getBTCBalance(string $address, int $confirmations = 0): string
{
 $query = "https://blockstream.info/api/address/" . urlencode($address) . "/utxo";
 $result = json_decode(file_get_contents($query), true);
 $blockheight = 0;
 $balance = 0;
 foreach ($result as $utxo) {
   $utxo_confirmations = 0;
   if ($confirmations > 0 && filter_var($utxo["status"]["confirmed"], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
     if ($blockheight == 0)
       $blockheight = (int)file_get_contents("https://blockstream.info/api/blocks/tip/height");
     $utxo_confirmations = 1 + $blockheight - (int)$utxo["status"]["block_height"];
   }
   if ($utxo_confirmations >= $confirmations)
     $balance += (float)$utxo["value"];
 }
 $balance = $balance /= 100000000;
 $balance = number_format($balance,8,'.','');
 return $balance;
}
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[esplora]: https://github.com/Blockstream/esplora
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
