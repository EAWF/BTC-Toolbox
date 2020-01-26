# List of Functions:
## Definitions:
* For this section, we will use the abbreviation **ExPub** to refer to the Exported Account Level Public Key extracted from a users Bitcoin HD(BIP-32) Wallet and to avoid confusion with the abbreviation xpub, which refers to a BIP-44 extended account level public key.
## Purpose:
* This area is used to collect/build the individual functions used for creating a bitcoin payment address from an exported account level extended public key obtained from a merchant/trader/seller's bitcoin HD wallet.
## Standard Functions:
These Built-in function definitions/syntax are found and described at **[PHP.net](https://php.net)**. Your programming software may have these functions named differently, however the functions you select ***should*** return the same results for successful results.
* **bin2hex('datastring')** - Convert binary string data into its hexadecimally encoded representation.
* **hex2bin('datastring')** - Decode hexadecimally encoded binary data into its binary string representation.
* **hash('sha256','datastring')** - Returns a 256 byte hashed binary representation of a text string.
* **hash('ripemd160','datastring')** - Returns a 40 byte hexadecimally encoded string from a text string.
* **hash_hmac('sha512','datastring','secretstring')** - Returns a 512 byte hexadecimally encoded hashed message digest of the text string and the text secret string;
## Non-Standard Functions:
* These functions are not usually included with mainstream programming languages and are easily created.
  - **[base58decode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/base58decode/base58decode.md)** - Inputs a Base58 encoded hexadecimal string and returns a hexadecimal string of the input.
  - **[base58encode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/base58encode/base58encode.md)** - Inputs a hexadecimal string and returns the base58 encoded hexadecimal string of the input.
  - **[chksum()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/chksum/chksum.md)** - Inputs a hexadecimal string and returns the double-sha256 checksum (8 bytes) of the input.
  - **[expubdecode()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/expubdecode/expubdecode.md)** - Inputs an **ExPub** and returns the **ExPub Extended Account Level Public Key** data and **Checksum**. 
  - **[prvkey2pubkey()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/prvkey2pubkey/prvkey2pubkey.md)** - Creates a **Public Key** from a **Private Key**.
  - **[pubkey2address()](https://github.com/EAWF/Bitcoin-Merchants-Toolbox/tree/master/Function%20Work%20Area/pubkey2address/pubkey2address.md)** - Creates a **Bitcoin Payment Address** from a **Public Key**.
