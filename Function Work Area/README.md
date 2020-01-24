# Function Work Area
* This area is used to collect/build the individual functions used for creating a bitcoin payment address from an exported account level extended public key obtained from a merchant/trader/seller's bitcoin HD wallet.
* Built-In Hash Functions that are usually built-in to a programming language:
  - **bin2hex(binary_number)** - Converts a binary number to a hexadecimal string.
  - **hex2bin(hexadecimal_string)** - Converts a hexadecimal string to a binary number.
  - **hash('sha256','string')** - hashes any text string to a 256 byte binary number
  - **hash('ripemd160','string')** - hashes text string to a 160 byte string
  - **hash_hmac('sha512','datastring','secretstring')** - hashes text and secret string to a 512 byte hexadecimal string
* The following functions are not usually found in current programming languages and must be created:
  - **[base58chkencode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/base58chkencode/base58chkencode.md)** - Encodes a hexadecimal string to a base58check string.
  - **[base58chkdecode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/base58chkdecode/base58chkdecode.md)** - Validates and Decodes a base58check string to a hexadecimal string.
  - **[xpubkeydecode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/xpubkeydecode/xpubkeydecode.md)** - Converts an account level extended public key to hexadecimal text.
  - **[prvkey2pubkey()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/xpubkeydecode/xpubkeydecode.md)** - Converts a private key to a public key.
