<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\Hotel\HotelRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;


class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
    
        $hotel =  Hotel::all();
        return $hotel->response()->setStatusCode(200);
    }

    public function create(HotelRequest $request)
    {
      
       $data = $request->validated();
       $hotel =  Hotel::create($data);;
       return $this->sendResponse(true,$hotel,'User Created Successfully',200);
    }

    public function show($id)
    {
    
      $hotel = Hotel::findOrFail($id);

      return $hotel->response()->setStatusCode(200, 'User Returned Successfully')
      ->header('Additional Header', 'True');
    }

    public function update(HotelRequest $request,  $id)
    {
        $data = $request->validated();
        $hotel = Hotel::findOrFail($id);
        $hotel->update($data);
        return $this->sendResponse(true,$hotel,'User Created Successfully',200);
    }

    public function destroy($id)
    {
        Hotel::find($id)->delete();
        return 204;
    }
}
