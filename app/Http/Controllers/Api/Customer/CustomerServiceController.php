<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Service::with('category:id,name')->filter($request)->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);

        if (is_null($service)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $service->load('category:id,name','sliders');

        return $this->sendResponse(true,$service,'service retrieved successful',200);
    }
}
