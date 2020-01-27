# YPub Data Extractor.
## Syntax:
  - ypubkeydecode('YPub')
    - extracts raw Exported Account Level Extended Public Key data.
      - Account Level Extended Public Key
      - Checksum
## Inputs:
  - Base58CheckEncoded Exported BIP-49 account level public key from Users BTC HD Wallet (164 chars).
    - ExPubData: (156 chars)
      - Address Type: (8 chars)  _From: https://github.com/satoshilabs/slips/blob/master/slip-0132.md_
        - '_049d7cb2_' - P2SH-P2WPKH Segwit Compatible Addresses(3) - ypub - BIP-49
      - Depth: (2 chars) - Indicates derivation level of the extended public key (_Account level is '03'_)
      - Parent Fingerprint: (8 chars) - Matches the finger print of the parent key that created the extended account level public key
      - Account: (8 chars) - Matches the account of the derivation path. (_Account '80000000' is the first hardened account_)
      - Parent Chain Code: (64 chars)
      - Parent Public Key: (66 chars)
    - Checksum: (8 chars)
## Procedure:
1. Store bin2hex(base58decode('ExPub')) to 'ExPubRaw'.
2. Store ExPubRaw[1-156] _(substr(ExPubRaw,0,156))_ to 'ExPubData'
3. Store ExPubRaw[157-164] _(substr(ExPubRaw,-8))_ to 'ExPubChk'
4. Store substr(bin2hex(hash('sha256',bin2hex(hash('sha256','ExPubData')))),0,8) to 'Chksum'
5. IF 'Chksum' matches 'ExPubChk' then:
   - Return 'ExPubData'
   - ELSE
   - Return 'INVALID'
## NOTES:
* ExPub Essential Data:
  - Type:
    - ExPubData chars 1-8 or substr(ExPubData,0,8) (see above)
    - ExPub char 1 or substr(ExPub,0,1) (x, y, or z) (see above)
  - Account: ExPubData chars 18-25 or substr(ExPubData,18,8)
  - Parent Chain Code: ExPubData chars 26-89 or substr(ExPubData,26,64)
  - Parent Public Key: ExPubData chars 90-156 or substr(ExPubData,90,66)
