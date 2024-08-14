<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminUpdateBenefitRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreBenefitRequest;
use App\Models\Benefit;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminBenefitController extends Controller
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

        $data = Benefit::get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreBenefitRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('benefits_images',$request->file('image'));
        }

        $benefit = Benefit::create($data);

        return $this->sendResponse(true,$benefit,'benefit created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $benefit = Benefit::find($id);

        if (is_null($benefit)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$benefit,'benefits retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateBenefitRequest $request, $id)
    {
        $benefit = Benefit::find($id);

        if (is_null($benefit)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('benefits_images',$request->file('image'));

            $path = $benefit->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $benefit->update($data);

        return $this->sendResponse(true,$benefit,'benefits updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $benefit = Benefit::find($id);

        if (is_null($benefit)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $benefit->getRawOriginal('image');

        $benefit->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$benefit,'benefits deleted successful',200);
    }
}
