<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;
use Spatie\WebhookServer\WebhookCall;

class ProductController extends Controller
{
    public function store(Request $request){

        $data = [
            'product_name'  => $request->product_name,
            'size'          => $request->size,
            'price'         => $request->price,
            'quantity'      => $request->quantity,
        ];


        $headers = array("Content-Type:multipart/form-data");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('appurl').'/api/create/product');
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        
        NotificationController::sendNotification();
        
        $product = [
            'product_name'  => $request->product_name,
            'size'          => $request->size,
            'price'         => $request->price,
            'quantity'      => $request->quantity,
        ];

        WebhookCall::create()
        ->url(env('appurl').'/webhook-receiving-url')
        ->payload(['product' => $product])
        ->useSecret('mysecretkey')
        ->dispatch();

        return response()->json($data);
        
    }

    public function view(){

        $url = env('appurl')."/api/product/view";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

       
        return view('product', compact('response_a'));
    }
}
