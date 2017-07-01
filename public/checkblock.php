<?php
require_once 'coins.php';
$wallet = new jsonRPCClient('http://' . $chc['user'] . ':' . $chc['pass'] . '@'.$chc['ip'].':' . $chc['port'].'/');
if (isset($wallet)) {
	try {
		$blockhash = $wallet->getblockhash((int)$_REQUEST['block']);
		echo $blockhash;
		$process = $wallet->getblock($blockhash->result);
//		foreach ($process['tx'] as $key => $value) {
//			$tranX = $wallet->gettransaction($value);
//			if (isset($tranX['vout'])) {
//				$process['trans'][$key]['tx']   = $value;
//				foreach ($tranX['vout'] as $voutKey => $vout) {
//					$process['trans'][$key]['vout'][$voutKey] = $vout;
//				}
//			}
//		}
		echo json_encode($process, JSON_PRETTY_PRINT);
	} catch (exception $e) {
		echo $e;
	}
}