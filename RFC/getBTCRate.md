# New getBTCRate Schema - Proposed by @EAWF
# Synopsis:
* Deal with potential getBTCRate() 400 and 404 Errors
* Consider Potential API Rate Limiting
- getBTCRate() currently obtains exchange rates from external servers which can return 400 and 404 errors. These errors are handled within the function by throwing an exception, which results in a program halt and a relatively useless message sent to the end-user's display.<br/>This could negatively impact the users experience with this project.
## Proposal:
### A New Data File (getBTC.json)
- File Format:
```json
{"source":"Bitstamp","price":"9968.59","timestamp":"1599591300","updated":"1599591300"}
```
### A New Program for the Server:
- Completely separate program from getBTC.php designed for use by the *nix/PHP server
- Allows a secondary, tertiary, or quaternary server to be polled to provide a failsafe for price availabilty.
- Program could potentially send an SMS or eMail to the administrator warning of the rate issues.
* Tested and working Linux/PHP Implementation:
  - CentOS 7 Minimal with PHP 7.4.
```php
<?php
 /**
 * setBTCPrice.php - Get the current USD rate of Bitcoin and store in /path/to/server-wide/include_path/getBTC.json
 * Crontab Entry: * * * * * /path/to/php /path/to/setBTCPrice.php
 * JSON Format: {"source":"Bitstamp","price":"9968.59","timestamp":"1599591300","updated":"1599591300"}
 */
 $filename = "/var/www/php/getBTC.json";
 if( !file_exists($filename) )
 {
  $time = time();
  $record = array('source' => "Init", 'price' => "0.00", 'timestamp' => "$time", 'updated' => "$time");
  $result = json_encode($record);
  file_put_contents($filename, $result);
  chmod($filename,0660);
 }
 $current = json_decode(file_get_contents($filename),true);
 if ($response = json_decode(@file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'),true))
 {
  $record['source'] = "Bitstamp";
  $record['price'] = $response['last'];
  $record['timestamp'] = $response['timestamp'];
 }
 elseif ($response = json_decode(@file_get_contents('https://api.bitfinex.com/v1/pubticker/btcusd'),true))
 {
  $record['source'] = "Bitfinex";
  $record['price'] = $response['last_price'];
  $record['timestamp'] = $response['timestamp'];
 }
 elseif ($response = json_decode(@file_get_contents('https://apiv2.bitcoinaverage.com/indices/global/ticker/BTCUSD'),true))
 {
  $record['source'] = "BitcoinAverage";
  $record['price'] = $response['price'];
  $record['timestamp'] = $response['timestamp'];
 }
 if ($record)
 {
  $record['updated'] = $response['timestamp'];
  $result = json_encode($record);
 }
 else
 {
  $time = time();
  $current['updated'] = $time;
  $result = json_encode($current);
 }
 file_put_contents($filename, $result);
 chmod($filename,0660);
?>
```
### getBTC.php Changes:
- Replace ***getBTCRate()*** to obtain the current price from ***getBTC.json***
  - From:
```php
function getBTCRate(): float
{
    $response = file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/');
    if (!$response)
        throw new \Exception("Failed to reach bitstamp api");
    $bitstamp = json_decode($response, true);
    $result = $bitstamp['last'];
    return round($result, 2, PHP_ROUND_HALF_UP);  // Format:  ########.##
}
```
  - To:
```php
function getBTCRate(): float
{
    $response = json_decode(file_get_contents(stream_resolve_include_path("getBTC.json")),true);
    return round($response['price'], 2, PHP_ROUND_HALF_UP);  // Format:  ########.##
}
```
### Benefits:
- No API limitations - Reduction of the calls to the exchange server from the Server IP address avoids rate limit penalties.
- No 400 or 404 error handling required at all for getBTCRate()
### Opportunities: The data can be used by the programmer to:
- Comparing the $timestamp and $updated timestamps indicates that the data is not current and the programmer can implement procedures to create a stop-loss decision based on prices which are "too old".
- Record sales with the current price, exchange, and timestamp for sales and tax reporting
- Implement a bitcoin exchange server preference order by reordering the testing order
- Simply add new bitcoin exchange servers as desired.
## Impact:
### Pre-Implementation:
- Complaints about 400 and 404 errors and page crashes from getBTCRate().
- Requests for data reporting opportunites.
### Post-Implementation:
* NO complaints about errors and page crashes from getBTCRate().
- Requests for additional Exchange Servers to be added to the list
- Requests for Notification via SMS or eMail.
