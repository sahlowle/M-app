<?php

namespace App\Http\Controllers;

use App\Services\TabbyService;
use Illuminate\Http\Request;

class TabbyController extends Controller
{
    public function pay(Request $request)
    {
        $items = collect([]); // array to save your products

        // add first product
        $items->push([
            'title' => 'title',
            'quantity' => 2,
            'unit_price' => 20,
            'category' => 'Clothes',
        ]);

        $order_data = [
            'amount'=> 199, 
            'currency' => 'SAR',
            'description'=> 'description',
            'full_name'=> 'ALi Omer',
            'buyer_phone'=> '9665252123', 
            'buyer_email' => 'ali@gmail.com',
            'address'=> 'Saudi Riyadh', 
            'city' => 'Riyadh',
            'zip'=> '1234',
            'order_id'=> '1234',
            'registered_since' => now(),
            'loyalty_level'=> 0,
            'success-url'=> route('success-url'),
            'cancel-url' => route('cancel-url'),
            'failure-url' => route('failure-url'),
            'items' => $items,
        ];

        $tabby = new TabbyService();

        // return $tabby->getConfig($order_data);

        

        $payment = $tabby->createSession($order_data);

        // dd($payment);

        $id = $payment->id;

        $redirect_url = $payment->configuration->available_products->installments[0]->web_url;

        return redirect($redirect_url);

    }
}
