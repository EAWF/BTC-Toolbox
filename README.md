# A Toolbox for Building Your Own Bitcoin Paywall
***Our Mission: To provide a simple set of tools for programmers to use to build Bitcoin Paywalls***

## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance for their operations.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.

## The Toolbox
These are tools and code snippets that you can use to build your own Bitcoin paywall.
* [getBTCAddress](/Toolbox/getBTCAddress.md) - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
* [getBTCRate](/Toolbox/getBTCRate.md) - returns the current exchange rate for bitcoin
* [getBTCInvoice](/Toolbox/getBTCInvoice.md) - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
* [getBTCBalance](/Toolbox/getBTCBalance.md) - Checks the blockchain for the current balance of the payment address and number of confirmations.

## Test Vectors
* Test vectors have been obtained by using [Ian Coleman](https://iancoleman.io)'s excellent [BIP 39 Mnemonic Code Converter](https://github.com/iancoleman/bip39) with this 12 word mnemonic:
  - ```abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon abandon about```
  - ***WARNING!!! - DO NOT SEND ANY BITCOIN TO ADDRESSES CREATED FROM THIS MNEMONIC!!! YOU WILL PROBABLY LOSE YOUR FUNDS!!!!!***
  
## Additional Helpful Resources:
* [BIP's](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.

## Contributors/Collaborators:
* [Bob Holden](https://github.com/EAWF)
* [Carson Mullins](https://github.com/Septem151)
* [Peter N. Steinmetz](https://github.com/PeterNSteinmetz)
* [Jan Lindeman](https://github.com/rgex)

## Kudo's and Acknowledgements
* [Andreas M. Antonopoulos](https://aantonop.com/) - Bitcoin Explainer Extraordinaire
