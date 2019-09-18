# Answer from Bitcoin Stack Exchange by [Arubi](https://bitcoin.stackexchange.com/users/64730/arubi) 
  - Edited by Bob Holden
BIP32 Extended keys can be either "private" or "public".  Both types of extended keys contain private information, enough to track key use. This mechanism is used by hardware wallets and "watch-only" software wallets on a PC.

* An extended key is just a base58 encoded serialization of a few pieces of data :

> `[ magic ][ depth ][ parent fingerprint ][ key index ][ chain code ][ key ]`

Where `key` can be either a public key or a private key.  Private keys are prepended with a single `0x00` byte, so the length of this blob stays the same.
An extended key is usually derived by "traversing" some `path`, meaning you would start your derivation at some parent extended key, and consecutively derive child keys with specific indexes until you finally derive the final extended key in the `path`.
I'll stop using "extended" in this answer.  From now on I'll refer to an extended private key as `xprv` and to an extended public key as `xpub`, and just "keys" sometimes.  Non-extended are just "private key" or "public key".

An xprv or xpub's `magic` are 4 bytes to indicate the network it belongs to: testnet or mainnet (`t` or `x` respectively), and the type of key it is (`pub` and `prv` respectively).
The `depth` is a byte that indecates how deep an xpriv or xpout is in a path, starting from `00` as the depth of the `master` key, and incremented by one as the derivation of more child keys is done along the path.
Note that up until now, the only difference between `xprv` and `xpub` keys that I mentioned is the `prv` or `pub` part in the magic.
It also should be clear that an `xprv` and `xpub` can be in the same path, and in the same depth.  This means that for such pair of `xprv` and `xpub`, the `[ key ]` part of the will have a 32 byte private key (prepended with one `00` byte) in the `xprv`, and a 33 byte public key which is the public key which which you get from the private key in the `xprv`.

A parent's fingerprint are the first 4 bytes of the `hash160` of the _public key_ of the parent.  This means that even if a parent `xprv` was used to derive a child `xprv`, it would have the same `parent fingerprint` as if a parent `xpub` was used to derive a child `xpub`.
A parent-child relationship between keys means that they are adjacent in a path.

