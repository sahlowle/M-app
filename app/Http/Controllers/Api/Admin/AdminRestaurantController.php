<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminUpdateRestaurantRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreRestaurantRequest;
use App\Models\Restaurant;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminRestaurantController extends Controller
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

        $data = Restaurant::with('category:id,name')->filter($request)->get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRestaurantRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('restaurant_images',$request->file('image'));
        }

        $restaurant = Restaurant::create($data);

        return $this->sendResponse(true,$restaurant,'restaurant created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        if (is_null($restaurant)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $restaurant->load('category:id,name','sliders');

        return $this->sendResponse(true,$restaurant,'restaurant retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRestaurantRequest $request, $id)
    {
        $restaurant = Restaurant::find($id);

        if (is_null($restaurant)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('restaurant_images',$request->file('image'));

            $path = $restaurant->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $restaurant->update($data);

        return $this->sendResponse(true,$restaurant,'restaurant updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);

        if (is_null($restaurant)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $restaurant->getRawOriginal('image');

        $restaurant->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$restaurant,'restaurant deleted successful',200);
    }
}
