<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminUpdateRestaurantRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreRestaurantRequest;
use App\Models\Service;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminServicesController extends Controller
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

        $data = Service::with('category:id,name')->filter($request)->get();

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
            $data['image'] = $this->uploadFile('service_images',$request->file('image'));
        }

        $service = Service::create($data);

        return $this->sendResponse(true,$service,'service created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRestaurantRequest $request, $id)
    {
        $service = Service::find($id);

        if (is_null($service)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('service_images',$request->file('image'));

            $path = $service->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $service->update($data);

        return $this->sendResponse(true,$service,'service updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if (is_null($service)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $service->getRawOriginal('image');

        $service->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$service,'service deleted successful',200);
    }
}
