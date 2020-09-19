# Code for BTCToolbox.org.
This portion of this repo is the working copy of the actual setup and code of the btctoolbox.org web site.
## Platform
* VPS Hosted by [EAWF](eawf.com)
  - 1028 RAM
  - 20GB HD
  - 1TB Bandwidth
* CentOS 7 minimal Image
* Apache 2
* Initialization and Setup in accordance with [EAWF/Linux Root Tools](https://github.com/EAWF/Linux-Root-Tools)
* PHP 7.4x
* HTML5
* CSS2
* HD Footprint
  - 2GB
## Back End Systems
### Obtain current BTC Price from Exchange:
* PHP Code: setBTCPrice.php
  - Permissions/Ownership: 644 root:root
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
 } // Additional sources may be added here by creating another elseif condition and extracting the data from the returned JSON.
 $result = json_encode($record);
 $fh = @fopen($filename, "w") or die("Error attempting to open data file: getBTC.json\n");
 fwrite($fh, $result);
 fflush($fh);
 fclose($fh);
?>
```
* Running CRON - Linux Task Scheduler
  - ```txt * * * * * /usr/bin/php /root/cronjobs/setBTCPrice.php ```
    - runs the program every minute, which avoids API rate limits.
### 
## User Interface
### Home Page
### Donations Demo
### Sales Demo
