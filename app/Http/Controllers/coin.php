<?php

namespace App\Http\Controllers;

use App\Blocks;
use Validator, Input, Redirect, View, Auth;
use App\Mnl;

class coin extends Controller
{
	public function walletdata($blockHeight) {
		$reward = $this->reward($blockHeight);
		$data['min'] = $reward['reward'] / (100 / env('MASTERNODE_PERCENT_OF_BLOCK'));
		$data['max'] = $reward['reward'] / (100 / env('MASTERNODE_PERCENT_OF_BLOCK')) . '05';
		return $data;
	}
	public function mnldata($key, $value)
	{
		$split          = explode(" ", ltrim(rtrim($value)));
		$data['status'] = $split[0];
		$data['addr']   = $split[2];
		$splita         = explode(":", ltrim(rtrim($key)));
		if (count($splita) > 2) {
			$data['iptype'] = 'ipv6';
			$data['ip']     = str_replace("[", "", $splita[0]) . ":" . $splita[1] . ":" . $splita[2] . ":" . $splita[3] . ":" . $splita[4] . ":" . str_replace("]", "", $splita[5]);
			$data['port']   = $splita[6];
		} else {
			$data['iptype'] = 'ipv4';
			$data['ip']     = $splita[0];
			$data['port']   = $splita[1];
		}
		return $data;
	}

	public function reward($height)
	{
		if ($height <= 700799) {
			$ret['height']     = 700799;
			$ret['reward']     = 16;
			$ret['nextreward'] = 8;
		} elseif ($height <= 1401599) {
			$ret['height']     = 1401599;
			$ret['reward']     = 8;
			$ret['nextreward'] = 4;
		} elseif ($height <= 2102399) {
			$ret['height']     = 2102399;
			$ret['reward']     = 4;
			$ret['nextreward'] = 2;
		} elseif ($height <= 2803199) {
			$ret['height']     = 2803199;
			$ret['reward']     = 2;
			$ret['nextreward'] = 1;
		} elseif ($height <= 3503999) {
			$ret['height']     = 3503999;
			$ret['reward']     = 1;
			$ret['nextreward'] = .5;
		} elseif ($height <= 4204799) {
			$ret['height']     = 4204799;
			$ret['reward']     = .5;
			$ret['nextreward'] = .25;
		} else {
			$ret['height']     = 20000000;
			$ret['reward']     = 0;
			$ret['nextreward'] = "N/A";
		}
		return $ret;
	}
}