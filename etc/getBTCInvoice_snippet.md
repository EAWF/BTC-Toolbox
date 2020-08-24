# getBTCInvoice - Build Payment Request and QRCode
Encapsulates bitcoin relevant payment information in preparation for QRCode to be delivered to the customer.
## Requirements
* [QRCode.js](https://github.com/davidshimjs/qrcodejs) [qrcode.min.js](https://raw.githubusercontent.com/davidshimjs/qrcodejs/master/qrcode.min.js) to build QR Code on customers browser.
## Premises:
* Server is best for handling building a payment address without revealing the public key
* Browsers are best for handling the display work.
## Preparation:
* Store qrcode.min.js in docroot.
* Then, in the head section of the HTML insert the script tag:
```html
<head>
 <script src="/qrcode.min.js" ></script>
</head>
```
* Build the Payment Request URI
```php
   <?php
   WIP
   ?>
```
