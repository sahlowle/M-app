<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class CustomerEventController extends Controller
{
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
     * Display the specified resource.
     */
    
    public function show($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $event->load('sliders');

        return $this->sendResponse(true,$event,'event retrieved successful',200);
    }
}
