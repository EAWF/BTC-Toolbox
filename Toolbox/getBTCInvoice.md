# getBTCInvoice - Build Payment Request and QRCode
Encapsulates bitcoin relevant payment information in preparation for QRCode to be delivered to the customer.
## Requirements
* [QRCode.js](https://github.com/davidshimjs/qrcodejs) [qrcode.min.js](https://raw.githubusercontent.com/davidshimjs/qrcodejs/master/qrcode.min.js) to build QR Code on customers browser.
## Premises:
* Server is best for handling building a payment address without revealing the account-level extended public key
* Browsers are best for handling the display work, so build the qrcode on the users browser.
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
   $account = "";  // Account Name from getBTC.conf to use.
   $index = 0;
   $label = "";
   $message = "";
   $amount = 0;
   
   function getBTCInvoice( $account = "default" , $index = 0 , $amount = 0 , $label = "Test Company", $message = "Thanks for your patronage" )
   {
    $Address = getBTCAddress( $account , $index );
    $BTC = getBTCRate( $amount );
    $string = "bitcoin:" . $address . "?amount=" . $amount . "&label=" . $label . "&message=" . $message;    
    $BIP21 = str_replace( $string, " ", "%20");
    var_dump($BIP21);
    
   }
   <body>
    <div id="qrcode"></div>
   </body>
<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
	text: "http://jindo.dev.naver.com/collie",
	width: 128,
	height: 128,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
</script>
   WIP
   ?>
```
getBTCInvoice - returns BIP-21 strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
requirement - Include David Shim's QR Code javascript library to build QR Codes on browser.
param - Account(string) - Derivation Account to use from getBTC.conf
param - Index(int) - Derivation Index to use
param - Amount(float) - Invoice Total in $US
param - Label(string) - Company Name, Division, Invoice# for future reference
param - Message(string) - Informative text(not used on some wallets)(ex. Thanks for your patronage or Thank you for your purchase)
return - String(string) - BIP-21 formatted Invoice string to send to browser
format: "bitcoin:" . $address . "?label=" . $Label . "&message=" . $Message"
QRCode Wrapper: WIP ??  tag or directly feed empty div with javascript inner.HTML ??
