<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreSampleRequest;

use App\Models\Project;
use App\Models\Sample;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminSampleController extends Controller
{
    use FileSaveTrait;
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreSampleRequest $request)
    {
        $data = $request->only('name');

        $project = Project::find($request->project_id);

        if (is_null($project)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data['image'] = $this->uploadFile('samples_images',$request->file('image'));

        $sample = $project->samples()->create($data);
     
        return $this->sendResponse(true,$sample,'sample created successful',200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sample = Sample::find($id);

        if (is_null($sample)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $sample->getRawOriginal('image');

        $sample->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$sample,'sample deleted successful',200);
    }
}
