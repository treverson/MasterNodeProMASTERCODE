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