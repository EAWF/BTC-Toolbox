# Extracts the account level extended public key data from the ExPub.
* Syntax:
  - expubkeydecode(ExPub)
* Inputs:
  - Users  Exported account level public key.
* Outputs:
  - Hexadecimal string which can be exploded to the following data specification:
    - Extended Public Key:
      - Address Type: (8 bytes)  _From: https://github.com/satoshilabs/slips/blob/master/slip-0132.md_
        - xpub('_0488b21e_') - Legacy Addresses(1) - p2sh - m/44'/0' 
        - ypub('_049d7cb2_') - Segwit Compatible Addresses(3) - p2sh-p2wpkh - m/49'/0'
        - zpub('_04b24746_') - Segwit Addresses(bc1) - p2wpkh - m/84'/0'
      - Depth: (2 bytes) - Indicates derivation level of the extended public key (_Account level is '03'_)
      - Parent Fingerprint: (8 bytes) - Matches the finger print of the parent key that created the extended account level public key
      - Account: (8 bytes) - Matches the account of the derivation path. (_Account '80000000' is the first hardened account_)
      - Parent Chain Code: (64 bytes)
      - Parent Public Key: (66 bytes)
    - Checksum: (8 bytes)
* Procedure:
```text
  1. Convert ExPub to binary with base58 function.
  2. Convert #1 to hexadecimal with bin2hex
  3. Separate #2 into:
     3.1 Extended Public Key (above)
     3.2 Checksum (above)
  4. Compare Base58CheckEncode(Extended Public Key 
```
