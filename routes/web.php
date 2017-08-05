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

Route::group(['prefix' => 'api', 'middleware' => 'throttle:2'], function () {
	Route::get('/datapack', array('uses' => 'MasterNodeList@DataPack'));
	Route::get('/datapack/advanced', array('uses' => 'MasterNodeList@DataPackAdv'));
	Route::get('/datapull', array('uses' => 'MasterNodeList@datapull'));
	Route::get('/getcoins', array('uses' => 'MasterNodeList@cmcPrice'));
});
Route::get('/', array('as' => 'index', 'uses' => 'MasterNodeList@masternodelist'))->middleware('throttle:6');
Route::get('/advanced/list', array('as' => 'advlist', 'uses' => 'MasterNodeList@moreList'))->middleware('throttle:6');
Route::get('/advanced/stats', array('as' => 'advstats', 'uses' => 'MasterNodeList@moreStats'))->middleware('throttle:6');
Route::get('/advanced/map', array('as' => 'advmap', 'uses' => 'MasterNodeList@moreMap'))->middleware('throttle:6');
Route::get('/advanced/graph', array('as' => 'advgraph', 'uses' => 'MasterNodeList@moreLineGraphs'))->middleware('throttle:6');
Route::get('/advanced/graph/data/', array('as' => 'mlgdata', 'uses' => 'MasterNodeList@moreLineGraphsData'))->middleware('throttle:6');
Route::get('/nodedetails/', array('as' => 'nodedetails', 'uses' => 'MasterNodeList@nodeDetails'))->middleware('throttle:6');
Route::get('/lastblock', array('uses' => 'MasterNodeList@lastblock'))->middleware('throttle:2');
Route::any('/{coin}/block', function($coin) {
	$cc = new \App\Http\Controllers\coincontrol();
	$process = $cc->block($coin);
	echo $process;
})->middleware('throttle:2');
Route::any('/{coin}/blocknumber/{number}', function($coin,$number) {
	$cc = new \App\Http\Controllers\coincontrol();
	$process = $cc->blocknumber($number);
	echo $process;
})->middleware('throttle:2');

//Route::get('/blocks', array('uses' => 'MasterNodeList@blockprocess'));
//Route::get('/mynode/{secret}/', array('uses' => 'MasterNodeList@myrpinode'));
//Route::post('/rpinode/', array('uses' => 'MasterNodeList@rpinode'));
//Route::get('/checknode/{ip}/{port}', array('uses' => 'NodeCheck@index'));