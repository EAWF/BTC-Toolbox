# HD Wallet Account-Level Extended Public Key to Address Tool
A simple PHP function that derives payment addresses from an exported BIP49 extended public key.
## Why?
### Faster AND Cheaper
* Do ALL the payment address derivation processing on YOUR server and not in the hands of a rent-seeking third-party who doesn't really need your personal business.
* Using a function is like using a screwdriver without having to include a toolbox of other tools you won't ever use.
* No need to sign up with payment gateways who:
  - require you to store your precious bitcoin keys on their servers.
  - charge you a fee to deliver your customer a payment address.
  - cause unnecessary delays and loss of use of your funds by having to wait for two on-chain transactions to confirm.
  - ANYONE may use it at no cost. If you wish to modify or customize it, you are welcome to, providing that you meet the terms of the license.
* OPEN SOURCE, as in FREE to use and modify.

### Verifiable and Trustable
    - With Bitcoin, EVERYONE needs to be able to verify the code in order to trust it.
    - The code is written in a linear functional programming manner where each step in the process is documented so as to be easily understood by even a non-programmer.
    - No tricky online API calls.

## Requirements
* An exported account-level extended public key from an HD Wallet such as:
  - Mycelium
  - Electrum
  - Trezor
  - Ledger
  - or you can use [Ian Coleman\'s BIP39 Mnemonic Code Generator](https://iancoleman.io/bip39/) to generate an entirely OFFLINE HD wallet.
* Linux Server
* PHP7 or newer
* The PHP [Base58 extension](https://centos.pkgs.org/7/remi-x86_64/base58-0.1.4-1.el7.remi.x86_64.rpm.html)
  - Basic HTML/PHP programming.
* Method to store use address(invoice) indexes

## Installation:
* Install the Base58 PHP extension(see above)
* Upload the function into a directory which below the Document Root directory, and on the PHP Include Path.
* Configure the 
