# Account Tracking System Proposal
A possible means of tracking invoices to be used in place of getBTCBalance
## One file for each account described in getBTC.conf
* File Name: Account.txt
  - Created by: getAddress()
  - Appended by: getAddress()
  - Updated by: getBalance()
  - Deleted: NEVER
## File Structure:

| Field Name | Type(len) | Purpose |
| --- | :- | :- |
| Index | Integer(8) | Index used to derive the address from the extended public key |
| InvoiceNum | Integer(8) | Invoice number used by the Invoicing system to link to the InvoiceHdr file |
| BTCAmount | Float | BTC Amount requested in Invoice |
| BTCRate | float | Current BTC Rate at time of Presented |
| Presented | Timestamp | Timestamp when getInvoice is presented to the customer |
| Expires | Timestamp | Presented + 10 minutes |
| Funded | Timestamp | Timestamp when the Payment Address is funded |

## getBTCIndex()
```php
<?php
 // Account.txt is on path (/var/www/php/Account.txt)
 $fp = fopen("Account.txt", "r+", TRUE);
 flock($fp, LOCK_EX);
 
  
?>
```

* Customer wants to pay with bitcoin
  - getAddress
    - Obtain current Timestamp, InvoiceNum
    - Calculate Timestamp -10 minutes
    - Open and Lock Account.txt
      - If file doesn't exist:
        - create Account.txt and opens with lock for write
        - calculate timestamp + 10 minutes
        - Sets index to 0, Funded to NULL
        - write record
        - unlock file
      - Else
        - Open file with lock for read/write
        - Read file into array
        - Make pass through array
          - If Funded, then next record
          - If Expires < 
        
