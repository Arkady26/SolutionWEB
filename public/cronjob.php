<?php
$testfile = fopen($_SERVER['DOCUMENT_ROOT'].'/test.txt', 'a+');
include($_SERVER['DOCUMENT_ROOT'].'/setting.php');
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_NAME = "mmb";
$DB_PASSWORD = "";
$mysqli = new mysqli($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
if ($mysqli -> connect_errno) {
  $error = "Failed to connect to MySQL: " . $mysqli -> connect_error;
  fwrite($testfile, $error);
  fclose($testfile);
  exit();
}

$cURLConnection = curl_init(CNF_API_CURRENCY);
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
$apiResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);
$jsonArrayResponse = json_decode($apiResponse);
$rates = (array)($jsonArrayResponse->rates);
$base = $jsonArrayResponse->base;
$rates[$base] = 1.00;
$query = "";
foreach ($rates as $key => $value) {
  $query .= "UPDATE def_currency SET realtime_rate = ".$value." WHERE currency_sym='".$key."';";
}
if ($result = $mysqli -> multi_query($query)) {
  $error = "success;";
}
else{
  $error = "Failed to connect to MySQL: " . $mysqli -> connect_error;
  fwrite($testfile, $error);
  fclose($testfile);
  exit();
}
fwrite($testfile, $error);
fclose($testfile);
exit();
?>
