# WORK IN PROGRESS - @EAWF
# Problem: getBTCRate() 400 and 404 Errors
getBTCRate() currently obtains exchange rates from external servers which can return 400 and 404 errors. These errors are handled within the function by throwing an exception, which results in a program halt and a relatively useless message sent to the end-user's display.<br/>This could negatively impact the users experience with this project.
## Proposal:
### A New Data File (getBTCPrice.json)
Would provide an alternative for external server calls and error handling within ***getBTCRate()***
- Record Format:
```json

```


by adding a new data file with the purpose of storing exchange price data for use by ***getBTCRate()***.
- Automates the price update procedure by maintaining new a record line type in ***getBTC.conf***:<br/><br/>to store the latest price, exchange source, and timestamp.
- Is run by a scheduled job on the server that:
  - polls the exchange servers for the current pricewould run the program on the server at the users desired schedule and create or update the record in ***getBTC.conf***.
  - On errors, then a secondary, tertiary, or quaternary server could be polled to provide a failsafe for price availabilty.
  - Program could potentially sends an SMS or eMail to the administrator warning of the rate issues.
### Program Changes:
- Modify getBTCAddress() to additionally ignore the first character. "$". 
- Modify ***getBTCRate()*** to obtain the current price from ***getBTC.conf*** which benefits and opportunities:
### Benefits:
- No 400 or 404 error handling required for getBTCRate()
- Reduction of the calls to the exchange server from the IP address, thus avoiding rate limit penalties.
### Opportunities: The data can be used by the programmer to:
- Make stop-loss decisions based on prices which are "too old".
- Record sales with the current price, exchange, and timestamp for sales and tax reporting
- Configure an exchange server preference order by using multiple "$" records in ***getBTC.conf*** similar to how we're already using multiple Pubs.
## Impact:
### Pre-Implementation:
- Complaints about errors and page crashes from getBTCRate().
- Requests for reporting data opportunites.
### Post-Implementation:
* NO complaints about errors and page crashes from getBTCRate().
- Requests for additional Exchange Servers to be added to the list
- Requests for Notification via SMS or eMail.
### Dependencies:
- getBTC.conf
- getBTCRate()
- getBTCAddress()
## Resources Required:
- Create the new program to acquire the data and maintain getBTC.conf.
- Create a script for a system scheduler to use to run the tool.
- Research additional exchange server API's and write the code to process the exchange rates.
- Write documentation
