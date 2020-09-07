## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - **getBTCAddress**
  - [getBTCBalance]
  - [getBTCInvoice]
  - [getBTCRate]
  - [getBTCPrice]
- [Developer Documentation][DevDocs]

# getBTCAddress
Function that returns an address of an account defined in the [getBTC.conf] file at a specific index.

### Inputs
- Account Name
  - Type: string
  - Restrictions:
    - Must be defined in the [getBTC.conf] file
  - Description: Name of the account in [getBTC.conf] that refers to an extended public key
- Child Index
  - Type: integer
  - Restrictions:
    - Must be in the range `0 <= x < 2^31`
  - Description: Index of the Address to derive

### Outputs
- Bitcoin Address
  - Type: string
  - Description: Address of the given account extended public key at the given index

## Usage
In the usage examples below, it is assumed you have a [getBTC.conf] file. The getBTC.conf file for these examples is as follows:
```txt
PhysicalProducts:xpub6BosfCnifzxcFwrSzQiqu2DBVTshkCXacvNsWGYJVVhhawA7d4R5WSWGFNbi8Aw6ZRc1brxMyWMzG3DSSSSoekkudhUd9yLb6qx39T9nMdj
DigitalProducts:ypub6Ww3ibxVfGzLrAH1PNcjyAWenMTbbAosGNB6VvmSEgytSER9azLDWCxoJwW7Ke7icmizBMXrzBx9979FfaHxHcrArf3zbeJJJUZPf663zsP
Donations:zpub6rVZC52z8ugGany9wytHSPQ3DnfvKNPM4Em2tTLPeE2TGd9i5hmjC2kwXNt8oMHAdXruRQAkuqWYmKraSaip3xfPjTq4zKCAJiYGKpmcZ9B
```

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
```php
<?php
require_once('getBTC.php');

# Print the address at index 0 for "PhysicalProducts" account
$address = getBTCAddress("PhysicalProducts", 0);
echo "Address at index 0 of the Physical Products account is: " . $address;

# Print the address at index 50 for "DigitalProducts" account
$address = getBTCAddress("DigitalProducts", 50);
echo "Address at index 50 of the DigitalProducts account is: " . $address;

# Print the address at index 123456 for "Donations" account
$address = getBTCAddress("Donations", 123456);
echo "Address at index 123456 of the Donations account is: " . $address;
?>
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.

[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[getBTCPrice]: ../getBTCPrice/
[DevDocs]: ../docs/
