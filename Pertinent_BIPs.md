# Pertinent BIP's
The following resources provide information on the various tools that describe bitcoin wallets and algorithms used to create payment addresses
* [BIP-32](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki) - Describes Hierarchical Derivation (aka Child Key Derivation(CKD)) - algorithms describing the methods used to compute private and public keys along a derivation path
* [BIP-44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) - P2SH - Pay to Script Hash (aka "Legacy") payment addresses that begin with the number "1" and are derived from an xPub. 
* [BIP-49](https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki) - P2WPKH-P2SH - Pay to Witness Public Key Hash nested within a Pay to Script Hash (aka "Segwit-Compatible") payment addresses that begin with the number "3" and are derived from a yPub.
* [BIP-84](https://github.com/bitcoin/bips/blob/master/bip-0084.mediawiki) - P2WPKH - Pay to Witness Public Key Hash (aka "Bech32") addresses that begin with "bc1") and are derived from a zPub.
used to compute public and private keys along a derivation path
* [HD](https://en.bitcoin.it/wiki/Deterministic_wallet) - Hierarchical Deterministic
* [Path](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki#path-levels) - HD Wallet Derivation Path
