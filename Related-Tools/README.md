   # Tools Related to Bitcoin Programming/Computation
   ## ECDSA Encryption Methods
   THIS is the main method of insuring security of the Bitcoin Network/System.
   ## Data Integrity Verification Methods
   * Necessary for validating data which has been transmitted manually and electronically.
     - [Base58](https://en.bitcoin.it/Base58Check_encoding)Check Encoding/Decoding
       - Used for:
         - [HD Extended Keys](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki) - Encoding/Decoding to/from transmission.
         - [P2SH](https://github.com/bitcoin/bips/blob/master/bip-0044.mediawiki) - "Legacy" Addresses("1") from xpubs. 
         - [P2SH<-P2WPKH](https://github.com/bitcoin/bips/blob/master/bip-0049.mediawiki) - "Segwit-Compatible" Addresses("3") from ypubs.
     - [Base32]() address format for native v0-16 witness outputs
       - Used for:
         - [P2WPKH](https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki) "" Addresses("bc1") from zpubs.
   
