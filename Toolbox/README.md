# The Tools
These are the tools to help you to easily build your own Bitcoin paywall.
* **[getBTCRate](/master/Toolbox/getBTCAddress.md)** - returns the current USD exchange rate for bitcoin
  - Two Modes:
    - Return Current USD Exchange Rate
      - *param*  - Dollar Amount <= 0 (#)
      - *return* - USD(string) ($)(#,###.##)
    - Get Current BTC amount for specified USD Amount
      - *param*  - Dollar Amount > 0 (####.##)
      - *return* - BTC(string) (####.########)
* **[getBTCAddress](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/Toolbox/getBTCAddress.md)** - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
  - *param*  - Extended Public Key(string)
  - *param*  - Index(int)
  - *return* - Bitcoin Address(string)
* **[getBTCInvoice](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/Toolbox/getBTCInvoice.md)** - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
  - *param*  - Bitcoin Address(string)
  - *param*  - Amount(float)   - Include the Amount in BTC(####.########)
  - *param*  - Label(string)   - Include the Label field
  - *param*  - Message(string) - Include the Message field
  - *param*  - Prefix(bool)    - Include the "bitcoin:" prefix
  - *param*  - QRCode(bool)    - Include QRCode.js HTML code
    - *required* - Include David Shim's [QR Code](https://github.com/davidshimjs/qrcodejs) javascript library to build QR Codes on browser.
  - *return* - QRCodeString(string) - BIP-21 formatted Bitcoin Invoice string to send to browser
* **[getBTCBalance](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/Toolbox/getBTCBalance.md)** - Checks the blockchain for the current balance of the payment address and number of confirmations.
  - *param*  - Bitcoin Address(string)
  - *return* - Received(float) in BTC(####.########) - Amount of bitcoin received by the address
  - *return* - Spent(float) in BTC(####.########) - Amount of bitcoin spent by the address
  - *return* - Balance(float) in BTC(####.########) - Balance of bitcoin remaining in the address
  - *return* - Confirmations(int) - # of confirmations on the blockchain
