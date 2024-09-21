<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Google_Client;

class SendFcmNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;
    public $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->title = $data['title'];
        $this->body = $data['body'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('customers')->select(['id','fcm_token','device_type'])
        ->orderBy('id')
        ->chunk(100, function (Collection $customers) { 

            $tokens = $customers->pluck('fcm_token');

            foreach ($tokens as $token) {
                $this->sendNotification($this->title,$this->body,$token);
            }
            
        });
    }

    public function sendNotification($title,$body,$firebaseToken)
    {


        $data = [
            "json" => [

                "message" => [

                    "token" => $firebaseToken,

                    "notification" => [
                        "title" => $title,
                        "body" => $body
                    ],

                    'data' => [],
                ]
            ]
        ];

        $dataString = json_encode($data);
    
        $headers = [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ];

        $projectID = 'jodc-4e614';

        $url = 'https://fcm.googleapis.com/v1/projects/'.$projectID.'/messages:send';
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                
        $response = curl_exec($ch);

        // Log::info($response);    
    }

    public function getAccessToken()
    {
        $credentialsPath = storage_path('app/google-services.json'); // Path to your service account file


        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();

        return $token['access_token'];
    }
}
