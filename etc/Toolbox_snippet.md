# The Tools
These are the tools to help you to easily build your own Bitcoin paywall.
* **[getBTCRate](getBTCAddress.md)** - returns the current USD exchange rate for bitcoin
  - Two Modes:
    - Return Current USD Exchange Rate
      - *param*  - Dollar Amount <= 0 (#)
      - *return* - USD(string) ($)(#,###.##)
    - Convert USD Amount to BTC Amount
      - *param*  - Dollar Amount > 0 (####.##)
      - *return* - BTC(string) (####.########)
* **[getBTCAddress](getBTCAddress.md)** - Payment Address Derivation from an HD Wallet's exported, account-level, extended public key.
  - *param*  - Extended Public Key(string)
  - *param*  - Index(int)
  - *return* - Bitcoin Address(string)
* **[getBTCInvoice](getBTCInvoice.md)** - returns [BIP-21](https://github.com/bitcoin/bips/blob/master/bip-0021.mediawiki) strings that encode payment information such as amounts, labels, and messages that would be included in the payers wallet
  - *requirement* - Include David Shim's [QR Code](https://github.com/davidshimjs/qrcodejs) javascript library to build QR Codes on browser.
  - *param*  - Account(string) - Derivation Account to use
  - *param*  - Index(int)      - Derivation Index to use
  - *param*  - Amount(float)   - Invoice Total in $US
  - *param*  - Label(string)   - Company Name, Division, Invoice# for future reference
  - *param*  - Message(string) - Informative text(not used on some wallets)(ex. *Thanks for your patronage* or *Thank you for your purchase*)
  - *return* - String(string) - BIP-21 formatted Invoice string to send to browser
    - *format:* "bitcoin:" . $address . "?label=" . $Label . "&message=" . $Message"
    - *QRCode Wrapper:* WIP  ?? <img> tag or directly feed empty div with javascript inner.HTML ??
* **[getBTCBalance](getBTCBalance.md)** - Checks the blockchain for the current balance of the payment address and number of confirmations.
  - *param*  - Bitcoin Address(string)
  - *return* - Received(float) in BTC(####.########) - Amount of bitcoin received by the address
  - *return* - Confirmations(int) - # of confirmations on the blockchain
  