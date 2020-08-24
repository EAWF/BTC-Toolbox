## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress][getBTCAddress]
  - [getBTCBalance][getBTCBalance]
  - getBTCInvoice
  - [getBTCRate][getBTCRate]

# getBTCInvoice
Function that returns a QR Code containing payment request information for a customer to scan.

Follows the [BIP-21][bip21] Payment Protocol which is supported by most popular Bitcoin wallets.

### Inputs
- Bitcoin Address
  - Type: string
  - Restrictions:
    - Must be a valid Bitcoin address
  - Description: Address to which the customer must send payment to
- Invoice Amount
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
- QR Code
  - Type: image (binary)
  - Description: QR Code image data encapsulating the payment request information

## Usage

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
Currently a WIP.

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[bip21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCRate]: ../getBTCRate/
