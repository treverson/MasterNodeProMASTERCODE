<?php

namespace App\Http\Controllers;

use App\Blocks;
use App\Totalnodes;
use GuzzleHttp\Client;
use App\Mnl;
use DateTime;
use Jenssegers\Agent\Agent;

class MasterNodeList
{
	private function reward($height)
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

	public function nodeDetails()
	{
		$data['key']           = $_GET['addr'];
		$data['mnl']           = Mnl::where('addr', $data['key'])->first();
		$data['mnl']['ipData'] = json_decode($data['mnl']['data'], true);
		return view('nodeDetails', $data);
	}

	public function moreList()
	{
		$ret = $this->Core();
		return view('nodeList', $ret);
	}

	public function moreMap()
	{
		$ret = $this->Core();
		return view('map', $ret);
	}

	public function moreLineGraphsData()
	{
		$type = $_GET['data'];
		if ($type == '90day') {
			$stt = '-90 days';
		} elseif ($type == '30day') {
			$stt = '-30 days';
		} elseif ($type == '1day') {
			$stt = '-1 day';
		} elseif ($type == '1hour') {
			$stt = '-1 hour';
		} elseif ($type == 'trendline') {
			$stt = '-30 days';
		} elseif ($type == 'avgincome') {
			$stt = '-30 days';
		}
		$totalNodes = Totalnodes::orderBy('id', 'desc')->where('created_at', '>', date("Y-m-d H:00:00", strtotime($stt)))->get();
		$tnl        = $totalNodes->toArray();
		krsort($tnl);
		$tnlc = collect($tnl);
		if ($type == '90day') {
			if (count($tnlc) > 14400) {
				$ret['totalnodeslist'] = $tnlc->nth(1440);
			} else {
				$ret['totalnodeslist'] = $tnlc->nth(60);
			}
		} elseif ($type == '30day') {
			if (count($tnlc) > 14400) {
				$ret['totalnodeslist'] = $tnlc->nth(1440);
			} else {
				$ret['totalnodeslist'] = $tnlc->nth(60);
			}
		} elseif ($type == '1day') {
			$ret['totalnodeslist'] = $tnlc->nth(60);
		} elseif ($type == '1hour') {
			$ret['totalnodeslist'] = $tnlc;
		} elseif ($type == 'trendline') {
			if (count($tnlc) > 51840) {
				$ret['totalnodeslist'] = $tnlc->nth(8640);
			} else if (count($tnlc) > 14400) {
				$ret['totalnodeslist'] = $tnlc->nth(1440);
			} else {
				$ret['totalnodeslist'] = $tnlc->nth(60);
			}
		} elseif ($type == 'avgincome') {
			if (count($tnlc) > 51840) {
				$ret['totalnodeslist'] = $tnlc->nth(8640);
			} else if (count($tnlc) > 14400) {
				$ret['totalnodeslist'] = $tnlc->nth(1440);
			} else {
				$ret['totalnodeslist'] = $tnlc->nth(5);
			}
		}
		$ret['type'] = $type;
		return view('mlgData', $ret);
	}

	public function moreLineGraphs()
	{
		$ret = $this->Core();
		return view('mlg', $ret);
	}

	public function moreStats()
	{
		$ret = $this->Core();
		return view('stats', $ret);
	}

