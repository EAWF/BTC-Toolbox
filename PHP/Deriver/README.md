# PHP version of the deriver as a function:
2
## Syntax:
3
* Derive(`XPub`,`Index`)
4
  - XPub = The exported, account-level extended public key from an existing Bitcoin HD wallet
    - XPub can be one of:
      - xpub - P2SH Address begins with 1
      - ypub - P2WPKH nested in P2SH Address begins with "3"
      - zpub - P2WPKH Address begins with "bc1"
8
  - `Index` = The address-level index for the payment address.
9
  - Returns Payment `address` - valid payment address for the wallet's account.
10
* Function self-indentifies XPub and derives the Payment Address accordingly.
