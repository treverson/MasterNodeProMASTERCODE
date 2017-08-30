<?php

namespace App\Http\Controllers;

use App\Blocks;
use App\Totalnodes;
use GuzzleHttp\Client;
use App\Mnl;
use DateTime;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\coin;
use App\Http\Controllers\elasticSearch;

class MasterNodeList extends coin
{

	public function index()
	{
		$es                                 = new elasticSearch();
		$config['ES_coin']                  = env('COIN');
		$config['ES_type']                  = 'basestats';
		$search['size']                     = '1';
		$search['sort'][0]['time']['order'] = 'desc';
		$mnData                             = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                       = $mnData[0]['_source'];
		return view('welcome', $ret);
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
		$es                                 = new elasticSearch();
		$config['ES_coin']                  = env('COIN');
		$config['ES_type']                  = 'basestats';
		$search['size']                     = '1';
		$search['sort'][0]['time']['order'] = 'desc';
		$mnData                             = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                       = $mnData[0]['_source'];
		return view('stats', $ret);
	}

	public function nodeDetails()
	{
		$es                = new elasticSearch();
		$config['ES_coin'] = env('COIN');
		$config['ES_type'] = 'mn';
		$config['ES_id']   = $_GET['addr'];
		$data['mnl']              = json_decode($es->esGET($config), true);
		return view('nodeDetails', $data);
	}


}
