## Table of Contents
- [Bitcoin Merchants Toolbox][Toolbox]
  - [getBTCAddress]
  - [getBTCBalance]
  - **getBTCInvoice**
  - [getBTCRate]
  - [getBTCPrice]
- [Developer Documentation][DevDocs]

# getBTCInvoice
Function that returns a URI containing a payment request to be packed into a QR code and scanned by the customer.

Follows the [BIP-21] Payment Protocol which is supported by most popular Bitcoin wallets.

### Inputs
- Bitcoin Address (Required)
  - Type: string
  - Restrictions:
    - Must be a valid Bitcoin Address
  - Description: Payment address where customer will send Bitcoin. Can be the output of [getBTCAddress]
- Amount (Optional)
  - Type: float
  - Units: Bitcoin
  - Restrictions:
    - Must be greater than or equal to `0.00000546` (minimum dust amount) 
  - Description: Amount (in Bitcoin) that the customer must send. Can be the output of [getBTCRate] when converting a USD amount to BTC
- Label (Optional)
  - Type: string
  - Description: Label that the customer will see in addition to the Address. Supported by most wallets 
- Message (Optional)
  - Type: string
  - Description: Message that the customer will see as a reason for payment. Not supported by most wallets

### Outputs
- BIP-21 Payment Request URI
  - Type: string
  - Description: Payment request information, url encoded. Format: `bitcoin:[address][?][amount=btc][&][label=label][&][message=message]`
  - Directly usable by a QR Code Builder or as a Anchor URI

## Usage
In the usage examples below, it is assumed you have a [getBTC.conf] file. The getBTC.conf file for these examples is as follows:
```txt
Default:xpub6BosfCnifzxcFwrSzQiqu2DBVTshkCXacvNsWGYJVVhhawA7d4R5WSWGFNbi8Aw6ZRc1brxMyWMzG3DSSSSoekkudhUd9yLb6qx39T9nMdj
Donations:zpub6rVZC52z8ugGany9wytHSPQ3DnfvKNPM4Em2tTLPeE2TGd9i5hmjC2kwXNt8oMHAdXruRQAkuqWYmKraSaip3xfPjTq4zKCAJiYGKpmcZ9B
```

```php
/*
 * Requires qrcode.min.js - [https://raw.githubusercontent.com/davidshimjs/qrcodejs/master/qrcode.min.js]
 * for generating a QR Code from the Payment Request URI
 */
require_once 'getBTC.php';

$account = "Donations";
$index = 0;
$address = getBTCAddress($account,$index);
$usd_amount = 10.99;
$btc_amount = getBTCPrice($usd_amount);
$label="My Company Inc. - Donation";
$message="Thanks for your patronage!";
$invoice = getBTCInvoice($address, $btc_amount, $label, $message);

$QRSize = "140";
$QRQuality = "M";
print <<<END
<html>
 <head>
  <title>BTC Invoice Test Page</title>
  <script src="qrcode.min.js" ></script>
  <meta http-equiv="refresh" content="60">
 </head>
 <body>
 <h2>BTC Invoice Demo</h2>
  <p>Please pay BTC: $btc_amount for your purchase.</p>
  <p><div id="qrcode"></div></p>
  <p><small><a href="$invoice" title="Pay on this device.">$address</a><br/><br/>Click on the link above to pay from this device.</small></p>
 </body>
  <script type="text/javascript">
   new QRCode(document.getElementById("qrcode"), {text: "$invoice", width: $QRSize, height: $QRSize, correctLevel: QRCode.CorrectLevel.$QRQuality} );
  </script>
<html>\n
END;
?>

```
With the above script, you can play with the Amount, Label and Message fields to observe the results


[BIP-21]: https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki
[getBTC.conf]: ../getBTC.conf
[Toolbox]: ../
[getBTCAddress]: ../getBTCAddress/
[getBTCBalance]: ../getBTCBalance/
[getBTCInvoice]: ../getBTCInvoice/
[getBTCRate]: ../getBTCRate/
[getBTCPrice]: ../getBTCPrice/
[DevDocs]: ../docs/
