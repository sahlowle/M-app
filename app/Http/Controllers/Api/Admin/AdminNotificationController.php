<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreNotificationRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMuseumRequest;
use App\Jobs\SendFcmNotifications;
use App\Models\Museum;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{

    use FileSaveTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $data = Museum::with('sliders')->first();

        // return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreNotificationRequest $request)
    {
        $data = $request->validated();

        SendFcmNotifications::dispatch($data);

        return $this->sendResponse(true , $data , 'notification sent successful',200);
       
    }

 

}
