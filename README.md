# A Toolbox for Building A Bitcoin Paywall
## Purpose
* A set of simple tools for programmers to use to build Bitcoin Paywalls to allow customers or donors to send bitcoin payments directly to a Bitcoin HD Wallet under the Sellers Control, without requiring any third-parties outside of the Bitcoin Network Miners. 
## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.
## Definitions/Resources:
- [BIP\[XX\]](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.
- [BIP44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) - P2SH - Pay to Script Hash (aka "Legacy") payment addresses that begin with the number "1" and are derived from an xPub. 
- [BIP49](https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki) - P2WPKH-P2SH - Pay to Witness Public Key Hash nested within a Pay to Script Hash (aka "Segwit-Compatible") payment addresses that begin with the number "3" and are derived from a yPub.
- [BIP84](https://github.com/bitcoin/bips/blob/master/bip-0084.mediawiki) - P2WPKH - Pay to Witness Public Key Hash (aka "Bech32") addresses that begin with "bc1") and are derived from a zPub.
- [CKD](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki#Specification_Key_derivation) - Child Key Derivation  - algorithms describing the methods used to compute public and private keys along a derivation path
- [HD](https://en.bitcoin.it/wiki/Deterministic_wallet) - Hierarchical Deterministic
- [Path](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki#path-levels) - HD Wallet Derivation Path
- **ExPub** - Refers interactively to any of the exported, account-level extended public keys from an HD wallet, specifically xPub, yPub, and zPub. 
## Contributors/Collaborators:
* [Bob Holden](https://github.com/EAWF)
* [Carson Mullins](https://github.com/Septem151)
* [Peter N. Steinmetz](https://github.com/PeterNSteinmetz)
