<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreMuseumRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMuseumRequest;
use App\Models\Museum;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminMuseumController extends Controller
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

        $data = Museum::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreMuseumRequest $request)
    {
       $data = $request->validate();

       if ($request->hasFile('image')) {
       $data['image'] = $this->uploadFile('museum_image' , $request->file('image'));
       }

       $museum = Museum::create($data);
       
       return $this->sendResponse(true , $museum , 'museum created successful',200);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $museum = Museum::find($id);

        if (is_null($museum)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$museum,'museum retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateMuseumRequest $request, $id)
    {
        $museum = Museum::find($id);

        if (is_null($museum)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('museum_images',$request->file('image'));

            $path = $museum->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $museum->update($data);

        return $this->sendResponse(true,$museum,'museum updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $museum = Museum::find($id);

        if (is_null($museum)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $museum->getRawOriginal('image');

        $museum->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$museum,'museum deleted successful',200);
    }
}