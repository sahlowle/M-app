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
        
        $data['hotels'] = Hotel::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='hotel';
            return $obj;
        });

        $data['malls'] = Mall::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='mall';
            return $obj;
        });

        $data['events'] = Event::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='event';
            return $obj;
        });
        $data['museum'] = Museum::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='museum';
            return $obj;
        });

        $data['news'] = News::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='news';
            return $obj;
        });

        $data['restaurants'] = Restaurant::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='restaurant';
            return $obj;
        });

        $data['services'] = Service::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='service';
            return $obj;
        });

        $data['projects'] = Project::filter($request)
        ->take($count)->get()
        ->map(function ($obj) {
            $obj->type ='project';
            return $obj;
        });
        
        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

}
