# Bitcoin Merchants Toolbox
# A Toolbox for Building Your Own Bitcoin Paywall
***Our Mission: To provide a simple set of tools for programmers to use to build Bitcoin Paywalls***

## Table of Contents
- [Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
  - [getBTC.conf]

## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance for their operations.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.

## The Toolbox
These are tools and code snippets that you can use to build your own Bitcoin paywall.
* [getBTCAddress] - Payment Address Derivation [BIP-32] using an exported, account-level extended public key from your [BIP-39] HD Wallet.
* [getBTCRate] - Returns the current USD/BTC exchange rate or converts a dollar amount to the current equivalent of bitcoin
* [getBTCInvoice] - returns a [BIP-21] compliant string that encodes payment information such as amounts, labels, and messages that may, or may not, be included in the payers wallet.
* [getBTCBalance] - Checks the blockchain for the current balance of the payment address and number of confirmations.
* [getBTC.conf] - The configuration file used to store the Exported Account-Level Extended Public Key from the HD Wallet.

## Safe Test Vectors
* Safe test addresses (may be)/(have been) obtained by using [Ian Coleman]'s excellent [BIP 39 Mnemonic Code Converter] with this seed mnemonic:
  - ```abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon about```
  - ***WARNING!!! - DO NOT SEND BITCOIN TO ADDRESSES CREATED FROM THIS BIP-39 MNEMONIC!!! YOU COULD LOSE YOUR BITCOIN!!!!!***
  
## Additional Helpful Resources:
* [BIP's](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.

## Kudo's & Acknowledgements
* [Bob Holden] - Owner/Contributor
* [Carson Mullins] - Contributor/GitHub Manager
* [Jan Lindeman] - Contributor: [BitcoinECDSA.php]
* [Kyle Honeycutt] - Collaborator/Author of [Building Bitcoin Websites]
* [Andreas M. Antonopoulos] - Author of [Mastering Bitcoin, 2nd Edition]
* [Peter N. Steinmetz] - Advisor


[Toolbox]: ./Toolbox/
[getBTCAddress]: ./Toolbox/getBTCAddress/
[getBTCBalance]: ./Toolbox/getBTCBalance/
[getBTCInvoice]: ./Toolbox/getBTCInvoice/
[getBTCRate]: ./Toolbox/getBTCRate/
[getBTC.conf]: ./Toolbox/getBTC.conf/
[Bob Holden]: https://github.com/EAWF
[Carson Mullins]: https://github.com/Septem151
[Ian Coleman]: https://iancoleman.io
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
