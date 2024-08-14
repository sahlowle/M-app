<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Mall;
use App\Models\Museum;
use App\Models\News;
use App\Models\Project;
use App\Models\Restaurant;
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {     
        $count = 3;
        
        $data['hotels'] = Hotel::filter($request)->take($count)->get();
        $data['malls'] = Mall::filter($request)->take($count)->get();
        $data['events'] = Event::filter($request)->take($count)->get();
        $data['museum'] = Museum::filter($request)->take($count)->get();
        $data['news'] = News::filter($request)->take($count)->get();
        $data['restaurants'] = Restaurant::filter($request)->take($count)->get();
        $data['services'] = Service::filter($request)->take($count)->get();
        // $data['projects'] = Project::filter($request)->take($count)->get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

}
