<?php
require_once 'coins.php';
//$wallet = new jsonRPCClient('http://' . $chc['user'] . ':' . $chc['pass'] . '@'.$chc['ip'].':' . $chc['port'].'/',true);

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_PORT => "58273",
	CURLOPT_URL => 'http://' . $chc['user'] . ':' . $chc['pass'] . '@'.$chc['ip'].':' . $chc['port'].'/',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "{\"method\":\"getinfo\",\"params\":[],\"id\":1,\"jsonrpc\":\"1.0\"}",
	CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: application/json"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}