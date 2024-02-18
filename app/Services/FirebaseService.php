<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public static function sendNotification($title,$body,$extra_data,Collection $tokens)
    {
        $SERVER_API_KEY = 'AAAAWwdHJko:APA91bF9tlrFfh97PgPuWIVMb7MWmg1fVCZqZ9U5UVEEmWYOzySi7_IWFVfvo8HnPdkToxHfwOx_P-J-HVH-uOBog2Ul2aaskh1h1bGb-TjkmjTQuCTRIcoLqdmOVTSPHmDDj4aktMs4';

        $headers = [

            'Authorization' => 'key=' . $SERVER_API_KEY,

            'Content-Type'=>'application/json',

        ];
        
        //initial request
        $http = Http::withHeaders($headers);
        
        //chunk tokens
        foreach ($tokens->chunk(100) as $firebaseToken){
            $data = [

                "registration_ids" => $firebaseToken,
    
                "notification" => [
                    "title" => $title,
    
                    "body" => $body,

                    "sound" => "custom_sound.mp3"
                ],

                "data"=> $extra_data,
                
                "priority"=>"high"
    
            ];

            $response = $http->post('https://fcm.googleapis.com/fcm/send',$data);

            $response->object();
        }

        
    }
}