# WORK IN PROGRESS - @EAWF
# Problem: getBTCRate() 400 and 404 Errors and Potential API Rate Limiting
getBTCRate() currently obtains exchange rates from external servers which can return 400 and 404 errors. These errors are handled within the function by throwing an exception, which results in a program halt and a relatively useless message sent to the end-user's display.<br/>This could negatively impact the users experience with this project.
## Proposal:
### A New Data File (getBTCPrice.json)
- Record Format:
```json
{
 "Bitstamp": {
  "URL":"https://www.bitstamp.net/api/v2/ticker/btcusd/",
  "lastupdate":"1598644799",
  "status": true,
  "timestamp": "1598644799",
  "data": {"high": "11555.61", "last": "11510.00", "timestamp": "1598644799", "bid": "11505.00", "vwap": "11430.48", "volume": "6512.55174336", "low": "11228.50", "ask": "11513.09", "open": "11332.26"}
 }
}
```
### A New Program for the Server:
To be run by a task scheduler.
```txt
Price Updater for getBTCPrice.json
 Load current getBTCPrice.json data
 Start loop through Servers:
  Set "lastupdate" to now()
  Set "status" to true
  Get JSON from URL and convert to array
   if 400 0r 404 error:
    Set "status" to false
    Loop to next Server
   fi
  Set "data" with new JSON data string
  if no more servers:
   exit with status 0
  fi
  Loop to next Server
```
- Allows a secondary, tertiary, or quaternary server to be polled to provide a failsafe for price availabilty.
- Program could potentially sends an SMS or eMail to the administrator warning of the rate issues.
### Program Changes:
- Modify ***getBTCRate()*** to obtain the current price from ***getBTC.json*** which benefits and opportunities:
### Benefits:
- No 400 or 404 error handling required for getBTCRate()
- Reduction of the calls to the exchange server from the IP address, thus avoiding rate limit penalties.
### Opportunities: The data can be used by the programmer to:
- Make stop-loss decisions based on prices which are "too old".
- Record sales with the current price, exchange, and timestamp for sales and tax reporting
- Configure an exchange server preference order.
## Impact:
### Pre-Implementation:
- Complaints about errors and page crashes from getBTCRate().
- Requests for reporting data opportunites.
### Post-Implementation:
* NO complaints about errors and page crashes from getBTCRate().
- Requests for additional Exchange Servers to be added to the list
- Requests for Notification via SMS or eMail.
### Dependencies:
- getBTC.json
- getBTCRate()
## Resources Required:
- Create the new program to acquire the data and maintain getBTC.json.
- Create a script for a system scheduler to use to run the tool.
- Research additional exchange server API's and write the code to process the exchange rates.
- Write documentation
