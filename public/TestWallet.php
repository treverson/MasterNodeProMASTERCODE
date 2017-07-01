<?php
require_once 'coins.php';
$wallet = new jsonRPCClient('http://' . $chc['user'] . ':' . $chc['pass'] . '@'.$chc['ip'].':' . $chc['port'].'/');
if (isset($wallet)) {
	try {
		$process = $wallet->getinfo();
		echo json_encode($process, JSON_PRETTY_PRINT);
	} catch (exception $e) {
		echo $e;
	}
}