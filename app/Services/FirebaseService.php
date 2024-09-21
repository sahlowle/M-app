<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Google_Client;

class FirebaseService
{
    public static function sendNotification($title,$body,$extra_data,Collection $tokens)
    {
        $access_token = self::getAccessToken();
        
        //initial request
        $http = Http::acceptJson()->withToken($access_token);
        
        //chunk tokens
        foreach ($tokens as $firebaseToken){

            $data = [
                "json" => [

                    "message" => [

                        "token" => $firebaseToken,

                        "notification" => [
                            "title" => $title,
                            "body" => $body
                        ],

                        'data' => $extra_data,
                    ]
                ]
            ];


            $projectID = 'jodc-4e614';

            $response = $http->post('https://fcm.googleapis.com/v1/projects/'.$projectID.'/messages:send',$data);

            $response->object();
        }

        
    }


    static function getAccessToken()
    {
        $credentialsPath = storage_path('app/google-services.json'); // Path to your service account file


        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();

        return $token['access_token'];
    }
}