<?php

namespace App\Http\Controllers;

use App\Blocks;
use App\Totalnodes;
use GuzzleHttp\Client;
use App\Mnl;
use DateTime;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Storage;

class MasterNodeList
{
	public function reward($height)
	{
		if ($height <= 700799) {
			$ret['height']     = 700799;
			$ret['reward']     = 16;
			$ret['nextreward'] = 8;
		} elseif ($height >= 1401599) {
			$ret['height']     = 1401599;
			$ret['reward']     = 8;
			$ret['nextreward'] = 4;
		} elseif ($height >= 2102399) {
			$ret['height']     = 2102399;
			$ret['reward']     = 4;
			$ret['nextreward'] = 2;
		} elseif ($height >= 2803199) {
			$ret['height']     = 2803199;
			$ret['reward']     = 2;
			$ret['nextreward'] = 1;
		} elseif ($height >= 3503999) {
			$ret['height']     = 3503999;
			$ret['reward']     = 1;
			$ret['nextreward'] = .5;
		} elseif ($height >= 4204799) {
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

	public function nodeDetails()
	{
		$data['key']           = $_GET['addr'];
		$data['mnl']           = Mnl::where('addr', $data['key'])->first();
		$data['mnl']['ipData'] = json_decode($data['mnl']['data'], true);
		return view('nodeDetails', $data);
	}

	public function moreList()
	{
		$ret           = $this->Core();
		$ret['search'] = null;
		if (isset($_GET['search'])) {
			$ret['search'] = $_GET['search'];
			$mnl           = Mnl::where('addr', $ret['search'])->first();
			if (count($mnl) > 0) {
				$mnl->total = Blocks::where('addr', $ret['search'])->sum('amt');
			}
			$mnl->save();
		}
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
		$json                           = Storage::get('results.json');
		$dataCore                       = json_decode($json, true);
		$ret['blocksLastDay']           = $dataCore['block24hour'];
		$block                          = Blocks::orderBy('blockid', 'desc')->first();
		$ret['averageBlockAwards']      = (float)number_format($dataCore['avgblocks'], '2', '.', '');
		$ret['totalMasterNodes']        = $dataCore['firstNode']['total'];
		$ret['currentUSDPrice']         = (float)number_format($dataCore['firstNode']['price'], '2', '.', '');
		$ret['income']                  = $this->income($dataCore['firstNode']['price'], $ret['blocksLastDay'], $ret['totalMasterNodes'], $block['blockid']);
		$ret['averageBlockTime']        = $this->averageBlockTime($ret['blocksLastDay']);
		$ret['daysTillRewardDrop']      = $this->ionRewardDropDays($block['blockid'], $ret['blocksLastDay']);
		$ret['currentMasterNodeReward'] = $this->masterNodeCurrentReward($block['blockid']);
		$ret['blocksSinceStartOfDay']   = $this->blocksToday();
		$ret['masterNodeWorth']         = $this->masterNodeWorth($dataCore['firstNode']['price']);
		$ret['height']                  = $block['blockid'];
		$ret['reward']                  = $this->reward($block['blockid']);
		return response()->json($ret, 200, [], JSON_PRETTY_PRINT);
	}

	public function DataPackAdv()
	{
		$json                           = Storage::get('results.json');
		$dataCore                       = json_decode($json, true);
		$ret['blocksLastDay']           = $dataCore['block24hour'];
		$block                          = Blocks::orderBy('blockid', 'desc')->first();
		$ret['averageBlockAwards']      = (float)number_format($dataCore['avgblocks'], '2', '.', '');
		$ret['totalMasterNodes']        = $dataCore['firstNode']['total'];
		$ret['currentUSDPrice']         = (float)number_format($dataCore['firstNode']['price'], '2', '.', '');
		$ret['income']                  = $this->income($dataCore['firstNode']['price'], $ret['blocksLastDay'], $ret['totalMasterNodes'], $block['blockid']);
		$ret['averageBlockTime']        = $this->averageBlockTime($ret['blocksLastDay']);
		$ret['daysTillRewardDrop']      = $this->ionRewardDropDays($block['blockid'], $ret['blocksLastDay']);
		$ret['currentMasterNodeReward'] = $this->masterNodeCurrentReward($block['blockid']);
		$ret['blocksSinceStartOfDay']   = $this->blocksToday();
		$ret['masterNodeWorth']         = $this->masterNodeWorth($dataCore['firstNode']['price']);
		$ret['core']                    = $dataCore;
		return response()->json($ret, 200, [], JSON_PRETTY_PRINT);
	}

	public function income($usdPrice, $blocksLastDay, $totalMasterNodes, $lastBlock)
	{
		$reward          = $this->reward($lastBlock);
		$blocksTotal     = number_format(($totalMasterNodes > 0) ? ($blocksLastDay / $totalMasterNodes) * ($reward['reward'] / 4) : 0, '8', '.', '');
		$basedaily       = $blocksTotal * $usdPrice;
		$total           = number_format($basedaily, '2', '.', ',');
		$data['daily']   = (float)$total;
		$data['weekly']  = (float)number_format(($total * 7), '2', '.', ',');
		$data['monthly'] = (float)number_format(($total * 30.42), '2', '.', ',');
		$data['yearly']  = (float)number_format(($total * 365), '2', '.', '');
		return $data;
	}

	public function averageBlockTime($blocksLastDay)
	{
		$total = (float)number_format(($blocksLastDay > 0) ? (86400 / $blocksLastDay) : 0, '1', '.', '');
		return $total;
	}

	public function ionRewardDropDays($lastBlock, $blocksLastDay)
	{
		$avgBlockTime = $this->averageBlockTime($blocksLastDay);
		$reward       = $this->reward($lastBlock);
		$blockleft    = $reward['height'] - $lastBlock;
		$sectilldrop  = $blockleft * $avgBlockTime;
		$total        = $this->calculate_time_span($sectilldrop);
		return $total;
	}

	public function masterNodeCurrentReward($lastBlock)
	{
		$reward = $this->reward($lastBlock);
		$total  = $reward['reward'] / 4;
		return $total;
	}

	public function masterNodeWorth($usdPrice)
	{
		$total = $usdPrice * 20000;
		return $total;
	}

	public function blocksToday()
	{
		$total = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime("midnight")))->count();
		return $total;
	}

