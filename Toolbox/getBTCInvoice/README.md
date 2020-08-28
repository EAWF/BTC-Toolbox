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
- Address (Required)
  - Type: string
  - Description: Payment address in Base58Check format
  - Source: [getBTCAddress]
- Amount (Optional)
  - Type: string
  - Units: Bitcoin
  - Restrictions:
    - 26 August 2020 - Amount MUST be greater than or equal to `0.00000546` so as to prevent spamming transactions. 
  - Description: Amount (in Bitcoin) that the customer must send
  - Source: [getBTCRate]
- Label (Optional)
  - Type: string
  - Description: Label that the customer will see in addition to the Address
  - Note: Most wallets support this field.
- Message (Optional)
  - Type: string
  - Description: Message that the customer will see as a reason for payment
  - Note: Many wallets do not support this field.

### Outputs
- BIP-21 Payment Request URI
  - Type: string
  - Description: Payment request information, url encoded. Format: `bitcoin:[address][?][amount=btc][&][label=label][&][message=message]`
  - Directly usable by a QR Code Builder or as a Anchor URI

## Usage
### Java
Currently a WIP.

### Javascript
Currently a WIP.

### PHP
```php
 /*
 * Demo PHP Script for BIP-21 URI
 * Requires:
 *  getBTC.php - 
 *  qrcode.min.js - [https://raw.githubusercontent.com/davidshimjs/qrcodejs/master/qrcode.min.js]
 */
 require_once 'getBTC.php';
 $account = "Default";
 $index = 0;
 $address = getBTCAddress($account,$index);
 $amount="";
 $amount="10.00";
 $label="";
 $label="My Company Inc. - Donation";
 $message="";
 $message="Thanks for your patronage!";
 $QRSize = "140";
 $QRQuality = "M";
 $amount = getBTCRate($amount);
 $invoice = getBTCInvoice($address,$amount,$label,$message);
print <<<END
<html>
 <head>
  <title>BTC Invoice Test Page</title>
  <script src="qrcode.min.js" ></script>
  <meta http-equiv="refresh" content="60">
 </head>
 <body>
 <h2>BTC Invoice Demo</h2>
  <p>Please pay BTC: $amount for your purchase.</p>
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
