# The yPub Algorithm
* To derive a payment address from an account level extended public key, we need two inputs:
  - Exported Account-Level Extended Public Key from a BIP49 HD Wallet Account.
  - An index

## Decoding the yPUb
* base58_decode the exported account level extended public key. Returns binary
* Convert binary to hexadecimal string
* Extract the parent chain code by parsing out 64 characters beginning at character 26
* Extract the parent public key by parsing out 66 characters beginning at character 90
* Store the parent chain code for use in the derivation algorithm
* Store the parent public key for use in the derivation algorithm

## BIP32 Child Key Derivation algorithm
* Concatenate the parent public key with the 4 byte index.
* HMAC-SHA512(parent chain code,concatenated parent public key and index).
* Split I into two 32-byte sequences:, IL and IR.
* The returned child key Ki is point(parse256(IL)) + Kpar.
  - parse256(p): interprets a 32-byte sequence as a 256-bit number, most significant byte first.
* The returned chain code ci is IR.
## The Mysterious Generator Point "G":
* G = 02 79BE667E F9DCBBAC 55A06295 CE870B07 029BFCDB 2DCE28D9 59F2815B 16F81798
  - So, what IS this? Is it:
    - 0279BE667EF9DCBBAC55A06295CE870B07029BFCDB2DCE28D959F2815B16F81798
  - Do I convert 
## 
