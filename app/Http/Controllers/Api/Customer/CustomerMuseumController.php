<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Museum;
use Illuminate\Http\Request;

class CustomerMuseumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Museum::with('category:id,name')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Museum  $museum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $museum = Museum::find($id);

        if (is_null($museum)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        $museum->load('category:id,name','sliders');

        return $this->sendResponse(true,$museum,'museum retrieved successful',200);
    }
}
