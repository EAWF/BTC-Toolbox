## Table of Contents
- **Bitcoin Merchants Toolbox**
  - [getBTCAddress][getBTCAddress]
  - [getBTCBalance][getBTCBalance]
  - [getBTCInvoice][getBTCInvoice]
  - [getBTCRate][getBTCRate]

# Bitcoin Merchants Toolbox
The Bitcoin Merchants Toolbox is a collection of functions for various programming languages that helps merchants interact with Bitcoin in useful ways, such as:
- Generating Bitcoin addresses for receiving payments
- Converting and checking the price of Bitcoin in Dollars
- Creating requests for Bitcoin payments
- Monitoring the balance and progress of received payments

The Toolbox functions are contained in a single file for ease of use, portability, and minimal clutter.

## Functions
- [getBTCAddress][getBTCAddress]
  - Returns addresses owned by the merchant (supports multiple accounts)
- [getBTCBalance][getBTCBalance]
  - Returns the balance of a merchant's address (supports minimum confirmations)
- [getBTCInvoice][getBTCInvoice]
  - Returns a QR Code payment request for customers
- [getBTCRate][getBTCRate]
  - Returns the exchange rate of Bitcoin and converts Dollar amounts to Bitcoin amounts

## Installation
### Configuration File
All versions of the Toolbox require a configuration file. The configuration file is used to store account names and associated extended public keys.

The configuration file must be named `getBTC.conf`. For an example configuration file, see [getBTC.conf][getBTC.conf].

### Java Instructions
- Download the [getBTC.java][getBTC.java] file
- Detailed installation instructions for Java servers will go here (Currently a WIP)

### Javascript Instructions
- Download the [getBTC.js][getBTC.js] file
- Detailed installation instructions for Javascript servers will go here (Currently a WIP)

### PHP Instructions
- Download the [getBTC.php][getBTC.php] file
- Detailed installation instructions for PHP servers will go here (Currently a WIP)

### Python Instructions
- Download the [getBTC.py][getBTC.py] file
- Detailed installation instructions for Python servers will go here (Currently a WIP)

### Ruby Instructions
- Download the [getBTC.rb][getBTC.rb] file
- Detailed installation instructions for Ruby servers will go here (Currently a WIP)


[getBTC.conf]: ./getBTC.conf
[getBTC.java]: ./getBTC.java
[getBTC.js]: ./getBTC.js
[getBTC.php]: ./getBTC.php
[getBTC.py]: ./getBTC.py
[getBTC.rb]: ./getBTC.rb
[getBTCAddress]: ./getBTCAddress/
[getBTCBalance]: ./getBTCBalance/
[getBTCInvoice]: ./getBTCInvoice/
[getBTCRate]: ./getBTCRate/
