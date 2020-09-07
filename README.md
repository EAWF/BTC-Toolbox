## Table of Contents
- [Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
  - [getBTC.conf]
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
* [getBTCPrice] - returns the BTC amount for the desired dollar amount based on the current bitcoin exchange rate
* [getBTCInvoice] - returns a [BIP-21] string that encodes payment information such as amounts, labels, and messages that may be included in the payers wallet.
* [getBTCBalance] - Checks the blockchain for the current balance of the payment address and number of confirmations.

## Safe Test Vectors
* Safe test addresses may been obtained by using [Ian Coleman]'s excellent [BIP 39 Mnemonic Code Converter] with this 12 word mnemonic:
  - ```abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon about```
  - ***WARNING!!! - DO NOT SEND BITCOIN TO ADDRESSES CREATED FROM THIS BIP-39 MNEMONIC!!! YOU WILL LOSE YOUR BITCOIN!!!!!***
  
## Additional Helpful Resources:
* [BIP's] - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.

## Contributors/Collaborators:
* [Bob Holden]
* [Carson Mullins]
* [Kyle Honeycutt]
* [Jan Lindeman]
* [Peter N. Steinmetz]

## Kudo's and Acknowledgements
* [Andreas M. Antonopoulos] - Bitcoin Explainer Extraordinaire


[Toolbox]: ./Toolbox/
[getBTCAddress]: ./Toolbox/getBTCAddress/
[getBTCBalance]: ./Toolbox/getBTCBalance/
[getBTCInvoice]: ./Toolbox/getBTCInvoice/
[getBTCPrice]: ./Toolbox/getBTCPrice/
[getBTCRate]: ./Toolbox/getBTCRate/
[getBTC.conf]: ./Toolbox/getBTC.conf/
[DevDocs]: ./Toolbox/docs/
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
