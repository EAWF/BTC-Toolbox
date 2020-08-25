## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - **getBTCInvoice**
  - [getBTCRate]
- [Developer Documentation][DevDocs]

# getBTCInvoice
Function that returns a URI containing a payment request to be packed into a QR code and scanned by the customer.

Follows the [BIP-21] Payment Protocol which is supported by most popular Bitcoin wallets.

### Inputs
- Account Name
  - Type: string
  - Restrictions:
    - Must be defined in the [getBTC.conf] file
  - Description: Name of the account in [getBTC.conf] that refers to an extended public key
- Child Index
  - Type: integer
  - Restrictions:
    - Must be in the range `0 <= x < 2^31`
  - Description: Index of the Address to derive from the Account Name's extended public key
- Invoice Amount (Optional)
  - Type: float
  - Units: Bitcoin
  - Restrictions:
    - Must be greater than or equal to `0.00000546`
  - Description: Amount (in Bitcoin) that the customer must send
- Address Label (Optional)
  - Type: string
  - Description: Label that the customer will see in addition to the Address
- Message (Optional)
  - Type: string
  - Description: Message that the customer will see as a reason for payment

### Outputs
- BIP-21 Payment Request URI
  - Type: string
  - Description: Payment request information, url encoded. Format: `bitcoin:[address][?][amount=btc][&][label=label][&][message=message]`

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
WIP, not finished testing ATM
```php
function getBTCInvoice(string $account = 'Default', int $index, float $amount, string $label, string $message): string
  {
   $address = getBTCAddress( $account , $index);
   $BIP21 = "bitcoin:" . $address;
   if ( $amount > 0 )
   {
    $total = getBTCRate( $amount );
    $BIP21 = $BIP21 . "&amount=". $total;
   } else {
    // handle if no amount, but there IS a label
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


[BIP-21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[DevDocs]: ../docs/
