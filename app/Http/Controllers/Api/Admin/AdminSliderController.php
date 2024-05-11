<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreSliderRequest;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Mall;
use App\Models\Museum;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    use FileSaveTrait;
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreSliderRequest $request)
    {
        $model = match ($request->type){
            'hotel' => Hotel::class,
            'mall' => Mall::class,
            'museum' => Museum::class,
        };

        $instance = $model::find($request->id);

        if (is_null($instance)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data['image'] = $this->uploadFile('sliders_images',$request->file('image'));

        $instance->sliders()->create($data);
     
        return $this->sendResponse(true,[],'slider created successful',200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Image::find($id);

        if (is_null($slider)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $slider->getRawOriginal('image');

        $slider->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$slider,'slider deleted successful',200);
    }
}
