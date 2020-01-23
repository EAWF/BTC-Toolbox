# Function Work Area
* This area is used to collect/build the individual functions used for creating a bitcoin payment address from an exported account level extended public key obtained from a merchant/trader/seller's bitcoin HD wallet.
* Built-In Hash Functions:
  - [ ] bin2hex - Converts a binary number to a hexadecimal string.
  - [ ] hex2bin - Converts a hexadecimal string to a binary number.
  - [ ] hash('sha256','string') - hashes any text string to a 256 byte binary number
  - [ ] hash('ripemd160','string') - hashes text string to a 160 byte string
  - [ ] hash_hmac('sha512','parentchaincode','parentprivatekey||index') - hashes text and secret string to a 512 byte hexadecimal string
    - AKA the child key derivation function whose output is split in two equal 256 byte strings which are the:
      - Chain Code
      - Private Key
  - [ ] 
* These functions are not usually found in current programming languages and must be created:
  - [ ] base58chkencode - Encodes a hexadecimal string to a base58check string.
  - [ ] base58chkdecode - Validates and Decodes a base58check string to a hexadecimal string.
  - [ ] xpubkeydecode - explodes and validates an account level extended public key into:
