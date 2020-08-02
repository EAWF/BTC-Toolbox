# PHP Tools
These are tools and code snippets that you can use to build your own Bitcoin paywall using PHP 7 with the base58, gmp, and mcrypt extensions installed.
* [getAddress](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getAddress.md) - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
* [getRate](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getRate.md) - returns the current exchange rate for bitcoin in different currencies (ex. [Integrate Blockchain.info Ticker](https://blockchain.info/ticker))
* [getPaymentRequest](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getPaymentRequest.md) - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
* [getQRCode](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getQRCode.md) - utilizes the users browser to build a [QR Code](https://github.com/davidshimjs/qrcodejs) on the web page
* [getPaid](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/PHP/getPaid.md) - Checks the blockchain for the current balance of the payment address and number of confirmations.