	public function masterNodeListData()
	{
		$list = $nclist = $sortlist = [];
		$mnl  = Mnl::orderBy('id', 'desc')->get();
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
		foreach ($nclist as $key => $value) {
			$nclist[$key]['count']                            = count($value['data']);
			$sortlist[$nclist[$key]['count']]['country_name'] = $value['data'][0]['ipData']['country_name'];
			$sortlist[$nclist[$key]['count']]['count']        = number_format((($nclist[$key]['count'] / count($list)) * 100), '0', '.', '');
			$sortlist[$nclist[$key]['count']]['countb']       = 100 - $sortlist[$nclist[$key]['count']]['count'];
		}
		(count($sortlist) > 0) ? krsort($sortlist) : $sortlist;
		$data['sortlist'] = $sortlist;
		$data['list']     = $list;
		return $data;
	}

	public function Core()
	{
		$json = Storage::get('results.json');
		return json_decode($json, true);
	}

	public function jsonCore()
	{
		$totalNodes         = Totalnodes::orderBy('id', 'desc')->where('created_at', '>', date("Y-m-d H:00:00", strtotime('-30 days')))->get();
		$firstNode          = $totalNodes[0];
		$ret['firstNode']   = $firstNode;
		$ret1['totalNodes'] = $totalNodes;
		$tnjp               = json_decode($firstNode['data'], true);
		$masterNodeList     = $this->masterNodeListData();
		$ret['country']     = $masterNodeList['sortlist'];
		$block              = Blocks::orderBy('blockid', 'desc')->first();
		$reward             = $this->reward($block['blockid']);
		$ret['block']       = $block;
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
		$ret['avgblocks']       = ($firstNode['total'] > 0) ? $ret['block24hour'] / $firstNode['total'] : 0;
		$ret['iondaily']        = ($firstNode['total'] > 0) ? ($ret['block24hour'] / $firstNode['total']) * ($reward['reward'] / 4) : 0;
		$ret['price_usd']       = $firstNode['price'];
		$ret['income']          = $this->income($ret['price_usd'], $ret['block24hour'], $firstNode['total'], $block['blockid']);
		$ret['mnl']             = $masterNodeList['list'];
		$ret['avgblocktime']    = ($ret['block24hour'] > 0) ? 86400 / $ret['block24hour'] : 0;
		$ret['blockreward']     = $reward['reward'];
		$ret['nextbreward']     = $reward['nextreward'];
		$ret['MasternodeWorth'] = $ret['price_usd'] * 20000;
		$ret['daytilldrop']     = "N/A";
		$ret['blockstoday']     = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime("midnight")))->count();
		$ret['dailyaverage']    = $tnjp['dailyaverage'];
		$ret['weeklyaverage']   = $tnjp['weeklyaverage'];
		$ret['monthlyaverage']  = $tnjp['monthlyaverage'];
		$ret['avgrewardfreq']   = ($ret['avgblocks'] > 0) ? 24 / $ret['avgblocks'] : 0;
		$tnl                    = $totalNodes->toArray();
		krsort($tnl);
		$tnlc = collect($tnl);
		if (count($tnlc) > 7200) {
			$ret['totalnodeslist'] = $tnlc->nth(1440);
		} else {
			$ret['totalnodeslist'] = $tnlc->nth(60);
		}
		$ret['daytilldrop'] = $this->ionRewardDropDays($block['blockid'], $ret['block24hour']);
		$ret['lastUpdated'] = date('F j, Y, g:i a T');
		Storage::put('results.json', json_encode($ret, JSON_PRETTY_PRINT));
		Storage::put('mnl.json', json_encode($ret1, JSON_PRETTY_PRINT));
	}

	public function rpinode()
	{
		$rawData = file_get_contents("php://input");
		$data    = json_decode($rawData, true);
		$dir     = $data['secret'];
		$dir2    = sha1(md5($data['secret']));
		Storage::put('rpinodes/' . $dir . '/' . $dir2 . '.json', $rawData);
		echo $rawData;
	}

	public function myrpinode($mynode)
	{
		$json  = [];
		$files = Storage::files('rpinodes/' . sha1($mynode));
		if (count($files) > 0) {
			foreach ($files as $file) {
				$content = Storage::get($file);
				$json[]  = json_decode($content, true);
			}
		}
		$ret          = $this->Core();
		$ret['nodes'] = $json;
		return view('myrpinode', $ret);
	}

	public function sectohms($ss)
	{
		$s = $ss % 60;
		$m = floor(($ss % 3600) / 60);
		$h = floor(($ss % 86400) / 3600);
		$d = floor(($ss % 2592000) / 86400);
		$M = floor($ss / 2592000);

		return "$d D, $h H, $m M";
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

	function calculate_time_span($seconds)
	{
//		$seconds  = strtotime(date('Y-m-d H:i:s')) - strtotime($date);
		$months = floor($seconds / (3600 * 24 * 30));
		$day    = floor($seconds / (3600 * 24));
		$hours  = floor($seconds / 3600);
		$mins   = floor(($seconds - ($hours * 3600)) / 60);
		$secs   = floor($seconds % 60);
		if ($seconds < 60) {
			$ret['num']  = $secs;
			$ret['name'] = 'sec';
		} else if ($seconds < 60 * 60) {
			$ret['num']  = $mins;
			$ret['name'] = 'min';
		} else if ($seconds < 24 * 60 * 60) {
			$ret['num']  = $hours;
			$ret['name'] = 'hours';
		} else if ($seconds < 24 * 60 * 60) {
			$ret['num']  = $day;
			$ret['name'] = 'days';
		} else {
			$ret['num']  = $months;
			$ret['name'] = 'months';
		}
		return $ret;
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
			'GET', 'http://' . env('LOCAL_IP') . '/masternodelist.php?type=chc'
		);
		$content    = $res->getBody();
		$array      = json_decode($content, true);
		$resCMC     = $client->request(
			'GET', 'https://api.coinmarketcap.com/v1/ticker/' . env('COINMARKETCAPID') . '/'
		);
		$contentCMC = $resCMC->getBody();
		$cmc        = json_decode($contentCMC, true);
		$data       = $list = [];
		Mnl::where('status', 'ENABLED')->update(['status' => 'OFFLINE']);
		if (count($array) > 0) {
			foreach ($array as $key => $value) {
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
				$mnl = Mnl::where('addr', $data['addr'])->first();
				if (count($mnl) == 0) {
					$geoipcontent = '';
					try {
						$freegeoip    = $client->request(
							'GET', 'http://freegeoip.net/json/' . $data['ip']
						);
						$geoipcontent = $freegeoip->getBody();
					}
					catch (exception $e) {

					}
					$mnl         = new Mnl();
					$mnl->status = 'NEW';
					$mnl->addr   = $data['addr'];
					$mnl->ip     = $data['ip'];
					$mnl->port   = $data['port'];
					$mnl->total  = Blocks::where('addr', $mnl->addr)->sum('amt');
					$mnl->data   = $geoipcontent;
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
		$ret['avgblocks']      = ($total > 0) ? $ret['block24hour'] / $total : 0;
		$ret['iondaily']       = (count($list) > 0) ? $rewardb24total / count($list) : 0;
		$ret['incomedaily']    = $ret['iondaily'] * $ret['price_usd'];
		$ret['incomeweekly']   = $ret['incomedaily'] * 7;
		$ret['incomemonth']    = $ret['incomedaily'] * 30.42;
		$oneweektotal          = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 week')))->sum('amt');
		$onemonthtotal         = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 month')))->sum('amt');
		$oneyeartotal          = Blocks::where('created_at', '>', date("Y-m-d H:m:s", strtotime('-1 year')))->sum('amt');
		$ret['dailyaverage']   = ($total > 0) ? (($oneweektotal / 7) / $total) * $ret['price_usd'] : 0;
		$ret['weeklyaverage']  = ($total > 0) ? (($onemonthtotal / 7) / $total) * $ret['price_usd'] : 0;
		$ret['monthlyaverage'] = ($total > 0) ? (($oneyeartotal / 12) / $total) * $ret['price_usd'] : 0;
		$totalNodes            = new Totalnodes();
		$totalNodes->price     = $ret['price_usd'];
		$totalNodes->data      = json_encode($ret);
		$totalNodes->total     = $total;
		$totalNodes->save();
		$this->jsonCore();
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
