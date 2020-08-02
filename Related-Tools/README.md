   # Tools Related to Bitcoin Programming/Computation
   ## ECDSA Encryption Methods
   THIS is the main method of insuring security of the Bitcoin Network/System.
   ## Data Integrity Verification Methods
   * Necessary for validating data which has been transmitted manually and electronically.
   * 2 Types:
     - [Base58](https://en.bitcoin.it/Base58Check_encoding)Check Encoding/Decoding
       - Used for
         - [P2SH]() "Legacy" Addresses("1") from xpubs. 
         - [P2SH<-P2WPKH]() "Segwit-Compatible" Addresses("3") from ypubs.
     - [Base32](https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki) address format for native v0-16 witness outputs
       - Used for
         - []() "Bech32" Addresses("bc1") from zpubs.
   
