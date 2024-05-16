<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PaymentGatewayController extends Controller
{
    //get token
    public function getToken(){
        $base_url = "https://qrpay.appdevs.net/pay/sandbox/api/v1";
        $response = Http::post($base_url .'/authentication/token', [
            'client_id' => "tRCDXCuztQzRYThPwlh1KXAYm4bG3rwWjbxM2R63kTefrGD2B9jNn6JnarDf7ycxdzfnaroxcyr5cnduY6AqpulRSebwHwRmGerA",
            'secret_id' =>   "oZouVmqHCbyg6ad7iMnrwq3d8wy9Kr4bo6VpQnsX6zAOoEs4oxHPjttpun36JhGxDl7AUMz3ShUqVyPmxh4oPk3TQmDF7YvHN5M3",
        ]);
        $statusCode = $response->getStatusCode();
        $result = json_decode($response->getBody()->getContents(),true);

        if ($statusCode != 200) {
            $data = [
                'code' => $errorArray['message']['code']??400,
                'message' => "Access token capture failed",
                'token' => '',
            ];
        }else{
            $data = [
                'code' => $result['message']['code']??200,
                'message' =>  $result['type'],
                'token' => $result['data']['access_token']??"",

            ];

        }
        return (object)$data;

    }
    //payment initiate
    public function initiatePayment(Request $request){
        $validator = Validator::make($request->all(), [
            'amount'         => "required|string|max:60"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $validated =$validator->validate();
        $access_token_info = $this->getToken();
        if($access_token_info->code != 200){
            return back()->with(['error' => [$access_token_info->message]]);
        }else{
            $access_token =   $access_token_info->token??'';
        }

        try{
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://qrpay.appdevs.net/pay/sandbox/api/v1/payment/create', [
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

        }catch(Exception $e){
            $errorMessage = $e->getMessage();
            $errorArray = [];
            if (preg_match('/{.*}/', $errorMessage, $matches)) {
                $errorArray = json_decode($matches[0], true);
            }
            if(isset($errorArray['message']['error'][0])){
                return back()->with(['error' => [ $errorArray['message']['error'][0]]]);
            }else{
                return back()->with(['error' => ["Something Is Wrong, Please Try Again Later"]]);
            }


        }

    }
    //after pay success
    public function paySuccess(Request $request){
        $getResponse = $request->all();
        if( $getResponse['type'] == 'success'){
           //write your needed code here
           return redirect()->route('pay.page')->with(['success' => ['Your Payment Done Successfully']]);
        }

    }
    //after cancel payment
    public function payCancel(Request $request){
        //write your needed code here
        return redirect()->route('pay.page')->with(['error' => ['Your Payment Cancel Successfully']]);
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
}
