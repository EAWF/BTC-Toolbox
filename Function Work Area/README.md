# Function Work Area
* This area is used to collect/build the individual functions used for creating a bitcoin payment address from an exported account level extended public key obtained from a merchant/trader/seller's bitcoin HD wallet.
* Built-In Hash Functions that are usually built-in to a programming language:
  [x] **bin2hex** - Converts a binary number to a hexadecimal string.
  - [x] **hex2bin** - Converts a hexadecimal string to a binary number.
  - [x] **hash('sha256','string')** - hashes any text string to a 256 byte binary number
  - [x] **hash('ripemd160','string')** - hashes text string to a 160 byte string
  - [x] **hash_hmac('sha512','datastring','secretstring')** - hashes text and secret string to a 512 byte hexadecimal string
* The following functions are not usually found in current programming languages and must be created:
  - [ ] **base58chkencode()** - Encodes a hexadecimal string to a base58check string.
  - [ ] **base58chkdecode()** - Validates and Decodes a base58check string to a hexadecimal string.
  - [ ] [**xpubkeydecode()**](temp) - explodes and validates an account level extended public key.
