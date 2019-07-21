# Bitcoin-Payments-Tool
A single tool to accept bitcoin payments online that are directly placed into the users HD wallet without any third-party handling.
## Making Bitcoin Payments:
* Simpler
  - The installation and configuration is easy and simple. All you need is:
    - Your web server
    - PHP7 with a few, easy to install, extra modules
    - Some simple HTML5/CSS/PHP7 programming
    - An HD Wallet such as
      - Mycelium
      - Electrum
      - Trezor
      - or use [Ian Coleman\'s BIP39 Mnemonic Code Generator](https://iancoleman.io/bip39/) to generate an entirely OFFLINE HD wallet.
* Faster
  - No need to sign up with payment gateways who:
    - charge you a fee to process your transaction.
    - cause a delay and loss of use of your funds by having to wait for two on-chain transactions to confirm.
* Cheaper
  - This code is FREE to use
  - Uses FREE [Blockchain.info Ticker](https://blockchain.info/ticker) API obtain the current exchange rate.
* More Secure
  - This code is OPEN SOURCE. ANYONE may use it at no cost. If you wish to modify or customize it, you are welcome to, providing that you meet the terms of the license.
  - The code is written in a linear functional programming manner where each step in the process is documented so as to be easily understood by even a non-programmer. With Bitcoin, everyone needs to verify the code in order to trust it.
