## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
- [Developer Documentation][DevDocs]

# A Toolbox for Building Your Own Bitcoin Paywall
***Our Mission: To provide a simple set of tools for programmers to use to build Bitcoin Paywalls***

## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance for their operations.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.

## The Toolbox
These are tools and code snippets that you can use to build your own Bitcoin paywall.
* [getBTCAddress] - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
* [getBTCRate] - returns the current exchange rate for bitcoin
* [getBTCInvoice] - returns a [BIP-21] string that encodes payment information such as amounts, labels, and messages that may be included in the payers wallet.
* [getBTCBalance] - Checks the blockchain for the current balance of the payment address and number of confirmations.

## Safe Test Vectors
* Safe test addresses may been obtained by using [Ian Coleman](https://iancoleman.io)'s excellent [BIP 39 Mnemonic Code Converter](https://github.com/iancoleman/bip39) with this 12 word mnemonic:
  - ```abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon about```
  - ***WARNING!!! - DO NOT SEND BITCOIN TO ADDRESSES CREATED FROM THIS BIP-39 MNEMONIC!!! YOU WILL LOSE YOUR BITCOIN!!!!!***
  
## Additional Helpful Resources:
* [BIP's](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.

## Contributors/Collaborators:
* [Bob Holden](https://github.com/EAWF)
* [Carson Mullins](https://github.com/Septem151)
* [Kyle Honeycutt](https://github.com/coinables) 
* [Jan Lindeman](https://github.com/rgex)
* [Peter N. Steinmetz](https://github.com/PeterNSteinmetz)

## Kudo's and Acknowledgements
* [Andreas M. Antonopoulos](https://aantonop.com/) - Bitcoin Explainer Extraordinaire


[BIP-21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[Toolbox]: ./Toolbox/
[getBTCAddress]: ./Toolbox/getBTCAddress/
[getBTCBalance]: ./Toolbox/getBTCBalance/
[getBTCInvoice]: ./Toolbox/getBTCInvoice/
[getBTCRate]: ./Toolbox/getBTCRate/
[DevDocs]: ./Toolbox/docs/
