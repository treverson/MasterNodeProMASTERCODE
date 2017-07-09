<?php
require_once 'coins.php';
$wallet = new jsonRPCClient('http://' . $chc['user'] . ':' . $chc['pass'] . '@'.$chc['ip'].':' . $chc['port'].'/');
if (isset($wallet)) {
	$process = $wallet->masternodelist('full');
	echo json_encode($process);
}