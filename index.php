<?php
date_default_timezone_set("Asia/Jakarta");

$text = "";
/*
if(!empty($argv[1])) 
   $text .= $argv[1];
if(!empty($argv[2])) 
   $text .= $argv[2];
if(!empty($argv[3])) 
   $text .= $argv[3];

if(empty($text)){
return;
}
*/

file_put_contents('./cron_result.txt', "Log: " . date('Y-m-d H:i:s') ."\t\t\t" . $text . "\n",FILE_APPEND);

