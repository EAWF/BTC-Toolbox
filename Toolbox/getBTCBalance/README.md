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
Currently a WIP.

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[esplora]: https://github.com/Blockstream/esplora
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
