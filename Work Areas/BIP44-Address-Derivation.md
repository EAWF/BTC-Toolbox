# Deriving Addresses from a BIP44 Account-Level Extended Public Key (xpub)

[BIP44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) is a Bitcoin Improvement Proposal which standardizes how addresses are derived in an account-like structure. BIP44 extended keys start with `xpub` (ex: `xpub6CLfqgeNzEvu1RSMfY4uU7vMCpobtU1Z8BofwUjz9msJUnAuzHfxo6MzW4XH26TGXKW5qBgwqumShCPSFQANnEHgk7ncCyLK15ocBk8aTAt`). Addresses derived from BIP44 Account-Level Extended Public Keys start with `1` (ex: `1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2`) and are referred to as [P2PKH](https://en.bitcoinwiki.org/wiki/Pay-to-Pubkey_Hash) (Pay To Public Key Hash) addresses. P2PKH addresses are the first address type ever used in Bitcoin, and are the most common form of transaction on the Bitcoin network.

## Extended Keys
An extended key is a private or public key accompanied by a [chain code](https://bitcoin.org/en/glossary/chain-code) to faciliate in the derivation of child extended keys. A private extended key is able to derive *private* and *public* information, whereas a public extended key only allows the derivation of *public* information. **You should never share an extended private key with anyone! Doing so will give them access to all of your funds.**

#### Account-Level Extended Public Keys
Extended public keys that are exported from modern wallet software such as [Electrum](https://electrum.org) and [Mycelium](https://mycelium.com/) are known as account extended public keys. The account extended public key is used to derive *external* (receiving) and *internal* (change) child extended keys. For the purposes of this guide, we will only focus on the external child extended key.

#### External-Level Extended Public Keys
External extended public keys are used to derive all addresses that a wallet presents as a "receive" address. A child extended public key is derived from the external-level extended key, and its public key component is used as the public key for an address.

## Addresses
A bitcoin address is simply a [script](https://en.bitcoin.it/wiki/Script) encoded in a [human-readable format](https://en.wikipedia.org/wiki/Human-readable_medium). There is no such thing as an address on the blockchain -- only scripts are stored. Wallet and blockchain explorer software interprets the scripts and formats them as addresses. Most addresses contain information about a public key in the form of a [cryptographic hash](https://en.wikipedia.org/wiki/Cryptographic_hash_function), so that anyone with knowledge of the private key for the public key will be allowed to spend the bitcoin associated with the address.

#### P2PKH
For BIP44 wallets, P2PKH addresses -- also known as "legacy addresses" -- are used. For a technical background of legacy addresses, click [here](https://en.bitcoin.it/wiki/Technical_background_of_version_1_Bitcoin_addresses). 

In the pseudocode below, the following assumptions are made:
- **||** is the concatenation of bytes
- **HASH160** is [SHA-256](https://en.bitcoin.it/wiki/SHA-256) followed by [RIPEMD-160](https://en.bitcoin.it/wiki/RIPEMD-160)
- **base58** is the [Base58](https://en.bitcoin.it/wiki/Base58Check_encoding) encoding method

##### Pseudocode (public key -> address)
```
pub_key_hash = HASH160(public_key)
version = 0x00
raw_address = version || pub_key_hash
checksum = first 4 bytes of SHA-256(SHA-256(raw_address))
address = base58(raw_address || checksum)
```
