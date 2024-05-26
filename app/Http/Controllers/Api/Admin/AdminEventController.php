<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\Admin\AdminStoreEventRequest;
use App\Http\Requests\Api\Admin\AdminUpdateEventRequest;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;

class AdminEventController extends Controller
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

        $data = Event::paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreEventRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('event_images',$request->file('image'));
        }

        $event = Event::create($data);

        return $this->sendResponse(true,$event,'hotel created successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$event,'hotel retrieved successful',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateEventRequest $request, $id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile('event_images',$request->file('image'));

            $path = $event->getRawOriginal('image');

            $this->deleteFile($path);
        }

        $event->update($data);

        return $this->sendResponse(true,$event,'hotel updated successful',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }
        
        $path = $event->getRawOriginal('image');

        $event->delete();

        $this->deleteFile($path);

        return $this->sendResponse(true,$event,'event deleted successful',200);
    }
}
