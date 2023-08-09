<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends Controller
{
    public function getToken(){
        $client = new Client();
        $response = $client->request('POST', 'https://mehedi.appdevs.net/qrpay-v2.0.0/pay/sandbox/api/v1/authentication/token', [
            'json' => [
                'client_id' => "tRCDXCuztQzRYThPwlh1KXAYm4bG3rwWjbxM2R63kTefrGD2B9jNn6JnarDf7ycxdzfnaroxcyr5cnduY6AqpulRSebwHwRmGerA",
                'secret_id' =>   "oZouVmqHCbyg6ad7iMnrwq3d8wy9Kr4bo6VpQnsX6zAOoEs4oxHPjttpun36JhGxDl7AUMz3ShUqVyPmxh4oPk3TQmDF7YvHN5M3",
            ],
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);
        $result = json_decode($response->getBody(),true);
        return $result['data']['access_token']??"";
    }

    public function initiatePayment(Request $request){
        $validator = Validator::make($request->all(), [
            'amount'         => "required|string|max:60"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated =$validator->validate();
        $access_token = $this->getToken();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://mehedi.appdevs.net/qrpay-v2.0.0/pay/sandbox/api/v1/payment/create', [
        'json' => [
                'amount' =>     $validated['amount'],
                'currency' =>   "USD",
                'return_url' =>     route('pay.success'),
                'cancel_url' =>     route('pay.cancel'),
                'custom' =>       $this->custom_random_string(10),
            ],
        'headers' => [
            'Authorization' => 'Bearer '. $access_token,
            'accept' => 'application/json',
            'content-type' => 'application/json',
            ],
        ]);
        $result = json_decode($response->getBody(),true);
        return redirect($result['data']['payment_url']);

    }

    //custom transaction id which can use your project transaction
    function custom_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $char_length - 1)];
        }
        return $random_string;
    }
    //after pay success
    public function paySuccess(Request $request){
        $getResponse = $request->all();
        // dd( $getResponse);
        if( $getResponse['type'] == 'success'){
           //write your need code here
           $notify[] = ['success', 'Your Payment Done Successfully'];
           return  redirect()->route('pay.page')->withNotify($notify);
        }

    }
    public function payCancel(Request $request){
        $notify[] = ['error', 'Your Payment Cancel Successfully'];
        return  redirect()->route('pay.page')->withNotify($notify);
    }
}
