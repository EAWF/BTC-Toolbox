## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - **getBTCInvoice**
  - [getBTCRate]
- [Developer Documentation][DevDocs]

# getBTCInvoice
Function that returns a URI containing a payment request to be packed into a QR code and scanned by the customer.

Follows the [BIP-21] Payment Protocol which is supported by most popular Bitcoin wallets.

### Inputs
- Account Name (Optional)
  - Type: string
  - Restrictions:
    - Must be defined in the [getBTC.conf] file
  - Description: Name of the account in [getBTC.conf] that refers to an extended public key. Defaults to the account name "Default" if not present
- Child Index (Optional)
  - Type: integer
  - Restrictions:
    - Must be in the range `0 <= x < 2^31`
  - Description: Index of the Address to derive from the Account Name's extended public key. Defaults to 0 if not present
- Invoice Amount (Optional)
  - Type: float
  - Units: Bitcoin
  - Restrictions:
    - Must be greater than or equal to `0.00000546`
  - Description: Amount (in Bitcoin) that the customer must send
- Address Label (Optional)
  - Type: string
  - Description: Label that the customer will see in addition to the Address
- Message (Optional)
  - Type: string
  - Description: Message that the customer will see as a reason for payment

### Outputs
- BIP-21 Payment Request URI
  - Type: string
  - Description: Payment request information, url encoded. Format: `bitcoin:[address][?][amount=btc][&][label=label][&][message=message]`

## Usage
In the usage examples below, it is assumed you have a [getBTC.conf] file in the same directory. The getBTC.conf file for these examples
is as follows:
```txt
Default:xpub6BosfCnifzxcFwrSzQiqu2DBVTshkCXacvNsWGYJVVhhawA7d4R5WSWGFNbi8Aw6ZRc1brxMyWMzG3DSSSSoekkudhUd9yLb6qx39T9nMdj
Donations:zpub6rVZC52z8ugGany9wytHSPQ3DnfvKNPM4Em2tTLPeE2TGd9i5hmjC2kwXNt8oMHAdXruRQAkuqWYmKraSaip3xfPjTq4zKCAJiYGKpmcZ9B
```

### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
```php
# Generates a Payment Request URI with the 0th child indexed Address of the "Default" account as the payment address
$invoice_uri = getBTCInvoice();
echo "Invoice URI for 0th Address of the \"Default\" Account: " . $invoice_uri . "\n";

# Generates a Payment Request URI with the 0th child indexed Address of the "Donations" account as the payment address
$invoice_uri = getBTCInvoice("Donations");
echo "Invoice URI for the 0th Address of the \"Donations\" Account: " . $invoice_uri . "\n";

# Generates a Payment Request URI with the 25th child indexed Address of the "Donations" account as the payment address
$invoice_uri = getBTCInvoice("Donations", 25);
echo "Invoice URI for the 25th Address of the \"Donations\" Account: " . $invoice_uri . "\n";

# Generates a Payment Request URI with the 25th child indexed Address of the "Donations" account as the payment address,
# with a specified amount to send of 0.005 BTC
$invoice_uri = getBTCInvoice("Donations", 25, 0.005);
echo "Invoice URI for the 25th Address of the \"Donations\" Account (0.005 BTC Amount): " . $invoice_url . "\n";

# Generates a Payment Request URI with the 25th child indexed Address of the "Donations" account as the payment address,
# with a specified amount to send of 0.005 BTC, and an address label of "EAWF"
$invoice_uri = getBTCInvoice("Donations", 25, 0.005, "EAWF");
echo "Invoice URI for the 25th Address (labeled as \"EAWF\") of the \"Donations\" Account (0.005 BTC Amount): " . $invoice_url . "\n";

# Generates a Payment Request URI with the 25th child indexed Address of the "Donations" account as the payment address,
# with a specified amount to send of 0.005 BTC, an address label of "EAWF", and a message of "Donation to EAWF"
$invoice_uri = getBTCInvoice("Donations", 25, 0.005, "EAWF", "Donation to EAWF");
echo "Invoice URI for the 25th Address (labeled as \"EAWF\") of the \"Donations\" Account (0.005 BTC Amount) with a message of \"Donation to EAWF\": " . $invoice_uri . "\n";
```

### Python
Currently a WIP.

### Ruby
Currently a WIP.


[BIP-21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[DevDocs]: ../docs/
