# A Merchants BTC HD Wallet to Payment Address Toolbox
## Purpose
* Provide a simple set of algorithms that programmers can use to obtain payment addresses for an exported, account-level, extended public key that is obtained from an existing bitcoin HD Wallet. 
## Target Audience
* Merchants/Sellers of products and services who want to add bitcoin as a method of invoice remittance.
* Programmers developing bitcoin payment gateways for use by Merchants/Sellers of products and services.
* 10+(?) years of age, with a some programming experience
## Repository Standards: (remove this section when project is final)
**When working/participating on this project:**
* **Keep it simple, stupid!** 
* **Don't Write Code** Use [Psuedocode](https://en.wikipedia.org/wiki/Pseudocode) or flow charts - We're writing the [algorithm](https://www.merriam-webster.com/dictionary/algorithm), not programming language specific code.
* **Avoid techno-babble**: 
  - Explain every acronym **before** using it. Example: Child Key Derivation(**CKD**).
* **Keep it concise**, short, sweet, and clear without any possible confusion.
  - **Focus** in on only what is necessary to include in this repository.
  - **Link** to external technical explanations/resources whenever possible. Don't re-invent the wheel here as it may change in the future.
* Use the [repository Wiki](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/wiki) for documentation, discussions, long explanations, and comments.
## Definitions:
- [BIP\[XX\]](https://github.com/bitcoin/bips) - Bitcoin Improvement Proposals are the concensus driven rules for programming bitcoin.
- [BIP44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) - P2SH - Pay to Script Hash (aka "Legacy") payment addresses that begin with the number "1" and are derived from an xPub. 
- [BIP49](https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki) - P2WPKH-P2SH - Pay to Witness Public Key Hash nested within a Pay to Script Hash (aka "Segwit-Compatible") payment addresses that begin with the number "3" and are derived from a yPub.
- [BIP84](https://github.com/bitcoin/bips/blob/master/bip-0084.mediawiki) - P2WPKH - Pay to Witness Public Key Hash (aka "Bech32") addresses that begin with "bc1") and are derived from a zPub.
- [CKD](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki#Specification_Key_derivation) - Child Key Derivation  - algorithms describing the methods used to compute public and private keys along a derivation path
- [Path](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki#path-levels) - HD Wallet Derivation Path
- [HD]() - Hierarchical Deterministic
## Key Concepts:
* Child Key Derivation Function Types
  - CKDPrv - Can derive hardened private ***or*** normal public keys
    - Inputs:
      - Parent Private Key
      - Parent Chain Code
      - child Index
        - 0x00000000 - 0x8ffffffe - Public Keys
        - 0x8fffffff - 0xfffffffe - Private Keys
  - CKDPub - Derives ***only*** normal public keys
    - Inputs:
      - Parent Public Key
      - Parent Chain Code
      - child Index range
        - 0x00000000 - 0x8ffffffe to derive normal public keys
  - NOTE: When writing the derivation function in shorthand below, the Parent Private or Public Key is ALWAYS concantenated with the child index to the right as:
      > ParentPrivateKey|ChildIndex  ***OR***  ParentPublicKey|ChildIndex
* The derivation path describes the relationship of a derived private or public key to the private or public key found at the level above it based upon the index indicated in the derivation path.
  - "Normal" indices range between zero(0x00000000) to 2^32-1(0x8ffffffe) and are derived from **Public OR Private Keys**
  - "Hardened" indices(indicated by the prime symbol"'" range between 2^32(0x80000000) and 2^64-1(0xfffffffe) and are derived only by using **Private Keys** 
* An example derivation path would be:
  > m/CT'/N'/A'/C/i
  - where:
    - "m" is the root level.
      - This is the 256 bit cryptographically secure random Master private key) that ***IS*** the HD wallet.
        - The BIP39 backup mnemonic seed is generated from this number as a wallet backup scheme.
    - "CT'" is is the "CoinType"(defined as the "Purpose"), and is the private key derived from the master private key with the index of 0x8000000XX.
      - the derivation index values(XX) can be:
        - "44'" for xpub origined addresses (0x80000044)
        - "49'" for ypub origined addresses (0x80000049)
        - "84'" for zpub origined addresses (0x80000084)
    - "N'" is the Network level and for Bitcoin, and index values are limited to:
      - "0'" for the Bitcoin MainNet (0x80000000)
      - "1'" for the Bitcoin TestNet (0x80000001)
    - "A'" is the Account level and valid derivation index values may only be within the range of 0x80000000 and 0x8ffffffe
      - An exported "account-level" extended Public Key contains the this levels Public Key and Chain Code, and that information is needed to derive public keys and chain codes for the lower levels of the derivation path.
      - Notes on Accounts:
        - always begin with the 0x80000000 account.
        - Standard Wallets have the following defacto rules:
          - Accounts begin with the 0x80000000 account.
          - Before creating the next sequential account(0x80000001), there must be at least one transaction on the blockchain(or mempool) for the previous account.
        - Non-standard wallets:
          - have no requirements to either begin with the 0x80000000 account, or to follow the account number sequence.
      - "C" is the "Change" level
        - An index of "0x00000000" is used to derive a **Public Key** to be used to derive **Payment Addresses** that are used to receive funds from invoice remittances.
        - An index of "0x00000001" is used to derive a **Public Key** to be used to derive **Change Addresses** that are used to return funds back to the wallet from spending transactions.
          - Change addresses are not used for this repository as we are not concerned with spending bitcoin and receiving change from that transaction.


* By definition, an "account-level" "extended public key" has been exported from an HD wallet at the derivation path's account level, meaning:
          - The master private exists.
          - Hardened derivation has been performed on the master private key and a Hash has been created containing the CoinType Parent Private key and Chain Code.
          - Hardened derivation has been performed on the CoinType Hash with an appropriate index, and a new hash has ben created
          
          
          - The Account number has been derived and accounted for in the resulting PUBLIC key.
## The Algorithms/Tool List
* Public Key Extractor - Extracts a [change level](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki#path-levels) public key to be used by the Deriver tools.
* The Derivers - Uses the above extracted [change level](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki#path-levels) public key to derive payment addresses that route incoming invoice remittances to the proper account of the HD Wallet
  - BIP44 - Uses the public key extracted from a BIP
  - BIP49
  - BIP84
## Contributors/Collaborators:
* [Bob Holden](https://github.com/EAWF)
* [Peter N. Steinmetz](https://github.com/PeterNSteinmetz)
