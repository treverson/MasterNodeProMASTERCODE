<?php
require_once 'coins.php';
$wallet = new jsonRPCClient('http://' . $ion['user'] . ':' . $ion['pass'] . '@127.0.0.1:' . $ion['port']);
if (isset($wallet)) {
	$process = $wallet->masternodelist('full');
	echo json_encode($process);
}