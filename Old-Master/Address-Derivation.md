# Deriving Addresses from an Account-Level Extended Public Key

### Extended Keys
An extended key is a private or public key accompanied by a [chain code](https://bitcoin.org/en/glossary/chain-code) to faciliate in the derivation of child extended keys. A private extended key is able to derive *private* and *public* information, whereas a public extended key only allows the derivation of *public* information. **You should never share an extended private key with anyone! Doing so will give them access to all of your funds.**

#### Account-Level Extended Public Keys
Extended public keys that are exported from modern wallet software such as [Electrum](https://electrum.org) and [Mycelium](https://mycelium.com/) are known as account extended public keys. The account extended public key is used to derive *external* (receiving) and *internal* (change) child extended keys. For the purposes of this guide, we will only focus on the external child extended key.

#### External-Level Extended Public Keys
External extended public keys are used to derive all addresses that a wallet presents as a "receive" address. A child extended public key is derived from the external-level extended key, and its public key component is used as the public key for an address. The method used to derive a child extended key from a parent extended key is known as [CKDpub](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki#public-parent-key--public-child-key).

### CKDpub Function
![CKDpub Flowchart](/Images/CKDpub.png)

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

#### Pseudocode (parent extended public key + index -> child extended public key)
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

### Addresses
![CKDpub Flowchart](/Images/AddressDerivationTechnical.png)

A bitcoin address is simply a [script](https://en.bitcoin.it/wiki/Script) encoded in a [human-readable format](https://en.wikipedia.org/wiki/Human-readable_medium). There is no such thing as an address on the blockchain -- only scripts are stored. Wallet and blockchain explorer software interprets the scripts and formats them as addresses. Most addresses contain information about a public key in the form of a [cryptographic hash](https://en.wikipedia.org/wiki/Cryptographic_hash_function), so that anyone with knowledge of the private key for the public key will be allowed to spend the bitcoin associated with the address.

To obtain an address from an External-Level Extended Public Key, perform the CKDpub function on the extended key to obtain a child extended public key. The public key of the child extended key is used as the public key for an address. 

Extended keys and address types (excluding native segwit) use [Base58Check encoding](https://en.bitcoin.it/wiki/Base58Check_encoding) - a modified Base58 bytes-to-text encoding with a checksum appended to the payload for error detection. The payload includes "version" byte(s) prepended. For example, in P2PKH legacy addresses, the version byte is `0x00` (encodes to `1`), and for BIP44 extended public keys, the version bytes are `0x0488B21E` (encodes to `xpub`). A list of version bytes can be found at [SLIP-0132](https://github.com/satoshilabs/slips/blob/master/slip-0132.md). The checksum is comprised of the first 4 bytes of a double SHA-256 hash of the payload (version bytes included).

Native segwit addresses (P2WPKH) use [Bech32 encoding](https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32) - a modified Base32 bytes-to-text encoding with a checksum appended to the payload for error correction and detection. Bech32 encoded strings are composed of 3 parts: the **human-readable part**, the **separator**, and the **data part**. The human-readable part for P2WPKH addresses is `bc`, and the separator is always `1`. Thus, all native segwit addresses on the bitcoin mainnet start with `bc1`. The checksum is always the last 4 characters of the data part, and contains no information other than for [BCH code](https://en.wikipedia.org/wiki/BCH_code) error checking.

**Note:** Images and pseudocode exclude the human-readable part, separator, and checksum as they are implied to be automatically appended when encoding, and removed after decoding and verifying.

### P2PKH
[BIP44](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) is a Bitcoin Improvement Proposal which standardizes how addresses are derived in an account-like structure. BIP44 extended keys start with `xpub` (ex: `xpub6CLfqgeNzEvu1RSMfY4uU7vMCpobtU1Z8BofwUjz9msJUnAuzHfxo6MzW4XH26TGXKW5qBgwqumShCPSFQANnEHgk7ncCyLK15ocBk8aTAt`). Addresses derived from BIP44 Account-Level Extended Public Keys start with `1` (ex: `1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2`) and are referred to as [P2PKH](https://en.bitcoinwiki.org/wiki/Pay-to-Pubkey_Hash) (Pay To Public Key Hash) addresses. P2PKH addresses are the first address type ever used in Bitcoin, and are the most common form of transaction on the Bitcoin network. The typical BIP44 derivation path is `m/44'/0'/0'`.
For BIP44 wallets, P2PKH addresses -- also known as "legacy addresses" -- are used. For a technical background of legacy addresses, click [here](https://en.bitcoin.it/wiki/Technical_background_of_version_1_Bitcoin_addresses).
Example Address: `1E5FY55B8AWf6iHC3pdQ4F7f6oXqpaqe8M`

In the pseudocode below, the following assumptions are made:
- **||** is the concatenation of bytes
- **HASH160** is [SHA-256](https://en.bitcoin.it/wiki/SHA-256) followed by [RIPEMD-160](https://en.bitcoin.it/wiki/RIPEMD-160)
- **base58Check** is the [Base58](https://en.bitcoin.it/wiki/Base58Check_encoding) encoding method, including the checksum

#### Pseudocode (public key -> legacy address)
```
pub_key_hash = HASH160(public_key)
version = 0x00
raw_address = version || pub_key_hash
address = base58Check(raw_address)
return address
```

### P2SH-P2WPKH
[BIP49](https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki) is a Bitcoin Improvement Proposal which standardizes how [P2SH-P2WPKH](https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki#p2wpkh-nested-in-bip16-p2sh) addresses are derived in an account-like structure. BIP49 extended keys start with `ypub` (ex: `ypub6XEx6G1kXkQibbPVPEezYskDLaFhQUiNdbQBTymoo2MgiKsFr9bnLRr75EmGBcnmzBFt9QAGDSHxeUNycm2tkTo66aEvjVsDMGWZtijCEj8`). Addresses derived from BIP49 Account-Level Extended Public Keys start with `3` (ex: `32kVqkUjdTXLk2C4iBEQzUbNLsSenQifTt`) and are referred to as P2SH-P2WPKH (Pay To Witness Public Key Hash nested in Pay To Script Hash) addresses. P2SH-P2WPKH addresses allow for the use of [Segwit](https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki) that is backward-compatible with older wallet software and bitcoin nodes, so that the users of P2SH-P2WPKH addresses can partially benefit from the lower fees of segwit. This address type is the second most common form of transaction on the Bitcoin network. The typical BIP49 derivation path is `m/49'/0'/0'`.

For BIP49 wallets, P2SH-P2WPKH addresses -- also known as "segwit addresses" -- are used.
Example Address: `32kVqkUjdTXLk2C4iBEQzUbNLsSenQifTt`

In the pseudocode below, the following assumptions are made:
- **||** is the concatenation of bytes
- **HASH160** is [SHA-256](https://en.bitcoin.it/wiki/SHA-256) followed by [RIPEMD-160](https://en.bitcoin.it/wiki/RIPEMD-160)
- **base58Check** is the [Base58](https://en.bitcoin.it/wiki/Base58Check_encoding) encoding method, including the checksum

#### Pseudocode (public key -> segwit address)
```
pub_key_hash = HASH160(public_key)
version = 0x05
witness_program = 0x00 || 0x14 || pub_key_hash
raw_address = version || HASH160(witness_program)
address = base58Check(raw_address)
return address
```

### P2WPKH
[BIP84](https://github.com/bitcoin/bips/blob/master/bip-0084.mediawiki) is a Bitcoin Improvement Proposal which standardizes how [P2WPKH](https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki#p2wpkh) addresses are derived in an account-like structure. BIP84 extended keys start with `zpub` (ex: `zpub6rSY1F5aH9TDByNxUE6T5mNWVAJ6iLebADyhUCcXhHADSPMT9acWoRWz7QDpuJScZjByMvd99CnhwDRzgh6Ym1GwQ1LdWz6vP7QFnMQgbYC`). Addresses derived from BIP84 Account-Level Extended Public Keys start with `bc1` (ex: `bc1qtyhdcwnwnc0rhqj076zd9fufce789s4g06ph2u`) and are referred to as P2WPKH (Pay To Witness Public Key Hash) addresses. P2WPKH addresses are a native implementation of Segwit that is not backward-compatible with older wallet software and bitcoin nodes, but takes full advantage of lower fees. Adoption of P2WPKH addresses -- also known as "Native Segwit addresses" or "Bech32 addresses" -- is rising, but [there are still services that do not support segwit yet.](https://en.bitcoin.it/wiki/Bech32_adoption) The typical BIP84 derivation path is `m/84'/0'/0'`.

For BIP84 wallets, P2WPKH addresses -- also known as "native segwit addresses" or "bech32 addresses" -- are used.
Example Address: `bc1qtyhdcwnwnc0rhqj076zd9fufce789s4g06ph2u`

In the pseudocode below, the following assumptions are made:
- **||** is the concatenation of bytes
- **HASH160** is [SHA-256](https://en.bitcoin.it/wiki/SHA-256) followed by [RIPEMD-160](https://en.bitcoin.it/wiki/RIPEMD-160)
- **bech32** is the [Bech32](https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki#bech32) encoding method

#### Pseudocode (public key -> bech32 address)
```
pub_key_hash = HASH160(public_key)
version = "bc1"
witness_program = 0x00 || 0x14 || pub_key_hash
address = bech32(version, witness_program)
return address
```
