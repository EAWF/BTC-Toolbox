# Deriving Addresses from a BIP44 Account-Level Extended Public Key (xpub)

[BIP44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) is a Bitcoin Improvement Proposal which standardizes how addresses are derived in an account-like structure. BIP44 extended keys start with `xpub` (ex: `xpub6CLfqgeNzEvu1RSMfY4uU7vMCpobtU1Z8BofwUjz9msJUnAuzHfxo6MzW4XH26TGXKW5qBgwqumShCPSFQANnEHgk7ncCyLK15ocBk8aTAt`). Addresses derived from BIP44 Account-Level Extended Public Keys start with `1` (ex: `1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2`) and are referred to as [P2PKH](https://en.bitcoinwiki.org/wiki/Pay-to-Pubkey_Hash) (Pay To Public Key Hash) addresses. P2PKH addresses are the first address type ever used in Bitcoin, and are the most common form of transaction on the Bitcoin network.

## Extended Keys
An extended key is a private or public key accompanied by a [chain code](https://bitcoin.org/en/glossary/chain-code) to faciliate in the derivation of child extended keys. A private extended key is able to derive *private* and *public* information, whereas a public extended key only allows the derivation of *public* information. **You should never share an extended private key with anyone! Doing so will give them access to all of your funds.**

#### Account-Level Extended Public Keys
Extended public keys that are exported from modern wallet software such as [Electrum](https://electrum.org) and [Mycelium](https://mycelium.com/) are known as account extended public keys. The account extended public key is used to derive *external* (receiving) and *internal* (change) child extended keys. For the purposes of this guide, we will only focus on the external child extended key.

#### External-Level Extended Public Keys
External extended public keys are used to derive all addresses that a wallet presents as a "receive" address. A child extended public key is derived from the external-level extended key, and its public key component is used as the public key for an address. The method used to derive a child extended key from a parent extended key is known as [CKDpub](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki#public-parent-key--public-child-key).

#### CKDpub Function
The CKDpub function deterministically derives child extended keys in a non-reversible way. It is impossible to link a parent key to a child key, but possible to link a child key to a parent key. The parent's Chain Code is used as the **Key** and the parent's Public Key concatenated with the Derivation Index is used as the **Data** in an [HMAC-SHA512](https://en.wikipedia.org/wiki/HMAC) cryptographic message authentication function to obtain a new Chain Code and a new Public Key.

CKDpub takes 3 inputs:
- Parent Public Key `K_parent`
- Parent Chain Code `C_parent`
- Derivation Index `i`

and returns 2 outputs:
- Child Public Key `K_child`
- Child Chain Code `C_child`

In the pseudocode below, the following assumptions are made:
- **||** is the concatenation of bytes
- **scalarMultiply** is [Elliptic Curve Point Multiplication](https://en.wikipedia.org/wiki/Elliptic_curve_point_multiplication#Point_multiplication) of the Base Point `G` by the parameter specified (see [SECP256K1 Curve Parameters](https://en.bitcoin.it/wiki/Secp256k1) for more details about the Base Point)
- **scalarAddition** is [Elliptic Curve Point Addition](https://en.wikipedia.org/wiki/Elliptic_curve_point_multiplication#Point_addition) of two points on the SECP256K1 curve

##### Pseudocode (parent extended public key + index -> child extended public key)
```
hmac_data = K_parent || i
hmac_key = C_parent
I = HMAC-SHA512(hmac_key, hmac_data)
I_L = first 32 bytes of I
I_R = last 32 bytes of I
K_tweak = scalarMultiply(I_L)
K_child = scalarAddition(K_parent, K_tweak)
C_child = I_R
return K_child || C_child
```

Note that an extended public key is the combination of a Public Key and a Chain Code, thus CKDpub technically has 2 inputs (extended public key + index) and returns 1 output (child extended public key). CKDpub only works with **non-hardened** derivation indeces (`i` must be between 0 and 2^31-1).

## Addresses
A bitcoin address is simply a [script](https://en.bitcoin.it/wiki/Script) encoded in a [human-readable format](https://en.wikipedia.org/wiki/Human-readable_medium). There is no such thing as an address on the blockchain -- only scripts are stored. Wallet and blockchain explorer software interprets the scripts and formats them as addresses. Most addresses contain information about a public key in the form of a [cryptographic hash](https://en.wikipedia.org/wiki/Cryptographic_hash_function), so that anyone with knowledge of the private key for the public key will be allowed to spend the bitcoin associated with the address.

To obtain an address from an External-Level Extended Public Key, perform the CKDpub function on the extended key to obtain a child extended public key. The public key of the child extended key is used as the public key for an address.

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
return address
```
