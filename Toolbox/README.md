# Tools Index
This folder contains the individual tools that comprise the Bitcoin Merchants Toolbox.
## Exported Account-Level Extended Public Key Extractor
* This [Extractor]() tool takes a bitcoin HD wallet's exported account-level extended public key and extracts a public key to be used by the other tools in this toolbox to derive child payment addresses used to route online payments directly to the wallet's account.
* [The Derivers]()
  - INPUTS:
    - Parent Public Key
    - Users Desired Index
    - Parent Chain Code.
  - OUTPUT:
    - Encoded Bitcoin Payment Address/Script
* [The BIP44 Deriver]()
* [The BIP49 Deriver]()
* [The BIP84 Deriver]()
