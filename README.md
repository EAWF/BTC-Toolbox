# A Toolbox for Building Your Own Bitcoin Paywall
***Our Mission: To provide a simple set of tools for programmers to use to build Bitcoin Paywalls***

## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance for their operations.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.

## Repository Layout
The tools listed below have their own section in this repository. Additional links will be found on those pages for varying programming languages using the same strategy/parameters.
- If the module that you need is not availble in the language you wish, please create an issue to request it.

## The Toolbox
* [getBTC](https://github.com/EAWF/Bitcoin-Merchants-Toolbox) - Derives payment addresses from an HD Wallet's exported, account-level, extended public key.
* [getRate](https://github.com/EAWF/Bitcoin-Merchants-Toolbox) - returns the current exchange rate for bitcoin in different currencies (ex. [Integrate Blockchain.info Ticker](https://blockchain.info/ticker))
* [getPaymentRequest](https://github.com/EAWF/Bitcoin-Merchants-Toolbox) - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
* [getQRCode](https://github.com/EAWF/Bitcoin-Merchants-Toolbox) - utilizes the users browser to build a [QR Code](https://github.com/davidshimjs/qrcodejs) on the web page
* [getPaid](https://github.com/EAWF/Bitcoin-Merchants-Toolbox) - Checks the blockchain for the current balance of the payment address and number of confirmations.

## Additional Helpful Resources:
* [BIP's](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.
* [Kyle Honeycutt](https://github.com/coinables)
  - [How To Code A Bitcoin Paywall](https://www.youtube.com/watch?v=baW2XdtaOXw) (PHP/Javascript)
    - [Simple Barebone Bitcoin Paywall](https://github.com/coinables/Simple-Barebone-Bitcoin-Paywall/blob/master/index.php) (Git Repository of the files created in the video)

## Contributors/Collaborators:
* [Bob Holden](https://github.com/EAWF)
* [Carson Mullins](https://github.com/Septem151)
* [Peter N. Steinmetz](https://github.com/PeterNSteinmetz)
* [Jan Lindeman](https://github.com/rgex)

## Kudo's and Acknowledgements
* [Andreas M. Antonopoulos](https://aantonop.com/) - Bitcoin Explainer Extraordinaire
