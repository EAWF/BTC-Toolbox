# getPaymentRequest - Build Payment Request and QRCode
Encapsulates bitcoin relevant payment information in preparation for QRCode to be delivered to the customer.
## Requirements
* [QR Code](https://github.com/davidshimjs/qrcodejs) javascript module to build QR Code on customers browser.
## Premises:
* Server is best for handling building a payment address without revealing the public key
* Browsers are best for handling the display work.
## PHP7.x
* Build the Payment Request URI
```php
   <?php
   
   ?>
```