	public function DataPack()
	{
		$totalNodes              = Totalnodes::orderBy('id', 'desc')->where('created_at', '>', date("Y-m-d H:00:00", strtotime('-1 minute')))->get();
		$ret['totalMasterNodes'] = $totalNodes[0]['total'];
		$ret['price_usd']        = $totalNodes[0]['price'];
		$ret['MasternodeWorth']  = $totalNodes[0]['price'] * 20000;
		$ret['block24hour']      = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 days')))->count();
		$block                   = Blocks::orderBy('blockid', 'desc')->first();
		$reward                  = $this->reward($block['blockid']);
		$ret['block24total']     = number_format(($ret['block24hour'] / $ret['totalMasterNodes']) * ($reward['reward'] / 2), '8', '.', '');
		$basedaily               = $ret['block24total'] * $ret['price_usd'];
		$ret['incomedaily']      = number_format($basedaily, '2', '.', ',');
		$ret['incomeweekly']     = number_format(($basedaily * 7), '2', '.', ',');
		$ret['incomemonth']      = number_format(($basedaily * 30.42), '2', '.', ',');
		$ret['avgblocktime']     = number_format((86400 / $ret['block24hour']), '1', '.', '');
		$blockleft               = $reward['height'] - $block['blockid'];
		$sectilldrop             = $blockleft * $ret['avgblocktime'];
		$ret['daytilldrop']      = $this->secondstodays($sectilldrop);
		$ret['mnreward']         = $reward['reward'] / 2;
		$ret['blockstoday']      = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime("midnight")))->count();
		return $ret;
	}

	public function Core()
	{
		$agent = new Agent();
		$list  = [];
		$mnl   = Mnl::orderBy('id', 'desc')->get();
		foreach ($mnl as $eachmnl) {
			$data['status'] = $eachmnl['status'];
			$data['addr']   = $eachmnl->addr;
			$data['ip']     = $eachmnl->ip;
			$data['port']   = $eachmnl->port;
			$data['total']  = $eachmnl->total;
			$data['ipData'] = json_decode($eachmnl->data, true);
			$list[]         = $data;
		}
		foreach ($list as $value) {
			$nclist[$value['ipData']['country_code']]['data'][] = $value;
		}
		$totalNodes        = Totalnodes::orderBy('id', 'desc')->where('created_at', '>', date("Y-m-d H:00:00", strtotime('-30 days')))->get();
		$ret['totalnodes'] = $totalNodes;
		$tnjp              = json_decode($ret['totalnodes'][0]['data'], true);
		foreach ($nclist as $key => $value) {
			$nclist[$key]['count']                            = count($value['data']);
			$sortlist[$nclist[$key]['count']]['country_name'] = $value['data'][0]['ipData']['country_name'];
			$sortlist[$nclist[$key]['count']]['count']        = number_format((($nclist[$key]['count'] / count($list)) * 100), '0', '.', '');
			$sortlist[$nclist[$key]['count']]['countb']       = 100 - $sortlist[$nclist[$key]['count']]['count'];
		}
		krsort($sortlist);
		$ret['country']     = $sortlist;
		$block              = Blocks::orderBy('blockid', 'desc')->first();
		$reward             = $this->reward($block['blockid']);
		$ret['block24hour'] = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 days')))->count();
		$bd                 = 0;
		$bspec              = 1350;
		while ($bd <= 6) {
			$bds                                 = $bd - 1;
			$count                               = Blocks::where('created_at', '>', date("Y-m-d 00:00:00", strtotime('-' . $bd . ' days')))->where('created_at', '<', date("Y-m-d 00:00:00", strtotime('-' . $bds . ' days')))->count();
			$ret['blockdetails'][$bd]['percent'] = number_format((($count / $bspec) * 100), '0', '.', '');
			$bd++;
		}
		$rewardb24total         = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 days')))->sum('amt');
		$ret['avgblocks']       = $ret['block24hour'] / $ret['totalnodes'][0]['total'];
		$ret['iondaily']        = ($ret['block24hour'] / $ret['totalnodes'][0]['total']) * ($reward['reward'] / 2);
		$ret['price_usd']       = $ret['totalnodes'][0]['price'];
		$ret['incomedaily']     = $ret['iondaily'] * $ret['price_usd'];
		$ret['incomeweekly']    = $ret['incomedaily'] * 7;
		$ret['incomemonth']     = $ret['incomedaily'] * 30.42;
		$ret['mnl']             = $list;
		$ret['avgblocktime']    = 86400 / $ret['block24hour'];
		$ret['blockreward']     = $reward['reward'];
		$ret['nextbreward']     = $reward['nextreward'];
		$ret['MasternodeWorth'] = $ret['price_usd'] * 20000;
		$blockleft              = $reward['height'] - $block['blockid'];
		$sectilldrop            = $blockleft * $ret['avgblocktime'];
		$ret['daytilldrop']     = "N/A";
		$ret['blockstoday']     = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime("midnight")))->count();
		$ret['dailyaverage']    = $tnjp['dailyaverage'];
		$ret['weeklyaverage']   = $tnjp['weeklyaverage'];
		$ret['monthlyaverage']  = $tnjp['monthlyaverage'];
		$ret['avgrewardfreq']   = 24 / $ret['avgblocks'];
		$tnl                    = $totalNodes->toArray();
		krsort($tnl);
		$tnlc = collect($tnl);
		if (count($tnlc) > 7200) {
			$ret['totalnodeslist'] = $tnlc->nth(1440);
		} else {
			$ret['totalnodeslist'] = $tnlc->nth(60);
		}
		if ($sectilldrop > 0)
			$ret['daytilldrop'] = $this->secondstodays($sectilldrop);
		return $ret;
	}

	public function masternodelist()
	{
		$ret = $this->Core();
		return view('welcome', $ret);
	}

	private function secondstodays($seconds)
	{
		$seconds = number_format($seconds, '0', '.', '');
		$dt1     = new DateTime("@0");
		$dt2     = new DateTime("@$seconds");
		return $dt1->diff($dt2)->format('%a');
	}

	public function lastblock()
	{
		$block = Blocks::where('id', '>', 0)->orderBy('id', 'desc')->first();
		echo "<pre>" . json_encode($block, JSON_PRETTY_PRINT) . "</pre>";

	}

	public function datapull()
	{
		$client     = new Client();
		$res        = $client->request(
			'GET', 'http://45.32.223.231/masternodelist.php?type=ion'
		);
		$content    = $res->getBody();
		$array      = json_decode($content, true);
		$resCMC     = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/ion/'
		);
		$contentCMC = $resCMC->getBody();
		$cmc        = json_decode($contentCMC, true);
		$data       = $list = [];
		Mnl::where('status', 'ENABLED')->update(['status' => 'OFFLINE']);
		if (count($array) > 0) {
			foreach ($array as $key => $value) {
				$split          = explode(" ", trim($value));
				$data['status'] = $split[0];
				$data['addr']   = $split[2];
				$splita         = explode(":", $split[3]);
				$data['ip']     = $splita[0];
				$data['port']   = $splita[1];
				$mnl            = Mnl::where('addr', $data['addr'])->first();
				if (count($mnl) == 0) {
					$freegeoip    = $client->request(
						'GET', 'http://freegeoip.net/json/' . $data['ip']
					);
					$geoipcontent = $freegeoip->getBody();
					$mnl          = new Mnl();
					$mnl->status  = 'NEW';
					$mnl->addr    = $data['addr'];
					$mnl->ip      = $data['ip'];
					$mnl->port    = $data['port'];
					$mnl->total   = Blocks::where('addr', $mnl->addr)->sum('amt');
					$mnl->data    = $geoipcontent;
				} else {
					$mnl->status = 'ACTIVE';
					if (strtotime($mnl->created_at) >= strtotime('-30 min')) {
						$mnl->status = 'NEW';
					}
					$mnl->total   = Blocks::where('addr', $mnl->addr)->sum('amt');
					$geoipcontent = $mnl->data;
				}
				$data['total']  = Blocks::where('addr', $data['addr'])->sum('amt');
				$data['ipData'] = json_decode($geoipcontent, true);
				$list[]         = $data;
				$mnl->save();
			}
		}
		$total                 = count($array);
		$ret['price_usd']      = $cmc[0]['price_usd'];
		$ret['block24hour']    = Blocks::where('created_at', '>=', date("Y-m-d H:m:s", strtotime('-1 day')))->count();
		$rewardb24total        = Blocks::where('created_at', '>=', date("Y-m-d H:m:s", strtotime('-1 day')))->sum('amt');
		$ret['avgblocks']      = $ret['block24hour'] / $total;
		$ret['iondaily']       = $rewardb24total / count($list);
		$ret['incomedaily']    = $ret['iondaily'] * $ret['price_usd'];
		$ret['incomeweekly']   = $ret['incomedaily'] * 7;
		$ret['incomemonth']    = $ret['incomedaily'] * 30.42;
		$oneweektotal          = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 week')))->sum('amt');
		$onemonthtotal         = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 month')))->sum('amt');
		$oneyeartotal          = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 year')))->sum('amt');
		$ret['dailyaverage']   = (($oneweektotal / 7) / $total) * $ret['price_usd'];
		$ret['weeklyaverage']  = (($onemonthtotal / 7) / $total) * $ret['price_usd'];
		$ret['monthlyaverage'] = (($oneyeartotal / 12) / $total) * $ret['price_usd'];
		$totalNodes            = new Totalnodes();
		$totalNodes->price     = $cmc[0]['price_usd'];
		$totalNodes->data      = json_encode($ret);
		$totalNodes->total     = $total;
		$totalNodes->save();
	}

	public function blockprocess()
	{
		$i = $currentblock = 73952;
		while ($i > 0) {
			$i--;
			$block = Blocks::where('blockid', $i)->count();
			if ($block == 0) {
				$cc      = new \App\Http\Controllers\coincontrol();
				$process = $cc->blocknumber($i);
				echo $process;
				sleep(3);
			}
		}
	}
}
