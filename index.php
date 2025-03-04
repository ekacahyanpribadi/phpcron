<?php
date_default_timezone_set("Asia/Jakarta");
require_once 'lib/lib.start.php';

header('Content-Type: application/json');

$created = date("Y-m-d H:i:s");
$resp = array("code"=>200, "status"=>"true", "data"=>"Success insert to log cron. ".$created);
$resp = json_encode($resp);


$myfile = fopen("cron_result.txt", "w") or die("Unable to open file!");
$txt = $resp." \n";
fwrite($myfile, $txt);
fclose($myfile);

responseHasil(200, 'success', "Success insert to log cron. ".$created)
?>