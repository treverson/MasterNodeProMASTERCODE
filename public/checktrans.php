<?php
require_once 'coins.php';
$wallet = new jsonRPCClient('http://' . $ion['user'] . ':' . $ion['pass'] . '@127.0.0.1:' . $ion['port']);
if (isset($wallet)) {
	$process = $wallet->getblock($_REQUEST['txid']);
	foreach ($process['tx'] as $key => $value) {
		$tranX = $wallet->gettransaction($value);
		if (isset($tranX['vout'])) {
			$process['trans'][$key]['tx']   = $value;
			foreach ($tranX['vout'] as $voutKey => $vout) {
				$process['trans'][$key]['vout'][$voutKey] = $vout;
			}
		}
	}
	echo json_encode($process, JSON_PRETTY_PRINT);
}