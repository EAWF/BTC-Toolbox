# Explodes the account level extended public key from the bitcoin wallet.
* Syntax:
  - 
* Inputs:
  - Wallet Extended Public Key
* Outputs:
  - Single Hexadecimal string which can be exploded to the following data bits:
    - Address Type: (8 bytes)  _From: https://github.com/satoshilabs/slips/blob/master/slip-0132.md_
      - xpub('_0488b21e_') - Legacy Addresses(1) - p2sh - m/44'/0' 
      - ypub('_049d7cb2_') - Segwit Compatible Addresses(3) - p2sh-p2wpkh - m/49'/0'
      - zpub('_04b24746_') - Segwit Addresses(bc1) - p2wpkh - m/84'/0'
    - Depth: (2 bytes) - Indicates derivation level of the extended public key
    - Parent Fingerprint: (8 bytes) - Matches the finger print of the parent key that created the extended account level public key
    - Account: (8 bytes) - Matches the account of the derivation path. 8xxxxxxx indicates a hardened account.
    - Parent Chain Code: (64 bytes)
    - Parent Public Key: (66 bytes)
    - Checksum: (8 bytes)
