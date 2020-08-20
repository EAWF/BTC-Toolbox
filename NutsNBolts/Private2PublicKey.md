# Private2PublicKey

This is the most difficult part of HD Address Derivation, converting a private key to a public key using ECDSA
I've found the answer on [r/Bitcoin](https://www.reddit.com/r/Bitcoin/comments/9922jj/how_in_bitcoin_to_generate_a_public_key_from_a/).
```txt
The public key is obtained by performing the following elliptic curve multiplication equation: (private key * generator point = public key). Be aware that the * does not represent ordinary multiplication, but elliptic curve multiplication. This involves a lot of doubling and adding, but you already know about that in general, so let's use your specific example: if your private key is 1, you'll need to write it with a bunch of preceding 0s so that it represents a 64 digit number. I.e. 0000000000000000000000000000000000000000000000000000000000000001. (It might be a 256 digit number -- I forget.)

Next, you'll be using the following list of equations. You'll notice that, ordinarily, the step we're about to do involves repeatedly doubling the generator point G, but in your case, it won't. We'll see why next after I post the ordinary column of equations we need to use.

1*G
2*G
4*G
8*G
16*G
32*G
64*G
128*G

...

Keep doing that until you've got 64 lines. (It might be 256 lines -- I forget.)

Next, write the bits of the private key next to this list, such that the 1, which is the last digit of your private key, is next to the top line of the column -- like this:

1 1*G
0 2*G
0 4*G
0 8*G
0 16*G
0 32*G
0 64*G
0 128*G

...

Keep doing that for all 64 lines (maybe 256 lines -- I forget), putting a zero next to each line. (If you had an ordinary private key, the digits wouldn't all be zeroes, but you chose a private key of 1, so there's only one 1 in your private key -- the last digit, which goes at the top of the column -- while all the other digits are zeroes.)

This is the part where the "adding and multiplying" comes in, the part that everyone dreads. Do the adding first. You need to add the lines of the column together, one line after the next, but only those lines which have a 1 written next to them. I.e. in the case of private key 1, the top line will get added to nothing. You'll be left with 1*G as the only thing that needs multiplying. The rest of the lines all have zeroes next to them, so they don't get multiplied.

Let me put this another way to make it more clear. Since you've only got one line, you just have to add the solution of (1 * G) to nothing; there are no further lines to add to that first line. But if you had had a 1 next to the first line and a 1 next to the (8 * G) line, for example, you would have added (1 * G) to (8 * G), and obtained (9 * G); then, you'd look for the next line that has a 1 next to it, and add (9 * G) to that line. E.g. the next one might be (32 * G), in which case you'd add (9 * G) to (32 * G), and obtain (41 * G). At the end of all that you'd multiply a relatively large number times G, but you don't have to do that because you chose to use the simplest possible private key, 1, so you'll just multiply (1 * G).

Therefore, you'll end up with a public key that matches the generator point. The generator point, in hexadecimal, happens to be 0479BE667EF9DCBBAC55A06295CE870B07029BFCDB2DCE28D959F2815B16F81798483ADA7726A3C4655DA4FBFC0E1108A8FD17B448A68554199C47D08FFB10D4B8. That's your public key.
```

### This is a work in-progress...more to follow.
