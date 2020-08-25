# Documentation 
## Usage
* getBTCRate:  - (Dual purpose function)
  - Requirement:
    - None
  - ```getBTCRate([amount])```  returns exchange rate data from the Bitstamp Exchange
    - $amount <= 0 OR null 
      - returns (string) USD/BTC - $###.###.###.## ) 
    - $amount > 0 as (############.##)
      - returns BTC for Amount(USD) (########.########)(*max 21,000,000.00*) 

* getBTCAddress - returns Base58Check Bitcoin Address for m/'XX/0'/Account'/0/Index for xpub, ypub, or zpub
  - Requirement:
    - getBTC.conf
  - ```getBTCAddress( AccountName, index )```
    - return format: (string) Base58Check Bitcoin Address for m/'XX/0'/Account'/0/Index for xpub, ypub, or zpub

* getBTCBalance - returns funds available that equal or exceed the number of confirmations
  - Requirement:
    - None
  - Total funds reflects all funds found on the bitcoin network (mempool and onchain) for that address
  - ```getBTCBalance( address, [confirmations])```
    -  return format: (string) ################.########

* getBTCInvoice - returns BIP-21 compliant Payment URI.
  - Requires
    - getBTCAddress()
      - getBTC.conf
    - getBTCRate()
    - ```getBTCInvoice( account , index [,amount] [,label] [,message] )```
      - return format: (string) ```bitcoin:[address][?][amount=btc][&][label=label][&][message=message]```
        - spaces in variables are replaced with "%20"

## Installation
* WIP
