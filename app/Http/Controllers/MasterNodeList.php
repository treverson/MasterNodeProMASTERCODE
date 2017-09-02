<?php

namespace App\Http\Controllers;

use App\Blocks;
use App\Totalnodes;
use GuzzleHttp\Client;
use App\Mnl;
use DateTime;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\elasticSearch;

class MasterNodeList extends Controller
{

	public function index()
	{
		$es                                    = new elasticSearch();
		$config['ES_coin']                     = env('COIN');
		$config['ES_type']                     = 'basestats';
		$search['size']                        = '1';
		$search['sort'][0]['time']['order']    = 'desc';
		$mnData                                = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                          = $mnData[0]['_source'];
		$config['ES_coin']                     = env('COIN');
		$config['ES_type']                     = 'mnl';
		$config['ES_id']                       = '1';
		$ret['stats']['masterNodeList']        = json_decode($es->esGET($config), true);
		$config['ES_coin']                     = env('COIN');
		$config['ES_type']                     = 'mnlcountry';
		$config['ES_id']                       = '1';
		$ret['stats']['masterNodeListCountry'] = json_decode($es->esGET($config), true);
		$ret['dataSet']                        = $this->moreLineGraphsData();
		return view('welcome', $ret);
	}

	public function moreList()
	{
		$es                                 = new elasticSearch();
		$config['ES_coin']                  = env('COIN');
		$config['ES_type']                  = 'basestats';
		$search['size']                     = '1';
		$search['sort'][0]['time']['order'] = 'desc';
		$mnData                             = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                       = $mnData[0]['_source'];
		$ret['search']                      = null;
		if (isset($_GET['search'])) {
			$ret['search'] = $_GET['search'];
			$mnl           = Mnl::where('addr', $ret['search'])->first();
			$mnl->save();
		}
		return view('nodeList', $ret);
	}

	public function moreMap()
	{
		$es                = new elasticSearch();
		$config['ES_coin']                     = env('COIN');
		$config['ES_type']                     = 'basestats';
		$search['size']                        = '1';
		$search['sort'][0]['time']['order']    = 'desc';
		$mnData                                = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                          = $mnData[0]['_source'];
		$config['ES_coin'] = env('COIN');
		$config['ES_type'] = 'mnl';
		$config['ES_id']   = '1';
		$ret['stats']['masterNodeList']      = json_decode($es->esGET($config), true);
		return view('map', $ret);
	}

	public function moreLineGraphs()
	{
		$es                                 = new elasticSearch();
		$config['ES_coin']                  = env('COIN');
		$config['ES_type']                  = 'basestats';
		$search['size']                     = '1';
		$search['sort'][0]['time']['order'] = 'desc';
		$mnData                             = json_decode($es->esSEARCH($search, $config), true);
		$ret['stats']                       = $mnData[0]['_source'];
		$ret['dataSet']                     = $this->moreLineGraphsData();
		return view('mlg', $ret);
	}

	public function moreLineGraphsDataSet()
	{
		$ret['dataSet'] = $this->moreLineGraphsData();
		return view('mlgData', $ret);
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
		$data['mnl']       = json_decode($es->esGET($config), true);
		return view('nodeDetails', $data);
	}

	// Other Content

	public function DataPack()
	{
		$es                                 = new elasticSearch();
		$config['ES_coin']                  = env('COIN');
		$config['ES_type']                  = 'basestats';
		$search['size']                     = '1';
		$search['sort'][0]['time']['order'] = 'desc';
		$mnData                             = json_decode($es->esSEARCH($search, $config), true);
		$ret                                = $mnData[0]['_source'];
		return response()->json($ret, 200, [], JSON_PRETTY_PRINT);
	}

	public function moreLineGraphsData()
	{
		$es   = new elasticSearch();
		$ret  = [];
		$type = '';
		if (isset($_GET['data'])) {
			$type = $_GET['data'];
		}
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
		} else {
			$stt = '-1 day';
		}


//		$searchConfig['ES_coin']                 = env('COIN');
//		$config['ES_type']                       = 'basestats';
//		$search['size']                          = 1000;
//		$search['sort'][0]['height']['order']    = 'desc';
//		$search['query']['range']['time']['gte'] = strtotime($stt);
//		$mnData                                  = json_decode($es->esSEARCH($search, $searchConfig, 'full'), true);


//		$totalNodes = Totalnodes::orderBy('id', 'desc')->where('created_at', '>', date("Y-m-d H:00:00", strtotime($stt)))->get();
//		$tnl        = $totalNodes->toArray();
//		krsort($tnl);
//		$tnlc = collect($tnl);
//		if ($type == '90day') {
//			if (count($tnlc) > 14400) {
//				$ret['totalnodeslist'] = $tnlc->nth(1440);
//			} else {
//				$ret['totalnodeslist'] = $tnlc->nth(60);
//			}
//		} elseif ($type == '30day') {
//			if (count($tnlc) > 14400) {
//				$ret['totalnodeslist'] = $tnlc->nth(1440);
//			} else {
//				$ret['totalnodeslist'] = $tnlc->nth(60);
//			}
//		} elseif ($type == '1day') {
//			$ret['totalnodeslist'] = $tnlc->nth(60);
//		} elseif ($type == '1hour') {
//			$ret['totalnodeslist'] = $tnlc;
//		} elseif ($type == 'trendline') {
//			if (count($tnlc) > 51840) {
//				$ret['totalnodeslist'] = $tnlc->nth(8640);
//			} else if (count($tnlc) > 14400) {
//				$ret['totalnodeslist'] = $tnlc->nth(1440);
//			} else {
//				$ret['totalnodeslist'] = $tnlc->nth(60);
//			}
//		} elseif ($type == 'avgincome') {
//			if (count($tnlc) > 51840) {
//				$ret['totalnodeslist'] = $tnlc->nth(8640);
//			} else if (count($tnlc) > 14400) {
//				$ret['totalnodeslist'] = $tnlc->nth(1440);
//			} else {
//				$ret['totalnodeslist'] = $tnlc->nth(5);
//			}
//		}
//		$ret['type'] = $type;
		return $ret;
	}
}
