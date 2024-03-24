<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreOptionRequest;
use App\Models\Option;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminOptionController extends Controller
{
    use FileSaveTrait;
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreOptionRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('options_images',$request->file('image'));
        }

        $option = Option::create($data);

        return $this->sendResponse(true,$option,'option created successful',200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Option::find($id);

        if (is_null($option)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $option->delete();

        $path = $option->getRawOriginal('image');

        $this->deleteFile($path);

        return $this->sendResponse(true,$option,'option deleted successful',200);
    }
}
