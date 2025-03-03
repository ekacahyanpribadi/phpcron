<?php
date_default_timezone_set("Asia/Jakarta");

$pathlib=dirname(__FILE__);
require ($pathlib.'/db.class.php');

DB::$dsn = 'mysql:host=localhost;dbname=production';
DB::$user = 'c5sWttLvLZ';
DB::$password = 'hF1zJCDbvsVkodiMMzaq';
function responseHasil($code = 200, $vStatus = null, $data = null)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
      200 => '200',
      400 => '400',
      422 => '442',
      500 => '500'
      );
    $statusDesc = array(
      200 => '200 OK',
      400 => '400 Bad Request',
      422 => 'Unprocessable Entity',
      500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    
    $jsonData = array(
        'code' => $code < 300, // success or not?
        'status' => $status[$code],
        'status_desc' => $statusDesc[$code],
        'data' => $data
    );
    echo json_encode($jsonData);

    //$GLOBALS["jsonResponse"] = json_encode($jsonData);
    //$GLOBALS["stsResponse"] = $code;
}

function acakAngka($bdigit)
{
  $var0 = str_split('0123456789'); // and any other characters
  shuffle($var0); // probably optional since array_is randomized; this may be redundant
  $var1 = '';
  foreach (array_rand($var0, $bdigit) as $var3)
    $var1 .= $var0[$var3];
  return $var1;
}
//MAKS 10 DIGIT
//echo acakAngka(10);

function acakHuruf($bdigit)
{
  $var0 = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
  shuffle($var0); // probably optional since array_is randomized; this may be redundant
  $var1 = '';
  foreach (array_rand($var0, $bdigit) as $var3)
    $var1 .= $var0[$var3];
  return $var1;
}

function getPk()
{
  $var1 = date('YmdHis');
  $var2 = acakHuruf(6);
  $var = $var1 . $var2;

  return $var;
}

function diffMenit($start_date, $end_date)
{
  // Convert the dates into Unix timestamps
  $start_timestamp = strtotime($start_date);
  $end_timestamp = strtotime($end_date);

  // Calculate the difference in seconds
  $difference_in_seconds = abs($end_timestamp - $start_timestamp);

  // Convert the difference from seconds to minutes
  $difference_in_minutes = $difference_in_seconds / 60;

  return $difference_in_minutes;
}
?>