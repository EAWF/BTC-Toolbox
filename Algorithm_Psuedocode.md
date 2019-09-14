# Algorithm Psuedocode
This should be written in plain, relatively easy to understand english, programming language inspecific, with the exception of standard hashing, base conversion, and string manipulation functions described here:
* SHA-256
* HMAC(SHA512)
* Base58
  - Encode
  - Decode
* RIPEMD160
# Derivation Phases:
## Extract Change level public key from account-level extended pubic key
1. Export Account-Level Extended Public Key from the HD wallet.
2. Decode the Account-Level Extended Public Key with Base58 function
   - Output will be binary.
3. Convert output from step 2 from binary to a big-endian hexadecimal string
4. 
