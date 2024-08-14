<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ClickHotelRequest;

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

        $data = Hotel::withSum('customersClicks as total_clicks','customer_hotel.clicks_count')->paginate($per_page);

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

        $hotel->loadSum('customersClicks as total_clicks','customer_hotel.clicks_count');

        return $this->sendResponse(true,$hotel,'hotel retrieved successful',200);
    }

    public function clickHotel(ClickHotelRequest $request)
    {
        $customer = $request->user();

        $hotel_id = $request->hotel_id;

        $hotel = $customer->hotelClicks()->find($hotel_id);

        if (is_null($hotel)) {
            $customer->hotelClicks()->attach($hotel_id,['clicks_count' => 1]);
        } else {
            $hotel->pivot->increment('clicks_count');
        }

        return $this->sendResponse(true,$hotel,'request added successful',200);
    }
}
