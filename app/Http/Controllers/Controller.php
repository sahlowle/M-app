<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $default_per_page = 10;
    /*
   |--------------------------------------------------------------------------
   | api response fun
   |--------------------------------------------------------------------------
   */
    function sendResponse($success, $data, $message, $code){
        
        $response = [
            'success' =>  $success,
            'message' => $message,
            'data'  =>   $data,
            'code' =>    $code,
        ];
        
        return response()->json($response, $code);
    }
}
