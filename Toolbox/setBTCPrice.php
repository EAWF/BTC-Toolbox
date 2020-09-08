<?php
 /**
 * setBTCPrice.php - Get the current USD rate of Bitcoin and store in /path/to/server-wide/include_path/getBTC.json
 *
 * Crontab Entry: * * * * * /path/to/php /path/to/setBTCPrice.php
 *
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
