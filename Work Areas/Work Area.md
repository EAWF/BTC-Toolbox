# The Derivation Algorithm
* The Derivation procedure is governed by a Derivation Path scheme 
* The Derivation procedure is based on the derivation path
  - By definition, the derivation path of an exported **account-level extended public key** is *m/PURPOSE'/NETWORK'/ACCOUNT'/*, where:
    - PURPOSE = "0x80000044" for xpub, "0x80000049" for ypub, and "0x80000084" for zpub.
      - Depth is "00" in an extended private key for this level
    - NETWORK = "0x80000000" for MainNet and "0x80000001" for TestNet
      - Depth is "01" in an extended private key for this level
    - ACCOUNT - "0x80000000" for the first HD Account in the wallet
      - Depth is "03" in an extended public key for this level
  - This means that the Parent Public Key and the Parent Chain Code have already been derived by the wallet using each levels Master Private Keys(hardened).
  - To extract the address level public key that is used with Normal Child Key Derivation to create a public key  address, we need to derive a public address for one further level, which is the payment/change level.
* To derive a payment address from an account level extended public key, we need two inputs:
  - Exported Account-Level Extended Public Key from a HD Wallet Account.
  - An index corresponding to the payment address one wants to use to direct incoming bitcoin to the wallet's account.

## Decoding the Extended Public Key
* NOTES about checking values of the extended public key:
   - Checking the first 4 bytes is not necessary as the SLIP-132 codes directly convert to the characters in the exported public key. (ex: base58_decoding "ypub" equals "0x049d7cb2" and base58_encoding "0x049d7cb2" equals "ypub".
  - Checking the checksum is only necessary if you are using somone else's extended public key that has been sent to you electronically.
  - The Depth and Fingerprint fields are meaningless for the CKD process.
  - The Account is meaningless for the CKD process as the extended public key is exported for the specific account level of the wallet, derivation can only occur on the 0 account of that extended public key. Using a different account number in the CKD process will cause you to lose funds.
* base58_decode the exported account level extended public key. Returns binary
* Convert binary to hexadecimal string
* Extract and store the parent chain code by parsing out 64 characters(32 bytes) beginning at character 26(byte 13)
* Extract and store the parent public key by parsing out 66 characters(33 bytes) beginning at character 90(byte 45)
## Processing the Index
* For the purposes of payment address derivation, the child index(aka index, aka invoice number) is an integer within the range of 0(zero) to (2^64-1)
  - NOTE: Not sure if this is 100% accurate, but it seems to me that since hardened derivation only pertains the the first 4 fields of the derivation path(ex. m/44'/0'/A'/0/0) there doesn't seem to me to be a reason that the full range of address indexes can't be used.
* Left Pad the index with "00000000" and trim the resulting string to the rightmost 8 characters.
  - example: Index is 70, left padded is "0000000070" and right trimmed string becomes "00000070"

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
    - 0279BE667EF9DCBBAC55A06295CE870B07029BFCDB2DCE28D959F2815B16F81798 OR
  - Do I convert it somehow?
## 
