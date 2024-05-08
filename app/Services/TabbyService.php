<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TabbyService 
{
    public $base_url = "https://api.tabby.ai/api/v2/";
    public $pk_test = "pk_test_632383e3-0b7d-4674-b07a-94c5359dedac";
    public $sk_test = "sk_test_fcc4c64c-5924-4fd2-8ad8-a9860aec9c3f";

    public function createSession($data)
    {
        $body = $this->getConfig($data);

        $http = Http::acceptJson()->withToken($this->pk_test)->baseUrl($this->base_url);

        $response = $http->post('checkout',$body);

        return $response->object();
    }

    public function getSession($payment_id)
    {
        $http = Http::withToken($this->sk_test)->baseUrl($this->base_url);

        $url = 'checkout/'.$payment_id;

        $response = $http->get($url);

        return $response->object();
    }

    public function getConfig($data)
    {
        $body= [];

        $body = [
            "payment" => [
                "amount" => $data['amount'],
                "currency" => $data['currency'],
                "description" =>  $data['description'],
                "buyer" => [
                    "phone" => $data['buyer_phone'],
                    "email" => $data['buyer_email'],
                    "name" => $data['full_name'],
                    // "dob" => "",
                ],
                "shipping_address" => [
                    "city" => $data['city'],
                    "address" =>  $data['address'],
                    "zip" => $data['zip'],
                ],
                "order" => [
                    "tax_amount" => "0.00",
                    "shipping_amount" => "0.00",
                    "discount_amount" => "0.00",
                    "updated_at" => now()->toIso8601String(),
                    "reference_id" => $data['order_id'],
                    "items" => 
                        $data['items']
                    ,
                ],
                "buyer_history" => [
                    "registered_since"=> now()->subYear()->toIso8601String(),
                    "loyalty_level"=> $data['loyalty_level'],
                ],
            ],
            "lang" => app()->getLocale(),
            "merchant_code" => "Frada PL",
            "merchant_urls" => [
                "success" => $data['success-url'],
                "cancel" => $data['cancel-url'],
                "failure" => $data['failure-url'],
            ]
        ];

        return $body;
    }
}
