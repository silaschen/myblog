<?php
$userid = 'avishwakarma';
$appid = '5e44d746-21a3-465f-a7d6-b4b1689a54a7';
$partnerid = '5303e1e99a8d7065eeac75038cc75eb2';
$url = sprintf("https://codata.lenovo.com/partner/qliksense/appinfo?appid=%s", $appid);
$ch = curl_init($url);

$headers = array('CODATAPARTNER:'.$partnerid,'CODATAUSERID:'.$userid);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
$ret = curl_exec($ch);


echo $ret;
$r = json_decode($ret, true);
$resonse = $r['info']['url'];
echo "resonse: ".$resonse; 
curl_close($ch); 
