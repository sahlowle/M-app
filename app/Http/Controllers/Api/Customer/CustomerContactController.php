<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreContactRequest;
use App\Models\Contact;

class CustomerContactController extends Controller
{
   
    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $contact = Contact::create($data);

        return $this->sendResponse(true,$contact,'contact added successful',200);
    }
}
