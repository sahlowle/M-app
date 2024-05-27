<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mall;
use Illuminate\Http\Request;

class CustomerMallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Mall::with('category:id,name')->paginate($per_page);

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mall  $mall
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
}
