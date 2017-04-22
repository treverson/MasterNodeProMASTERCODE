<?php

namespace App\Http\Controllers;

use App\Blocks;
use Validator, Input, Redirect, View, Auth;
use App\Mnl;

class coincontrol extends Controller
{
	protected $client, $user;

	public function __construct()
	{
		$this->client = new \GuzzleHttp\Client();
//		$this->user   = json_decode(Auth::user());
	}

	public function price($coin = null)
	{
//		if ($coin != null) {
//			$one = R::findOne('pricecheck', 'coin = ? and status = ?', [$coin, 1]);
//			return $one->price;
//		}
		return 0.01;
	}

	public function priceall()
	{
//		$coinprice = $this->coinprice();
//		$findAll   = R::findAll('pricecheck', 'status = ?', [1]);
//		if (count($findAll) > 0) {
//			foreach ($findAll as $one) {
//				$one->status = 2;
//				R::store($one);
//			}
//		}
//		$findAll = R::findAll('coins');
//		if (count($findAll) > 0) {
//			foreach ($findAll as $one) {
//				$symbol = strtolower($one->symbol);
//				foreach ($coinprice as $coin) {
//					if ($coin['id'] == $one->coin) {
//						$pc             = R::dispense('pricecheck');
//						$pc->coin       = $one->symbol;
//						$pc->price      = $coin['price_usd'];
//						$pc->json       = json_encode($coin);
//						$pc->status     = 1;
//						$pc->created_at = date("Y-m-d H:i:s");
//						R::store($pc);
//					}
//				}
//			}
//		}
	}

	public function coinlist()
	{
//		$func    = new func();
//		$days    = $func->weekts();
//		$findAll = R::findAll('coins', 'order by top asc');
//		foreach ($findAll as $one) {
//			$data[$one->symbol]['usd_price'] = $this->usdprice($one->symbol);
//			$data[$one->symbol]['img']       = $one->img;
//			$data[$one->symbol]['symbol']    = $one->symbol;
//			$data[$one->symbol]['url']       = $one->url;
//			$data[$one->symbol]['coin']      = $one->coin;
//			$data[$one->symbol]['color']     = $one->color;
//			$last7                           = '';
//			if (isset($this->user)) {
//				foreach ($days as $day) {
//					$theday  = date('Y-m-d', $day);
//					$findAll = R::findAll('buttons', 'userid = ? and status LIKE ? and createdat LIKE ? and coin LIKE ?', [$this->user->id, 'completed', '%' . $theday . '%', $one->symbol]);
//					if (count($findAll) > 0) {
//						$total = 0;
//						foreach ($findAll as $findOne) {
//							$usd   = $findOne->received_cents;
//							$total = $total + $usd;
//						}
//						$last7 .= $total . ',';
//					} else {
//						$last7 .= '0,';
//					}
//				}
//				$data[$one->symbol]['last7'] = rtrim($last7, ",");
//			}
//		}
//		return $data;
	}

	public function usdprice($coin)
	{
//		$data    = array();
//		$findOne = R::findOne('pricecheck', 'coin = ? and status = ?', [$coin, 1]);
//		$number  = $findOne->price;
//		$price   = floor(($number * 100)) / 100;
//		return '$' . number_format($price, 2);
	}

	public function addresscheck($coin, $address)
	{
//		$res     = $this->client->request('GET', 'http://' . env('APP_WALLETSERVER', '127.0.0.1') . '/walletcheck.php?type=' . $coin . '&wallet=' . $address);
//		$results = json_decode($res->getBody());
//		return $results;
	}

	public function newaddress($coin)
	{
//		$res     = $this->client->request('GET', 'http://' . env('APP_WALLETSERVER', '127.0.0.1') . '/newaddress.php?type=' . $coin);
//		$results = json_decode($res->getBody());
//		return $results;
	}

