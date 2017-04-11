<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', array('as' => 'index', 'uses' => 'MasterNodeList@masternodelist'));
Route::get('/advanced/list', array('as' => 'advlist', 'uses' => 'MasterNodeList@moreList'));
Route::get('/advanced/stats', array('as' => 'advstats', 'uses' => 'MasterNodeList@moreStats'));
Route::get('/advanced/map', array('as' => 'advmap', 'uses' => 'MasterNodeList@moreMap'));
Route::get('/advanced/graph', array('as' => 'advgraph', 'uses' => 'MasterNodeList@moreLineGraphs'));
Route::get('/advanced/graph/data/', array('as' => 'mlgdata', 'uses' => 'MasterNodeList@moreLineGraphsData'));
Route::get('/nodedetails/', array('as' => 'nodedetails', 'uses' => 'MasterNodeList@nodeDetails'));
Route::get('/blocks', array('uses' => 'MasterNodeList@blockprocess'));
Route::get('/lastblock', array('uses' => 'MasterNodeList@lastblock'));
Route::any('/{coin}/block', function($coin) {
	$cc = new \App\Http\Controllers\coincontrol();
	$process = $cc->block($coin);
	echo $process;
});
Route::any('/{coin}/blocknumber/{number}', function($coin,$number) {
	$cc = new \App\Http\Controllers\coincontrol();
	$process = $cc->blocknumber($number);
	echo $process;
});