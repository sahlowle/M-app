<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreMallRequest;
use App\Http\Requests\Api\Admin\AdminUpdateMallRequest;
use App\Models\Mall;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminMallController extends Controller
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

        $data = Mall::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreMallRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('mall_images',$request->file('image'));
        }

        $mall = Mall::create($data);

        return $this->sendResponse(true,$mall,'mall created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mall = Mall::find($id);

        if (is_null($mall)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $mall->load('category:id,name','sliders');

        return $this->sendResponse(true,$mall,'mall retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateMallRequest $request, $id)
    {
        $mall = Mall::find($id);

        if (is_null($mall)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('mall_images',$request->file('image'));

            $path = $mall->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $mall->update($data);

        return $this->sendResponse(true,$mall,'mall updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mall = Mall::find($id);

        if (is_null($mall)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $mall->getRawOriginal('image');

        $mall->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$mall,'mall deleted successful',200);
    }
}
