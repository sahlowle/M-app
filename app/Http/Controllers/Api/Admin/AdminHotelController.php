<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreHotelRequest;
use App\Http\Requests\Api\Admin\AdminUpdateHotelRequest;
use App\Models\Category;
use App\Models\Hotel;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHotelController extends Controller
{
    use FileSaveTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        // $data = Hotel::withSum('customersClicks as total_clicks','customer_hotel.clicks_count')->get();


        $data = Hotel::withSum(['customersClicks as total_clicks' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(customer_hotel.clicks_count), 0)'));
        }],'customer_hotel.clicks_count')
        ->get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreHotelRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('hotel_images',$request->file('image'));
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadFile('hotel_images',$request->file('logo'));
        }

        $hotel = Hotel::create($data);

        return $this->sendResponse(true,$hotel,'hotel created successful',200);
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

        $hotel->loadSum(['customersClicks as total_clicks' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(customer_hotel.clicks_count), 0)'));
        }],'customer_hotel.clicks_count');

        $hotel->load(['options','sliders','customersClicks'=> function ($query) {
            $query->latest()->limit(2);
        }]);

        return $this->sendResponse(true,$hotel,'hotel retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateHotelRequest $request, $id)
    {
        $hotel = Hotel::find($id);

        if (is_null($hotel)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('hotel_images',$request->file('image'));

            $path = $hotel->getRawOriginal('image');

            $this->deleteFile($path);
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadFile('hotel_images',$request->file('logo'));

            $path = $hotel->getRawOriginal('logo');

            $this->deleteFile($path);
        }

        $hotel->update($data);

        return $this->sendResponse(true,$hotel,'hotel updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);

        if (is_null($hotel)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $path = $hotel->getRawOriginal('image');

        $hotel->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$hotel,'hotel deleted successful',200);
    }
}
