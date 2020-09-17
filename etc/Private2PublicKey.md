# Private2PublicKey
The most difficult part of HD Address Derivation is to convert a private key to a public key:

* I've found what I feel is the best answer:

[How do you get a bitcoin public key from a private key?](https://bitcoin.stackexchange.com/questions/25024/how-do-you-get-a-bitcoin-public-key-from-a-private-key)

*Using small numbers to keep it readable.*

Convert the private key to binary representation, so decimal number 105, which is 0x69 in hex, becomes 01101001.

calculate this list of points, by repeatedly doubling the Generator point G:
```txt 
1*G
2*G = G+G
4*G = 2*G + 2*G
8*G = 4*G + 4*G
16*G = 8*G + 8*G
32*G = 16*G + 16*G
64*G = 32*G + 32*G
```

Write the bits of the private key next to this list like this:
```txt
privkey    pointlist
   1          1*G
   0          2*G
   0          4*G
   1          8*G
   0         16*G
   1         32*G
   1         64*G
```

now start adding only those points which hava a 1 written next to them.
```txt
    9*G = 1*G + 8*G
   41*G = (9+32)*G = 9*G + 32*G
  105*G = (41+64)*G = 41*G + 64*G
```
You have now calculated the public key for privatekey 105 by using only point doubling and point adding operations.

The actual value will be:
```txt
(0xf219ea5d6b54701c1c14de5b557eb42a8d13f3abbcd08affcc2a5e6b049b8d63,
 0x4cb95957e83d40b0f73af4544cccf6b1f4b08d3c07b27fb8d8c2962a400766d1)
 ```
It's helpful to remember that the public key is simply the private key multiplied by the generator point G, so at the simplist instance, if the private key is 1, the public key is 1 * G, or G, the generator point itself. Applying simple mathematical concepts helps to understand that the public key of the private key 2 is 2 times the generator point, or G+G, etc.
