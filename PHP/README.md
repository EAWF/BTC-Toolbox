# PHP7 Specific Tools
These are tools and code snippets that you can use to build your own Bitcoin paywall using PHP 7 with the base58, gmp, and mcrypt extensions installed.
* [getBTCAddress](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getBTCAddress.md) - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
* [getBTCRate](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getBTCRate.md) - returns the current exchange rate for bitcoin in different currencies (ex. [Integrate Blockchain.info Ticker](https://blockchain.info/ticker))
* [getBTCInvoice](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getBTCInvoice.md) - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
  - [getQRCode](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getQRCode.md) - utilizes the users browser to build the Invoice in [QR Code](https://github.com/davidshimjs/qrcodejs) format on the web page.
* [getBTCBalance](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getBTCBalance.md) - Checks the blockchain for the current balance of the payment address and number of confirmations.
