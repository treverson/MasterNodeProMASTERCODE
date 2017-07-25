<?php

use Illuminate\Http\Request;
use App\Mnl;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->post(
	'/tag/', function (Request $request) {
	$body         = json_decode($request->getContent(), true);
	$data_string = json_encode($body);
	$ch = curl_init('http://' . env('LOCAL_IP') . '/tagWallet.php');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					   'Content-Type: application/json',
					   'Content-Length: ' . strlen($data_string))
	);
	$result = curl_exec($ch);
	if ($result === "true") {
		$mnl = Mnl::where('addr', $body['addr'])->first();
		if (count($mnl) > 0) {
			$data = json_decode($mnl->data,true);
			$data['tag'] = $body['tagName'];
			$data['userIDMNP'] = $body['userIDMNP'];
			$mnl->data = json_encode($data);
			$mnl->save();
			echo "Tagged It";
		}
	}
}
);