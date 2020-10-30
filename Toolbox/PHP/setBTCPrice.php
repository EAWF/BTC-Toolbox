<?php
 /**
 * setBTCPrice - Get the current USD rate of Bitcoin and store in /var/www/php/getBTC.json
 *
 * Use CronJob:  * * * * * /usr/bin/php /var/www/php/setBTCPrice.php
 *
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