A `path` is an n-tuple of indexes, usually in base 10, separated by `/`.  The range of an index can be between zero and and 4294967295 (or 2^32-1), where anything in `[0,2147483647]` follows _non-hardnened_ derivation, and indexes in `[2147483648,4294967295]` follow _hardened_ derivation.
You can see that each half of the range of indexes is used for a different method.  We can say that there are two ranges.  `[0,2147483647]` for non-hardened keys, and `[0h,2147483647h]` for hardened keys.  The `h` indicates that the index (we'll call it `i`) should be treated as `i + 2147483648`.
You're probably more likely to see the `h` notation as a caret `'` instead, so `1' == 1h`, but I don't think it's very pretty so I'll stick with `h` for now.

An example of what a path looks like is :

`m/0h/1/2h/2/1000000000`

The `m` means that the key at this index is a `master xprv` or `master xpub`.  A small `m` means that this extended key is a `master xprv`, and big `M` a `master xpub`.  Following the previous definitions, you can tell that `m` is the parent of the key at `0h`, and the key at `2h` is the child of the key before it at index `1`.
To make this easier to follow, we'll annote the different keys in the path with letters `{a..e}` if we mean that these are `xprv`s and `{A..B}` if `xpub`s.


    m / 0h / 1 / 2h / 2 / 1000000000
    m   a    b   c    d   e


A path is usually given with indexes in base10, but in the key itself they are encoded in hex (base16), so a `[ key index ]` is always 4 bytes with zeros prepended if needed.  The `depth` and `index` of a master key are both alwasy zero, so `00` and `00000000`, and they can get to a maximum of `FF` and `FFFFFFFF` respectively.
So `m` and `a` are parent and child, and so are `d` and `e`.  The `depth` of `b` is `02` and its index is `00000001`, and the `depth` of `c` is `03` while its index is `80000002` (80000000 + 2).
The last child key to be derived is `e`.  We can say that we followed a path starting at `m`, from it we derived the key `a` at index `0h`, then from `a` we derived the key `b` at index `1`.. and so on.  But what does it mean to derive a new key?

The remaining two elements in the extended key format, the parent's `[ chain code ]` and `[ key ]` are used together with what would be the child key's `index` to derive it. 
That means that to derive `c` from `b`, we'd feed some function with `b`'s `chain code` and `key`, and `c`'s `index`.
A specific example of our `b` and `c` would be :

	b :

	0488ADE4
	02
	5C1BD648
	00000001
	2A7857631386BA23DACAC34180DD1983734E444FDBF774041578E9B6ADB37C19
	003C6CB8D0F6A264C91EA8B5030FADAA8E538B020F0A387421A12DE9319DC93368

----------

	c :

	0488ADE4
	03
	BEF5A2F9
	80000002
	04466B9CC8E161E966409CA52986C584F07E9DC81F735DB683C3FF6EC7B1503F
	00CBCE0D719ECF7431D88E6A89FA1483E02E35092AF60C042B1DF2FF59FA424DCA

The fields are ordered as in the structure above.  On both, the `magic` says `xprv`, the `depth` is incremented between the parent and child, the `fingerprint` at `c` is the `hash160` of the public key that you would get from the private key at `b`, and `b`'s `index` is in the first, non-hardened half of the range while `c`'s is the second, hardned half.  Finally the `chain code` and `key`s of each of the `xprv`s are encoded.

Deriving the `chain code` and `key` for `c` from `b` is done with a process called `CKDpriv`, which means deriving a child `xprv` from a parent `xprv`.  In this process we used the `chain code` and `key` from `b`, and the `index` from `c`.
The important point to make: We only encoded `c` _after_ deriving its `chain code` and `key` from what would be its `index`.

Any `xprv` can be used with `CKDpriv` to derive a child `xprv` at any `index`.  The specific way `CKDpriv` will act on the input depends on the child's `index` being in the hardened range, or the non-hardned range.  Basically, a `CKDpriv` function runs an `HMAC-SHA512` on the parent's `chain code` and `key`, and the child's `index`.  This hmac function takes two values a `key*` (not to be confused with our occurences of `key`, will be refered to as `hkey`), and `text`.
The parent's `chain code` is used as the `hkey`, while the `text` is made up of the parent's `key` in the _private key_ form if the the child's index is in the hardened range, `[0h,2147483647h]`, and in the _public key_ form if the index is in the non-hardened range.  It is then concatenated with the child's `index`.

`c`'s index is in the hardened range, so `CKDpriv`'s hmac-sha512 runs with the inputs:

	HMAC-SHA512( 2A7857631386BA23DACAC34180DD1983734E444FDBF774041578E9B6ADB37C19,
	             003C6CB8D0F6A264C91EA8B5030FADAA8E538B020F0A387421A12DE9319DC9336880000002 )

Which returns a 64 byte hash :

    8F6154A0A82D0F68B9E5B586EA66D951DAAA071BEBD390097CC516285C791A6204466B9CC8E161E966409CA52986C584F07E9DC81F735DB683C3FF6EC7B1503F

The 32 bytes on the right half of this hash, `04466B9C...C7B1503F` become the child's (`c` here) `chain code`, and the 32 bytes on the left are used to "tweak", meaning just "addition mod n" to the parent's key, in this example :

	  8F6154A0A82D0F68B9E5B586EA66D951DAAA071BEBD390097CC516285C791A62
	+
	  3C6CB8D0F6A264C91EA8B5030FADAA8E538B020F0A387421A12DE9319DC93368
	=
	  CBCE0D719ECF7431D88E6A89FA1483E02E35092AF60C042B1DF2FF59FA424DCA   mod n

* I didn't write the `00` prepended bytes in the keys here because this is just adding numbers, but those zero bytes are very important for the hash function, so I purposely included them there.

Now that we've got `c`'s `chain code` and `key` (in private key form), we would want to actually encode `c` for it to be a usable `xprv`.
To get the `fingerprint` from `b`, we need to know the public key of the `key` from `b`.  Since it's in private key form, we'll have to do multiplication:

	CBCE0D719ECF7431D88E6A89FA1483E02E35092AF60C042B1DF2FF59FA424DCA * G
	= 03501E454BF00751F24B1B489AA925215D66AF2234E3891C3B21A52BEDB3CD711C

Take the `hash160` of this public key, and the returned hash is `BEF5A2F9A56A94AAB12459F72AD9CF8CF19C7BBE`.
The first four bytes are `b`'s fingerprint : `BEF5A2F9`.
Encoding the rest of `c` is easy.  Start with the magic `xprv` since we derived a child `xprv`, increment the depth of `b` by one, then the `fingerprint`.
Next `c`'s `index` is encoded.  We derived index `2h`, so this would be `80000002`, and then the new `chain code` and `key` that we got from `CKDpriv`.

This is basically what _hardened_ derivation is.  The parent's private key and chain code are used to derive the child key at some hardened index.
What if we want to derive `d`?  It's at index `2`, so a non-hardened index.  This is the second case of `CKDpriv`.

The difference is in what is used for the `text` parameter of the `HMAC-SHA512` function.  Instead of using the parent's `key` in private key form, we use the public key form, so to derive `d` at index `2` from `c`, we first find the public key of `c` :

	CBCE0D719ECF7431D88E6A89FA1483E02E35092AF60C042B1DF2FF59FA424DCA * G
	= 0357BFE1E341D01C69FE5654309956CBEA516822FBA8A601743A012A7896EE8DC2

Then continue following the same steps as the above:

	HMAC-SHA512( 04466B9CC8E161E966409CA52986C584F07E9DC81F735DB683C3FF6EC7B1503F,
	             0357BFE1E341D01C69FE5654309956CBEA516822FBA8A601743A012A7896EE8DC200000002 )

	                            tweak                                                            chain code
	437984D45C4A2F5840C65B3DC6D7274E2859AD25D092DB032C49AA4D006A426B|CFB71883F01676F587D023CC53A35BC7F88F724B1F8C2892AC1275AC822A3EDD
* note that `00` is not prepended to the `text`, since this is a public key.

	  437984D45C4A2F5840C65B3DC6D7274E2859AD25D092DB032C49AA4D006A426B
	+
	  CBCE0D719ECF7431D88E6A89FA1483E02E35092AF60C042B1DF2FF59FA424DCA
	=
	  0F479245FB19A38A1954C5C7C0EBAB2F9BDFD96A17563EF28A6A4B1A2A764EF4   mod n

	hash160( 0357BFE1E341D01C69FE5654309956CBEA516822FBA8A601743A012A7896EE8DC2 )

	finger
	   print
	EE7AB90C|DE56A8C0E2BB086AC49748B8DB9DCE72

The rest is easy, and we can encode :

	d :

	0488ADE4
	04
	EE7AB90C
	00000002
	CFB71883F01676F587D023CC53A35BC7F88F724B1F8C2892AC1275AC822A3EDD
	000F479245FB19A38A1954C5C7C0EBAB2F9BDFD96A17563EF28A6A4B1A2A764EF4

The difference between these two methods of deriving child `xprv`s is subtle but important.  It enables `CKDpub`, which is a function to derive child `xpub`s from a _parent_ `xpub`.  `CKDpub` works almost the same as `CKDpriv`'s non-hardened derivation, but it does the derivation using point addition,  so rather than adding up integers to make child private keys, we're adding up points to make child public keys.
Notice how in the non-hardened derivation we used the parent's public point for the `HMAC-SHA512`, we used the `tweak` as the added value to the parent private key to derive the child private key, specifically, we derived `d`'s private key.

To understand `CKDpub`, it helps to first know about yet another BIP32 function called `Neuter`.  It's purpose is to convert an `xprv` to an `xpub`.
Let's "run" `Neuter` on our `xprv` `d`.  We'll call the resulting `xpub` `D`.  `Neuter` does two things to an `xprv`:
1. Replace the `magic` from `0488ADE4` to `0488B21E` (replaces `xprv` with `xpub`)
2. Replaces the private key in the `key` field` with the public point of the same private key

for our `xprv` `d`, the public point is:

    0F479245FB19A38A1954C5C7C0EBAB2F9BDFD96A17563EF28A6A4B1A2A764EF4 * G
    = 02E8445082A72F29B75CA48748A914DF60622A609CACFCE8ED0E35804560741D29

(this is just normal process of private key -> public key)

so the result is:

	D:

	0488B21E
	04
	EE7AB90C
	00000002
	CFB71883F01676F587D023CC53A35BC7F88F724B1F8C2892AC1275AC822A3EDD
	02E8445082A72F29B75CA48748A914DF60622A609CACFCE8ED0E35804560741D29

Now `d` is "neutered", `D` has the public key encoded, but see how the `chain code`, `depth`, `fingerprint` and `index` persisted.  The `xpub` `D` is at the same position in the path as the `xprv` `d`.  We will be using the `chain code` and `key` (public key) for `CKDpub`, same as `CKDpriv` with non-hardened derivation, but as for `CKDpriv`, we derived the child private key using:

    tweak + (parent private key) = child private key

for `CKDpub` we will be using:

    tweak*G + (parent public key) = child public key

This works because `parent public key` is really just `(parent private key)*G`, and `child public key` is just `(child private key)*G`.  That is, if we take the `CKDpriv` tweak equation and multiply all elements by `G`, we get exactly the `CKDpub` tweak equation.
`CKDpub` can only derive child `xpub` keys in the non-hardened index range.  This is because the information present in the parent `xpub`, specifically the public key in the `[ key ]`, only applies to the non-hardened range.
Where in `CKDpriv` we could use the private key to know the public key, we can't go the other way.  the `HMAC-SHA512` round that uses public keys in `CKDpriv` applies to the non-hardened index range.

Now that we have neutered `d` to create the xpub `D`, next in the path is `e`'s with index 1000000000 (or `3B9ACA00`), which is in the non-hardened range, so we should be able to derive `E` the child `xpub` from `D` using `CKDpub`.  We start with hmac-sha512 of the parent `chain code` as `hkey` and parent `key` (public key) concatenated with the child `E`'s index :

	HMAC-SHA512( CFB71883F01676F587D023CC53A35BC7F88F724B1F8C2892AC1275AC822A3EDD,
	             02E8445082A72F29B75CA48748A914DF60622A609CACFCE8ED0E35804560741D293B9ACA00 )

	                            tweak                                                            chain code
	37D3E49D8ECB854CC518BBA096F46795A9707860BF0FC95E5B19278C997098D4|C783E67B921D2BEB8F6B389CC646D7263B4145701DADD2161548A8B078E65E9E

Multiply the tweak by the generator `G` so we can tweak the parent's public key using point addition :

	37D3E49D8ECB854CC518BBA096F46795A9707860BF0FC95E5B19278C997098D4 * G
	= 0327E992F68217BC3E88CFFC3FEAB475880145413CBE008DB22B496DF4E1C3F864  <- tweak*G

Add the tweak to the parent point.  The result is the child's public key :

	  0327E992F68217BC3E88CFFC3FEAB475880145413CBE008DB22B496DF4E1C3F864
	+
	  02E8445082A72F29B75CA48748A914DF60622A609CACFCE8ED0E35804560741D29
	=
	  022A471424DA5E657499D1FF51CB43C47481A03B1E77F951FE64CEC9F5A48F7011

Get the paren'ts fingerprint :

	hash160(02E8445082A72F29B75CA48748A914DF60622A609CACFCE8ED0E35804560741D29) = D880D7D8....

Finally we can encode `E` :

	0488B21E
	05
	D880D7D8
	3B9ACA00
	C783E67B921D2BEB8F6B389CC646D7263B4145701DADD2161548A8B078E65E9E
	022A471424DA5E657499D1FF51CB43C47481A03B1E77F951FE64CEC9F5A48F7011

Neutering `d` to make `D` then deriving `E`, we can say that our path now looks like :

    m / 0h / 1 / 2h / 2 / 1000000000
    m / a  / b / c  / D / E

Or we can use the `N()` notation (for Neuter) to show where `CKDpub` was used, but I think it's less pretty.
`m / a  / b / c  / N(d / e)`

So to recap on your question, there are 3 different derivation methods, two using private keys and one using public keys :

 1. `CKDpriv` to derive a child `xprv` at a hardened index
 2. `CKDpriv` to derive a child `xprv` at a non-hardend index
 3. `CKDpub` to derive a child `xpub` at a non-hardened index

