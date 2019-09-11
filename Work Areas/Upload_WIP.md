# Contribution on 20190908 by eMail.

Algorithm to derive a payment address from an Account Extended Public Key (ypub) in a hierarchical wallet

1. Extract the public key data from the Base58 encoded extended public key. This key starts with 'xpub' . 

First decode the 78 byte structure by inverting the base58 encoding. For example, in python, use the b58decode function of the base58 library.

2. Check that version bytes are for the chain desired. 

Bytes 0-3 of the 78 byte public key data should be 00488B21E for the main public chain. 

3. Check that the data corresponds to a master key. 

The depth (byte 4), fingerprint (bytes 5-8), and child number (bytes 9-12) should all be 0 for a master public key. It is all right if these are different, but then one will be generating keys which are derived from a subset of a hierarchy.

4. Extract the chain code being used. 

Bytes 13-44 are the 32 byte chain code corresponding to these addresses. This is c_par in the BIP32 spec.

5. Extract the master public key data. 

Extract bytes 45-77 of the 78 byte structure, which is the public key data, ser_p(K) in the BIP32 spec. It should start with either 0x02 or 0x03. The key data, K, itself is bytes 46-77.

6. Derive the public key at the appropriate point in the hierarchy. 

The example given is m/49'/0'/0'/0/0. That corresponds to a hardened derivation path, which is only used for derivations from a private key. So the standard algorithm would reject this as a key to be derived from an extended public key. However, this explanation will be defined in terms of what should be done to derive a child public key, which is likely what is desired. Thus, given a derivation path such as m/49/0/0/0/0, here is how to get to the child public key. 

First derive the child key corresponding to an index of 49 from the master key. This is the Public parent key -> public child key case under Child key derivation (CKD) functions in the BIP32 spec.

The following will be denoted as the CKD_pub((K_par,c_par),i) -> (K_i,c_i) function. It takes 3 pieces of data: the K_par key data, the c_par chain code, and the i index. It produces two outputs: the K_i child key data and the c_i child chain code. 

First concatenate the K_par and c_i data into a 64 byte block. Then compute the HMAC-SHA512 authentication of this 64 byte message block using the c_par 32 bytes as the key. This returns a 512 bit, 64 byte structure. Divide that into the left 32 bytes I_L and the right 32 bytes, I_R. 

Compute the corresponding key point on the elliptic curve. This is performed by multiply the 32 byte I_L by the curve genereration constant from the appropriate ecdsa curve being used, namely SECP256k1. The product should then be added to the key point, K, for the extracted key in step 5. This sum constitutes the new returned child key, K_i.

The right half, I_R, is the new chile chain code, c_i. 

End of definition of function CKD_pub. 

Using the CKD_pub function, derive the appropriate child public key by repeated application. In this example, first compute m/49 = CKD_pub((K,c_par),49). Note the result denoted m/49 consists of a pair of numbers, the new key and the new chain code. Now compute m/49/0 = CKD_pub(m/49,0). Then m/49/0/0 = CKD_pub(m/49/0,0), m49/0/0/0 = CKD_pub(m/49/0/0), m49/0/0/0/0 = CKD_pub(m/49/0/0/0,0). 

Note that this explanation does not describe to a pseudocode level the HMAC-SHA512 function or the ecdsa functions, which are standard cryptographic functions available in many libaries. 
