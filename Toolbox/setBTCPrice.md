# setBTCPrice
Tool for retrieving BTC price from multiple exchanges and storing locally for use by getBTCPrice.
* Stores data in /var/www/php/getBTC.json which resides on the php include_path.
* Provides fail-safe redundancy attributes by searching other resources in the instance of 400, 403, or 404 errors at the source.
  - Timestamp may be used to verify that data is "fresh" and if not, allow for automatic shutdown if desired.
* JSON and ASCII file storage is used to simplify and clarify conversion between arrays and text storage.
* Code:
```php
<?php
 /**
 * setBTCPrice - Get the current USD rate of Bitcoin and store in /var/www/php/getBTC.json
 *
 * @param null
 * CronJob: * * * * * /usr/bin/php /root/cronjobs/setBTCPrice.php
 */
 $record = array();
 $filename = "/var/www/php/getBTC.json";
 if( !is_file($filename) ){
  touch($filename);
  chmod($filename, 0660);
 }
 if ($response = json_decode(@file_get_contents('https://www.bitstamp.net/api/v2/ticker/btcusd/'), true)){
  $record['source'] = "Bitstamp";
  $record['price'] = $response['last'];
  $record['timestamp'] = $response['timestamp'];
 } elseif ($response = json_decode(@file_get_contents('https://api.bitfinex.com/v1/pubticker/btcusd'), true)){
  $record['source'] = "Bitfinex";
  $record['price'] = $response['last_price'];
  $record['timestamp'] = $response['timestamp'];
 } elseif ($response = json_decode(@file_get_contents('https://apiv2.bitcoinaverage.com/indices/global/ticker/BTCUSD'), true)){
  $record['source'] = "BitcoinAverage";
  $record['price'] = $response['price'];
  $record['timestamp'] = $response['timestamp'];
 }
 $result = json_encode($record);
 $fh = @fopen($filename, "w") or die("Error attempting to open data file: getBTC.json\n");
 fwrite($fh, $result);
 fflush($fh);
 fclose($fh);
?>
```
