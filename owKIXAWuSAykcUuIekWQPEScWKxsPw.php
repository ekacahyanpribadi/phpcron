<?php
date_default_timezone_set("Asia/Jakarta");
require_once 'lib/lib.start.php';

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$getip=get_client_ip();
$desc=$getip;
$desc1="";
$desc2="";
$desc3="";
$desc4="";
$desc5="";

$id = getPK();
$created = date("Y-m-d H:i:s");

$cekBefore="
select count(*) n from production.`log_cron`;
";
$rscekBefore = DB::queryFirstRow($cekBefore);

$sql = "
insert into `production`.`log_cron` values
  (
    '$id',
    '$created',
    '$desc',
    '$desc1',
    '$desc2',
    '$desc3',
    '$desc4',
    '$desc5'    
  );
";

$rs = DB::query($sql);
if (!$rs) {
    responseHasil(400, 'error', "Error insert to log cron.");
}

$opsi = "email";
$email = "ekacahyana77@gmail.com";
$subject = "Cronjob Error Report";
$body = '
<div style="font-family: Helvetica,Arial,sans-serif;min-width:800px;overflow:auto;line-height:2">
  <div style="margin:50px auto;width:70%;padding:20px 0">
    <div style="border-bottom:1px solid #eee">
      <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">EKACP.DEV</a>
    </div>
    <p style="font-size:1.1em">Hi,</p>

    <p>Cronjob EKACP.DEV. has error. Please Check!</p>

    <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">ERROR</h2>

    <p style="font-size:0.9em;">Regards,<br />EKACP.DEV</p>

    <hr style="border:none;border-top:1px solid #eee" />
    <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
      <p>EKACP.DEV</p>
      <p>081310006566</p>
      <p>Depok, Jawa Barat</p>
    </div>
  </div>
</div>
';

$cekAfter="
select count(*) n from production.`log_cron`;
";
$rscekAfter = DB::queryFirstRow($cekAfter);

$cBefore = $rscekBefore['n'];
$cAfter = $rscekAfter['n'];

if($cBefore < $cAfter){
    responseHasil(200, 'success', "Success insert to log cron.");
}else{
    kirimEmail($opsi, $email,$subject, $body);
}



function kirimEmail($opsi = null, $rec = null, $sub = null, $mess = null)
{
    //$url = "http://103.130.164.250/mail/"; //ke server
    $url = "http://localhost/mail/"; //ke local
    $token = "YhxHH4uOHI0j2UI2SExOS9ib85DBha2v5wQkIvad2ms7HHVVzE";

    $ch = curl_init();
    $data = array(
        'request' => $opsi, // [email','emailotp']
        'reciever' => $rec,
        'subject' => $sub,
        'body' => $mess
    );
    $new_data = json_encode($data);

    $array_options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $new_data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Content-Type:application/json',
            'token:'.$token.''
        )
    );
    curl_setopt_array($ch, $array_options);

    $resp = curl_exec($ch);

    echo $resp;

    curl_close($ch);
}



?>