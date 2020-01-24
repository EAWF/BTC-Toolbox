# ExPub Data Extractor.
## Syntax:
  - expubkeydecode('ExPub')
    - extracts raw Exported Account Level Extended Public Key data.
      - Account Level Extended Public Key
      - Checksum
## Inputs:
  - Base58CheckEncoded Exported account level public key from Users BTC HD Wallet.
    - ExPubData: (156 chars)
      - Address Type: (8 chars)  _From: https://github.com/satoshilabs/slips/blob/master/slip-0132.md_
        - xpub('_0488b21e_') - Legacy Addresses(1) - p2sh - m/44'/0' 
        - ypub('_049d7cb2_') - Segwit Compatible Addresses(3) - p2sh-p2wpkh - m/49'/0'
        - zpub('_04b24746_') - Segwit Addresses(bc1) - p2wpkh - m/84'/0'
      - Depth: (2 chars) - Indicates derivation level of the extended public key (_Account level is '03'_)
      - Parent Fingerprint: (8 chars) - Matches the finger print of the parent key that created the extended account level public key
      - Account: (8 chars) - Matches the account of the derivation path. (_Account '80000000' is the first hardened account_)
      - Parent Chain Code: (64 chars)
      - Parent Public Key: (66 chars)
    - Checksum: (8 chars)
## Procedure:
1. Store the result of bin2hex(base58decode('ExPub')) to 'ExPubRaw'.
2. Store ExPubRaw[0-155] to ExPubData
3. Store ExPubRaw[156-163] to ExPubChk
4. Return ExPubData, ExPubChk
