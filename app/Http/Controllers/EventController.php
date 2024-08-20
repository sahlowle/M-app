<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function send() {
        
        event(new \App\Events\SendMessage());
        return "BY";
     }
}
