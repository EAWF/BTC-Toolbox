# PHP version of the deriver as a function:
## Syntax:
* Derive(`XPub`,`Index`)
  - XPub = The exported, account-level extended public key from an existing Bitcoin HD wallet
    - XPub can be one of:
      - xpub - P2SH Address begins with 1
      - ypub - P2WPKH nested in P2SH Address begins with "3"
      - zpub - P2WPKH Address begins with "bc1"
  - `Index` = The address-level index for the payment address.
  - Returns Payment `address` - valid payment address for the wallet's account.
* Function self-indentifies XPub and derives the Payment Address accordingly.
