<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreInterestedRequest;
use App\Models\Interested;
use App\Models\Project;
use Illuminate\Http\Request;

class CustomerProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Project::withCount('samples')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

  
    public function show($id)
    {
        $project = Project::find($id);

        if (is_null($project)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $project->loadCount('samples');

        $project->load('sliders','samples','usersInterested');

        return $this->sendResponse(true,$project,'project retrieved successful',200);
    }

    public function addInterestedUser(StoreInterestedRequest $request)
    {
        $data = $request->validated();

        $interested = Interested::create($data);

        return $this->sendResponse(true,$interested,'interested added successful',200);
    }
}
