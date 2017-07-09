<?php

namespace App\Http\Controllers;

use App\Blocks;
use Validator, Input, Redirect, View, Auth;
use App\Mnl;

class coin extends Controller
{
	public function mnldata($key,$value) {
		$split          = explode(" ", trim($value));
		$data['status'] = $split[0];
		$data['addr']   = $split[2];
		$splita         = explode(":", $split[3]);
		$data['ip']     = $splita[0];
		$data['port']   = $splita[1];
		return $data;
	}
	public function reward($height)
	{
		if ($height <= 125146) {
			$ret['height']     = 125146;
			$ret['reward']     = 23;
			$ret['nextreward'] = 17;
		} elseif ($height <= 568622) {
			$ret['height']     = 568622;
			$ret['reward']     = 17;
			$ret['nextreward'] = 11.5;
		} elseif ($height <= 1012098) {
			$ret['height']     = 1012098;
			$ret['reward']     = 11.5;
			$ret['nextreward'] = 5.75;
		} elseif ($height <= 1455574) {
			$ret['height']     = 1455574;
			$ret['reward']     = 5.75;
			$ret['nextreward'] = 1.85;
		} elseif ($height <= 3675950) {
			$ret['height']     = 3675950;
			$ret['reward']     = 1.85;
			$ret['nextreward'] = 0.2;
		} else {
			$ret['height']     = 20000000;
			$ret['reward']     = 0.2;
			$ret['nextreward'] = "N/A";
		}
		return $ret;
	}
}