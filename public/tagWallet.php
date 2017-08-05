<?php
require_once 'coins.php';
$wallet     = new jsonRPCClient('http://' . $coin['user'] . ':' . $coin['pass'] . '@' . $coin['ip'] . ':' . $coin['port'] . '/');
$entityBody = file_get_contents('php://input');
$data       = json_decode($entityBody, true);
if (isset($wallet)) {
	$process = $wallet->verifymessage($data['addr'],$data['hash'],'MasterNodes.Pro');
	echo json_encode($process, JSON_PRETTY_PRINT);
}