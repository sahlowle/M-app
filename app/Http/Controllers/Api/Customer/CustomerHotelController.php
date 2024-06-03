<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class CustomerHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Hotel::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::find($id);

        if (is_null($hotel)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $hotel->load('options','sliders');

        return $this->sendResponse(true,$hotel,'hotel retrieved successful',200);
    }
}
