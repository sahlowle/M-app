<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class CustomerNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = News::paginate($per_page);

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
        $news = News::find($id);

        if (is_null($news)) {
            return $this->sendResponse(false ,[] ,"data not found ",404);
        }

        return $this->sendResponse(true,$news,'news retrieved successful',200);
    }
}
