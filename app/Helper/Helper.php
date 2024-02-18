<?php

namespace App\Helpers;

Class Helper {

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
