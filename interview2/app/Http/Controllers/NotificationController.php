<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function saveToken(Request $request){

        User::where('email', 'test@mail.com')
        ->update([
            'device_token'=>$request->token,
        ]);

        return response()->json([
            'token saved successfully.'
            ]);
    }

    public static function sendNotification(){
        
        $firebaseToken = User::whereNotNull('device_token')
        ->pluck('device_token')
        ->all();

        $SERVER_API_KEY = 'AAAA74ITCps:APA91bGtHnJL2vpsTDHJFRr9yTqT4ZNS5n5QIK1wQftaMCQy6D0eL5gSZljqSku2facmF1eOsQ9srfnoRxdq-mx9-EebX0C0QUvEEqAUSLsFHgfkzL7HenYD2M0ppZoY_1v_KTA4kWyO';

        $data = [

            "registration_ids" => $firebaseToken,

            "notification" => [

                "title" => 'New product',

                "body" => 'New Product is created',  


            ]

        ];

        $dataString = json_encode($data);

    

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

    

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        
        curl_close($ch);
        
    }
}
