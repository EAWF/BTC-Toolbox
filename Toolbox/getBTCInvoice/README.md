## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - **getBTCInvoice**
  - [getBTCRate]

# getBTCInvoice
Function that returns a [BIP-21] Payment Protocol compliant string which is supported by most popular Bitcoin wallets.

### Dependencies
- [getBTCAddress.php][getBTCAddress]
  - requires [getBTC.conf]
- [getBTCRate.php][getBTCRate]

### Inputs
- Account Name
  - Type: string
  - Description: Wallet Account where payment will be sent(address will be derived for)
- Index
  - Type: integer
  - Description: Wallet Account where payment will be sent(address will be derived for)
- Invoice Amount
  - Type: float  (###############.##)
  - Units: USD
  - Description: Amount (in USD) that the customer must send
- Address Label (Optional)
  - Type: string
  - Description: Label that the customer will see in addition to the Address
- Message (Optional)
  - Type: string
  - Description: Message that the customer will see as a reason for payment

### Outputs
- [Result] 
  - Type: string
  - Description: [BIP-21] compliant string
  - Sample outputs:
    - WIP
    
## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
- getBTCInvoice() - Includable function in pure PHP 7.x 
```php
  function getBTCInvoice(string $account = 'Default', int $index, float $amount, string $label, string $message): string
  {
   $address = getBTCAddress( $account , $index);
   $BIP21 = "bitcoin:" . $address;
   if ( $amount > 0 )
   {
    $total = getBTCRate( $amount );
    $BIP21 = $BIP21 . "?amount=". $total;
   } else {
    
   }
   if ( ! empty( $label )
   {
    $BIP21 = $BIP21 . "&label=" . $label;
    if ( ! empty( $message )
    {
     $BIP21 = $BIP21 . "&message=" . $message;
    }
   }
   $BIP21 = str_replace( $string, " ", "%20");
   return $BIP21;
  }
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[Toolbox]: ./Toolbox/
[getBTCAddress]: ./Toolbox/getBTCAddress/
[getBTCBalance]: ./Toolbox/getBTCBalance/
[getBTCInvoice]: ./Toolbox/getBTCInvoice/
[getBTCRate]: ./Toolbox/getBTCRate/
[getBTC.conf]: ./Toolbox/getBTC.conf/
[Bob Holden]: https://github.com/EAWF
[Carson Mullins]: https://github.com/Septem151
[Ian Coleman]: https://github.com/iancoleman
[BIP-39 Mnemonic Code Converter]: https://github.com/iancoleman/bip39
[Jan Lindeman]: https://github.com/rgex
[BitcoinECDSA.php]: https://github.com/BitcoinPHP/BitcoinECDSA.php
[Kyle Honeycutt]: https://github.com/coinables
[Building Bitcoin Websites]:https://www.amazon.com/Building-Bitcoin-Websites-Beginners-Development/dp/153494544X
[Peter N. Steinmetz]: https://github.com/PeterNSteinmetz
[Andreas M. Antonopoulos]: https://aantonop.com/
[Mastering Bitcoin, 2nd Edition]: https://github.com/bitcoinbook
[BIP's]: https://github.com/bitcoin/bips
[BIP-21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[BIP-32]: https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki
[BIP-39]: https://github.com/bitcoin/bips/blob/master/bip-0039.mediawiki
[BIP-44]: https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki
[BIP-49]: https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki
[BIP-84]: https://github.com/bitcoin/bips/blob/master/bip-0084.mediawiki
[BIP-173]: https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki
[SLIP-0132]: https://github.com/satoshilabs/slips/blob/master/slip-0132.md