	public function coinprice()
	{
//		$url  = 'https://api.coinmarketcap.com/v1/ticker/';
//		$json = json_decode(file_get_contents($url), true);
//		return $json;
	}

	public function wallet($coin)
	{
//		foreach ($_POST as $k => $value) {
//			$return = $k;
//		}
//		$res     = $this->client->request('GET', 'http://' . env('APP_WALLETSERVER', '127.0.0.1') . '/checktrans.php?type=' . $coin . '&txid=' . $return);
//		$results = json_decode($res->getBody(), true);
//		$n       = R::findOne('ledger', 'txid = ?', [$return]);
//		if (isset($n) == false) {
//			$n = R::dispense('ledger');
//		}
//		$n->coin     = $coin;
//		$n->txid     = $return;
//		$n->address  = $results['details'][0]['address'];
//		$n->value    = $results['amount'];
//		$n->confirms = $results['confirmations'];
//		R::store($n);
//		return $return;
	}

	public function block($type)
	{
		foreach ($_REQUEST as $k => $value) {
			$return = $k;
		}
		$ret     = '';
		$res     = $this->client->request('GET', 'http://45.32.223.231/checktrans.php?txid=' . $return);
		$results = $res->getBody();
		$resJson = json_decode($results, true);
		$block          = new Blocks();
		$block->block   = $resJson['hash'];
		$block->blockid = $resJson['height'];
		$block->addr    = "n/a";
		$block->amt     = 0;
		$block->data    = json_encode($resJson);
		foreach ($resJson['trans'] as $value) {
			if (isset($value['vout'])) {
				foreach ($value['vout'] as $voutKey => $vout) {
					if ($vout['value'] >= 11.5 and $vout['value'] < 12) {
						if (isset($vout['scriptPubKey']) and isset($vout['scriptPubKey']['addresses'])) {
							foreach ($vout['scriptPubKey']['addresses'] as $addKey => $addValue) {
								$mnl = Mnl::where('addr', $addValue)->first();
								if (count($mnl) > 0) {
									$mnl->total = Blocks::where('addr',$addValue)->sum('amt');
									$block->addr    = $addValue;
									$block->amt     = $vout['value'];
								}
								$mnl->save();
							}
						}
					}
				}
			}
		}
		$block->save();
		return $ret;
	}

	public function blocknumber($number)
	{
		foreach ($_REQUEST as $k => $value) {
			$return = $k;
		}
		$ret = '';
		$mnl = Blocks::where('blockid', $number)->count();
		if ($mnl == 0) {
			$res     = $this->client->request('GET', 'http://45.32.223.231/checkblock.php?block=' . $number);
			$results = $res->getBody();
			$resJson = json_decode($results, true);
			$block          = new Blocks();
			$block->block   = $resJson['hash'];
			$block->blockid = $resJson['height'];
			$block->addr    = "n/a";
			$block->amt     = 0;
			$block->data    = json_encode($resJson);
			echo $resJson['height'] . " : " . date("Y-m-d H:m:s", $resJson['time']) . "\r\n";
			foreach ($resJson['trans'] as $value) {
				if (isset($value['vout'])) {
					foreach ($value['vout'] as $voutKey => $vout) {
						if ($vout['value'] >= 11.5 and $vout['value'] < 12) {
							if (isset($vout['scriptPubKey']) and isset($vout['scriptPubKey']['addresses'])) {
								foreach ($vout['scriptPubKey']['addresses'] as $addKey => $addValue) {
									$mnl = Mnl::where('addr', $addValue)->first();
									if (count($mnl) > 0) {
										$mnl->total = Blocks::where('addr',$addValue)->sum('amt');
										$block->addr    = $addValue;
										$block->amt     = $vout['value'];
									}
									$mnl->save();
								}
							}
						}
					}
				}
			}
			$block->created_at = date("Y-m-d H:m:s", $resJson['time']);
			$block->save();
		} else {
			echo $number . " : Got it All ready\r\n";
		}
	}
}