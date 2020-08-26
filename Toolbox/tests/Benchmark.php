<?php
 // Benchmark test for getBTC.php
 namespace BTC;

 require_once 'getBTC.php';

 echo exec('clear');
 
 $account = "Default";
 $index = 0;
 $amount = 10.00;
 $btc = 1.00000000;
 $Company = "Bitcoin Merchant's Toolbox Donation";
 $label = $Company;
 $message = "Thanks for the donation!";

 echo "\n";
 echo "TESTING getBTCRate:\n===================\n";
 echo "Current Exchange Rate:\n";
 $starttime = microtime(true);
 $result = getBTCRate();
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo "$".number_format($result,2,'.',',')." USD";
 echo "\n($timediff secs)";
 echo "\n\n";
 
 echo "TESTING getBTCRate:\n===================\n";
 echo "Amount to Convert $".number_format($amount,2,'.',',')." USD:\n";
 $starttime = microtime(true);
 $result = getBTCRate($amount);
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo number_format($result,8,'.',',')." BTC";
 echo "\n($timediff secs)";
 echo "\n\n";
 
 echo "TESTING getBTCAddress:\n===================\n";
 $starttime = microtime(true);
 $address = getBTCAddress($account,$index);
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo "Address: ".$address;
 echo "\n($timediff secs)";
 echo "\n\n";

 echo "TESTING getBTCBalance(0 conf's):\n===================\n";
 echo "Address Balance: $address\n";
 $starttime = microtime(true);
 $result = getBTCBalance($address,0);
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo number_format($result,8,'.',',')." BTC";
 echo "\n($timediff secs)";
 echo "\n\n";

 echo "TESTING getBTCBalance(6 conf's):\n===================\n";
 echo "Address Balance: $address (6 confirmations):\n";
 $starttime = microtime(true);
 $result = getBTCBalance($address,6);
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo number_format($result,8,'.',',')." BTC";
 echo "\n($timediff secs)";
 echo "\n\n";

 echo "TESTING getBTCInvoice:\n===================\n";
 echo "BIP-21 String:\n";
 $starttime = microtime(true);
 $result = getBTCInvoice($account,$index,$amount,$label,$message);
 $endtime = microtime(true);
 $timediff = $endtime - $starttime;
 echo $result;
 echo "\n($timediff secs)";
 echo "\n\n";

?>
