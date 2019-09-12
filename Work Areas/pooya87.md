# From [pooya87](https://bitcointalk.org/index.php?action=profile;u=379147) @ [BitcoinTalk.org](https://bitcointalk.org/index.php?topic=5179147.0)

1. using PBKDF2 (RFC8018) derive the BIP32 entropy from the mnemonic
Code:
byte[] pass = UTF8_Decode(mnemonic)
byte[] salt = UTF8_Decode("mnemonic" + passphrase)
Bip32_entropy = PBDKF2.GetBytes(pass, salt, c=2048, dkLen=64, PRF=HMACSHA512)`
2. use the entropy to get the private key and chain code for the master private key
Code:
  byte[] ba512 = HMACSHA512(data=entropy, key=UTF8_Decode("Bitcoin seed"))
  byt[] firstHalf = ba512.SubArray(startIndex=0, count=32)
  byt[] secondHalf = ba512.SubArray(startIndex=32, count=32)
  int256 k = firstHalf.ToInt(BigEndian=true)
  if (k == 0  OR k > Secp256k1.Order)
   fail;
  else
   continue;
  byte[] privateKey = firstHalf
  byte[] chainCode = secondHalf
int depth = 0
ParentFingerPrint = {0,0,0,0}
ChildNumber = {0,0,0,0}

3. choose a desired path
m/49'/0'/0'/0/0

4. derive child keys step by step for each index in the path (`|` is concatination)
- we already have m
- 49' (index=49 + 2^31)
- 0' (index=0 + 2^31)
- 0' (index=0 + 2^31)
- 0 (index=0)
loop for each index above:
Code:
if(index >  2^31)
    byte[] dataToHash = 0x00 | privateKey | (index).ToBytes
else
    byte[] pubKeyBytes = privateKey.ToPublicKey.TobytesCompressed
    byte[] dataToHash = pubKeyBytes | (index).ToBytes

byte[] ba512 = HMACSHA512(data=dataToHash, key=chainCode)
byt[] firstHalf = ba512.SubArray(startIndex=0, count=32)
byt[] secondHalf = ba512.SubArray(startIndex=32, count=32)
int256 k = privateKey.ToInt
k = k + firstHalf.ToInt(BigEndian=true) MOD Secp256k1.Order
if (k == 0)
   fail;
else
   continue;
byte[] privateKey = firstHalf
byte[] chainCode = secondHalf
int depth =  depth  + 1

4.1. the case for not having the mnemonic and only having the extended public key at index m/49'/0'/0'/0 (bold part above) and wanting to derive the /0 and /1 and /2 etc public keys
Code:
byte[] ba78 = Base58WithChecksum.Decode_Check_and_removeChecksum(ypubString)
byte[] ver = ba78.SubArray(0,4)
check(ver == SLIP0132_version)
byte depth = ba78.SubArray(4,1)
check(depth == depthOfTheCurrentIndex)
byte[] pubKeyBytes = ba78.SubArray(45, 33)
check(pubKeyBytes[0] != 0)

for final index:
- 0
Code:
if(index >  2^31)
    fail;
else
    byte[] dataToHash = pubKeyBytes | (index).ToBytes

byte[] ba512 = HMACSHA512(data=dataToHash, key=chainCode)
byt[] firstHalf = ba512.SubArray(startIndex=0, count=32)
EllipticCurvePoint p = (firstHalf.ToInt(BigEndian=true) * Secp256k1.Generator) + (pubKeyBytes.ToEllipticCurvePoint)
note: `*` and `+` in last line above are point multiplication and point addition on an elliptic curve!

5. getting public key
Code:
Check(p is on Secp256k1 curve)
publicKey pub = p

6. getting the address:
Code:
keyhash = RIPEMD160(SHA256(pub))
redeemScript = OP_0 <keyhash>
scriptPubKey = OP_HASH160 RIPEMD160(SHA256(redeemScript)) OP_EQUAL

checksum = SHA256(SHA256(0x05 | RIPEMD160(SHA256(redeemScript)))).SubArray(0,4)
address = Base58Encode(0x05 | RIPEMD160(SHA256(redeemScript)) | checksum)

example:
Code:
pub = 039b3b694b8fc5b5e07fb069c783cac754f5d38c3e08bed1960e31fdb1dda35c24
keyhash = f990679acafe25c27615373b40bf22446d24ff44
redeemScript = 0014f990679acafe25c27615373b40bf22446d24ff44
scriptPubKey = a9143fb6e95812e57bb4691f9a4a628862a61a4f769b87

checksum = ca97ac44
address = Base58Encode(053fb6e95812e57bb4691f9a4a628862a61a4f769bca97ac44) = 37VucYSaXLCAsxYyAPfbSi9eh4iEcbShgf
