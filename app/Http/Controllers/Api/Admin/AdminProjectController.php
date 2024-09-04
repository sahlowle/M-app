<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminUpdateProjectRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AdminStoreProjectRequest;
use App\Models\Project;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
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

        $data = Project::withCount('samples')->get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreProjectRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('projects_images',$request->file('image'));
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $this->uploadFile('projects_files',$request->file('pdf_file'));
        }

        $project = Project::create($data);

        return $this->sendResponse(true,$project,'project created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $project->loadCount('samples');

        $project->load('sliders','samples','usersInterested');

        return $this->sendResponse(true,$project,'projects retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateProjectRequest $request, $id)
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('projects_images',$request->file('image'));

            $path = $project->getRawOriginal('image');

            $this->deleteFile($path);
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $this->uploadFile('projects_files',$request->file('pdf_file'));

            $path = $project->getRawOriginal('pdf_file');

            $this->deleteFile($path);
        }

        $project->update($data);

        return $this->sendResponse(true,$project,'projects updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $image_path = $project->getRawOriginal('image');
        $pdf_path = $project->getRawOriginal('pdf_file');

        $project->delete();

        $this->deleteFile($image_path);
        $this->deleteFile($pdf_path);

        return $this->sendResponse(true,$project,'projects deleted successful',200);
    }
}
