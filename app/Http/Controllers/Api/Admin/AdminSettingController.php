<?php

namespace App\Http\Controllers\Api\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;

class AdminSettingController extends Controller
{

    public function update(Request $request)
    {     
        if ($request->filled('android_version')) {
            Setting::updateByKey('android_version',$request->android_version);
        }

        if ($request->filled('ios_version')) {
            Setting::updateByKey('ios_version',$request->ios_version);
        }

        if ($request->filled('google_map_key')) {
            Setting::updateByKey('google_map_key',$request->google_map_key);
        }

        if ($request->filled('google_play_url')) {
            Setting::updateByKey('google_play_url',$request->google_play_url);
        }

        if ($request->filled('apple_store_url')) {
            Setting::updateByKey('apple_store_url',$request->apple_store_url);
        }

        return $this->sendResponse(true,[],'data updated successful',200);
    }

    public function getContacts(Request $request)
    {
        $per_page = $request->get('per_page',$this->default_per_page);

        $data = Contact::get();

        return $this->sendResponse(true,$data,'data retrieved successful',200);
    }

    

}
